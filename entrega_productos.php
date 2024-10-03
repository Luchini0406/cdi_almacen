<?php
session_start();
include 'conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Inicializa la lista de productos seleccionados si no existe
if (!isset($_SESSION['productos_seleccionados'])) {
    $_SESSION['productos_seleccionados'] = [];
}

// Obtener todos los productos disponibles
$sql_productos = "SELECT * FROM productos WHERE cantidad > 0";
$result_productos = mysqli_query($conn, $sql_productos);

if (!$result_productos) {
    die("Error al obtener los productos: " . mysqli_error($conn));
}

// Obtener todos los beneficiarios
$sql_beneficiarios = "SELECT * FROM beneficiarios";
$result_beneficiarios = mysqli_query($conn, $sql_beneficiarios);

if (!$result_beneficiarios) {
    die("Error al obtener los beneficiarios: " . mysqli_error($conn));
}

$beneficiarios = mysqli_fetch_all($result_beneficiarios, MYSQLI_ASSOC);
$beneficiario_seleccionado = null;
$puntos_disponibles = 0;

// Buscar beneficiario por código
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar_beneficiario'])) {
    $codigo_beneficiario = $_POST['codigo_beneficiario'];

    // Consulta los puntos del beneficiario
    $sql_puntos = "SELECT * FROM beneficiarios WHERE codigo = '$codigo_beneficiario'";
    $result_puntos = mysqli_query($conn, $sql_puntos);

    if (!$result_puntos) {
        die("Error al obtener los puntos del beneficiario: " . mysqli_error($conn));
    }

    $beneficiario_seleccionado = mysqli_fetch_assoc($result_puntos);
    if ($beneficiario_seleccionado) {
        $puntos_disponibles = $beneficiario_seleccionado['puntos'];
    }
}

// Procesar la adición de productos a la lista
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_producto'])) {
    $codigo_beneficiario = $_POST['codigo_beneficiario'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    // Consulta del producto seleccionado
    $sql_producto = "SELECT * FROM productos WHERE Item = '$producto_id'";
    $result_producto = mysqli_query($conn, $sql_producto);

    if (!$result_producto) {
        die("Error al obtener el producto: " . mysqli_error($conn));
    }

    $producto = mysqli_fetch_assoc($result_producto);

    // Agregar producto a la lista de productos seleccionados
    if ($producto) {
        $_SESSION['productos_seleccionados'][] = [
            'producto_id' => $producto['Item'],
            'nombre' => $producto['nombre'],
            'puntos' => $producto['puntos'],
            'cantidad' => $cantidad
        ];
    }
}

// Procesar la eliminación de un producto seleccionado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eliminar_producto'])) {
    $index = $_POST['index'];
    if (isset($_SESSION['productos_seleccionados'][$index])) {
        unset($_SESSION['productos_seleccionados'][$index]);
        $_SESSION['productos_seleccionados'] = array_values($_SESSION['productos_seleccionados']); // Reindexar el array
    }
}

// Procesar la entrega final de los productos seleccionados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['entregar_productos'])) {
    $codigo_beneficiario = $_POST['codigo_beneficiario'];

    // Consulta los puntos del beneficiario
    $sql_puntos = "SELECT puntos FROM beneficiarios WHERE codigo = '$codigo_beneficiario'";
    $result_puntos = mysqli_query($conn, $sql_puntos);

    if (!$result_puntos) {
        die("Error al obtener los puntos del beneficiario: " . mysqli_error($conn));
    }

    $beneficiario = mysqli_fetch_assoc($result_puntos);
    $puntos = $beneficiario['puntos'];
    $costo_total = 0;

    // Calcular el costo total de los productos seleccionados
    foreach ($_SESSION['productos_seleccionados'] as $producto) {
        $costo_total += $producto['puntos'] * $producto['cantidad'];
    }

    if ($puntos >= $costo_total) {
        // Actualizar los puntos del beneficiario
        $nuevo_puntaje = $puntos - $costo_total;
        $sql_actualizar_puntos = "UPDATE beneficiarios SET puntos = '$nuevo_puntaje' WHERE codigo = '$codigo_beneficiario'";
        if (!mysqli_query($conn, $sql_actualizar_puntos)) {
            die("Error al actualizar los puntos del beneficiario: " . mysqli_error($conn));
        }

        // Actualizar la cantidad de cada producto
        foreach ($_SESSION['productos_seleccionados'] as $producto) {
            $sql_producto = "SELECT cantidad FROM productos WHERE Item = '{$producto['producto_id']}'";
            $result_producto = mysqli_query($conn, $sql_producto);

            if (!$result_producto) {
                die("Error al obtener la cantidad del producto: " . mysqli_error($conn));
            }

            $producto_db = mysqli_fetch_assoc($result_producto);
            $nueva_cantidad = $producto_db['cantidad'] - $producto['cantidad'];

            $sql_actualizar_cantidad_producto = "UPDATE productos SET cantidad = '$nueva_cantidad' WHERE Item = '{$producto['producto_id']}'";
            if (!mysqli_query($conn, $sql_actualizar_cantidad_producto)) {
                die("Error al actualizar la cantidad del producto: " . mysqli_error($conn));
            }
        }

        // Limpiar la lista de productos seleccionados
        $_SESSION['productos_seleccionados'] = [];
        echo "<div class='mensaje-exito'>Productos entregados con éxito.</div>";
    } else {
        echo "<div class='mensaje-error'>No tienes suficientes puntos para realizar esta entrega.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrega de Productos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Entrega de Productos a Beneficiarios</h1>

    <div class="form-container">
        <h2>Buscar Beneficiario por Código</h2>
        <form method="post" action="entrega_productos.php">
            <label for="codigo_beneficiario">Código del beneficiario:</label>
            <input type="text" name="codigo_beneficiario" required>
            <input type="submit" name="buscar_beneficiario" value="Buscar">
        </form>
    </div>

    <?php if ($beneficiario_seleccionado): ?>
        <div class="info-beneficiario">
            <h3>Beneficiario: <?php echo $beneficiario_seleccionado['nombre'] . " " . $beneficiario_seleccionado['apellido']; ?></h3>
            <p>Puntos disponibles: <?php echo $puntos_disponibles; ?></p>
        </div>
    <?php endif; ?>

    <div class="form-container">
        <h2>Seleccionar Productos para Entrega</h2>
        <form method="post" action="entrega_productos.php">
            <label for="codigo_beneficiario">Selecciona un beneficiario:</label>
            <select name="codigo_beneficiario" required>
                <?php foreach ($beneficiarios as $beneficiario): ?>
                    <option value="<?php echo $beneficiario['codigo']; ?>" <?php echo isset($beneficiario_seleccionado) && $beneficiario_seleccionado['codigo'] == $beneficiario['codigo'] ? 'selected' : ''; ?>>
                        <?php echo $beneficiario['nombre'] . " " . $beneficiario['apellido']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="producto_id">Selecciona un producto:</label>
            <select name="producto_id" required>
                <?php while ($producto = mysqli_fetch_assoc($result_productos)): ?>
                    <option value="<?php echo $producto['Item']; ?>">
                        <?php echo $producto['nombre'] . " - " . $producto['puntos'] . " puntos (Quedan " . $producto['cantidad'] . " unidades)"; ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" value="1" min="1" required><br><br>

            <input type="submit" name="agregar_producto" value="Agregar Producto">
        </form>
    </div>

    <div class="productos-seleccionados">
        <h2>Productos Seleccionados</h2>
        <form method="post" action="entrega_productos.php">
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Puntos por Producto</th>
                    <th>Total Puntos</th>
                    <th>Acción</th>
                </tr>
                <?php foreach ($_SESSION['productos_seleccionados'] as $index => $producto): ?>
                    <tr>
                    <td><?php echo $producto['nombre']; ?></td>
                        <td><?php echo $producto['cantidad']; ?></td>
                        <td><?php echo $producto['puntos']; ?></td>
                        <td><?php echo $producto['puntos'] * $producto['cantidad']; ?></td>
                        <td>
                            <form method="post" action="beneficiarios.php">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <input type="submit" name="eliminar_producto" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </form>
    </div>

    <div class="form-container">
        <h2>Entregar Productos</h2>
        <form method="post" action="entrega_productos.php">
            <input type="hidden" name="codigo_beneficiario" value="<?php echo $beneficiario_seleccionado['codigo']; ?>">
            <input type="submit" name="entregar_productos" value="Entregar Productos">
        </form>
    </div>

    <a href="beneficiarios.php"><input type="button" value="Regresar a Gestión de Beneficiarios"></a>
</div>

</body>
</html>


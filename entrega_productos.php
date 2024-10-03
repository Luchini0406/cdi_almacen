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

// Variables para mantener el beneficiario seleccionado y puntos disponibles
$beneficiario_seleccionado = null;
$puntos_disponibles = 0;

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

// Mantener el beneficiario seleccionado entre las solicitudes
if (isset($_POST['codigo_beneficiario'])) {
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

        echo "<div class='mensaje-exito'>Productos entregados con éxito.</div>";
    } else {
        echo "<div class='mensaje-error'>No tienes suficientes puntos para realizar esta entrega.</div>";
    }
}

// Procesar la limpieza de la lista de productos seleccionados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['limpiar_productos'])) {
    $_SESSION['productos_seleccionados'] = []; // Limpiar la lista de productos seleccionados
}

// Obtener la fecha actual
$fecha_entrega = date('Y-m-d H:i:s');

// Actualizar la cantidad de cada producto y registrar la entrega
foreach ($_SESSION['productos_seleccionados'] as $producto) {
    $sql_producto = "SELECT cantidad FROM productos WHERE Item = '{$producto['producto_id']}'";
    $result_producto = mysqli_query($conn, $sql_producto);

    if (!$result_producto) {
        die("Error al obtener la cantidad del producto: " . mysqli_error($conn));
    }

    $producto_db = mysqli_fetch_assoc($result_producto);
    $nueva_cantidad = $producto_db['cantidad'] - $producto['cantidad'];

    // Actualizar la cantidad del producto
    $sql_actualizar_cantidad_producto = "UPDATE productos SET cantidad = '$nueva_cantidad' WHERE Item = '{$producto['producto_id']}'";
    if (!mysqli_query($conn, $sql_actualizar_cantidad_producto)) {
        die("Error al actualizar la cantidad del producto: " . mysqli_error($conn));
    }

    // Registrar la entrega en la tabla de entregas
    $puntos_gastados = $producto['puntos'] * $producto['cantidad'];
    $sql_registrar_entrega = "INSERT INTO entregas (codigo_beneficiario, producto_id, cantidad, puntos_gastados, fecha_entrega) 
                              VALUES ('$codigo_beneficiario', '{$producto['producto_id']}', '{$producto['cantidad']}', '$puntos_gastados', '$fecha_entrega')";
    if (!mysqli_query($conn, $sql_registrar_entrega)) {
        die("Error al registrar la entrega: " . mysqli_error($conn));
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
            <input type="text" name="codigo_beneficiario" value="<?php echo isset($codigo_beneficiario) ? $codigo_beneficiario : ''; ?>" required>
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
            <input type="hidden" name="codigo_beneficiario" value="<?php echo isset($codigo_beneficiario) ? $codigo_beneficiario : ''; ?>">
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

    <?php if (!empty($_SESSION['productos_seleccionados'])): ?>
        <div class="productos-seleccionados">
            <h3>Productos Seleccionados:</h3>
            <ul>
                <?php foreach ($_SESSION['productos_seleccionados'] as $index => $producto): ?>
                    <li><?php echo $producto['nombre'] . " - " . $producto['puntos'] . " puntos (Cantidad: " . $producto['cantidad'] . ")"; ?>
                        <form method="post" action="entrega_productos.php" style="display:inline;">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <input type="submit" name="eliminar_producto" value="Eliminar">
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>

            <form method="post" action="entrega_productos.php">
                <input type="hidden" name="codigo_beneficiario" value="<?php echo isset($codigo_beneficiario) ? $codigo_beneficiario : ''; ?>">
                <input type="submit" name="entregar_productos" value="Entregar Productos">
            </form>

            <form method="post" action="entrega_productos.php">
                <input type="submit" name="limpiar_productos" value="Limpiar Lista de Productos">
            </form>
        </div>
    <?php endif; ?>
<br><br>
  <!-- Botón para imprimir recibo -->
  <form method="post" action="imprimir.php" target="_blank">
        <input type="hidden" name="codigo_beneficiario" value="<?php echo $beneficiario_seleccionado['codigo']; ?>">
        <input type="submit" name="imprimir_recibo" value="Imprimir Recibo">
    </form>
</div>
    </div>
</div>

  



    <a href="beneficiarios.php"><input type="button" value="Regresar a Gestión de Beneficiarios"></a>
</div>

</body>
</html>


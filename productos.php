<?php
session_start();
include 'conexion.php'; // Incluimos la conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Variable para almacenar los productos
$productos = [];

// Verificar si se ha enviado un Item para la búsqueda
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_producto'])) {
    $item_producto = $_POST['item_producto'];

    // Buscar producto por el Item ingresado
    $sql_productos = "SELECT * FROM productos WHERE Item = '$item_producto'";
    $result_productos = mysqli_query($conn, $sql_productos);

    // Verificar si hay productos con ese Item
    if (mysqli_num_rows($result_productos) > 0) {
        $productos = mysqli_fetch_all($result_productos, MYSQLI_ASSOC);
    } else {
        echo "No se encontró ningún producto con ese Item.";
    }
} else {
    // Si no se ha enviado un Item, mostrar todos los productos
    $sql_productos = "SELECT * FROM productos";
    $result_productos = mysqli_query($conn, $sql_productos);
    $productos = mysqli_fetch_all($result_productos, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlazar la hoja de estilos -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>

<h1>Gestión de Productos.</h1>
<a href="home.php"><input type="submit" value="Regresar al inicio"></a>
</body>
<!-- Formulario para buscar producto por Item -->
<h2>Buscar Producto por Item</h2>
<form method="post" action="productos.php">
    <label for="item_producto">Item del producto:</label>
    <input type="text" name="item_producto" required>
    <input type="submit" value="Buscar">
</form>

<!-- Mostrar la lista de productos -->
<h2>Lista de Productos</h2>
<!-- Agregar enlaces para agregar, editar y eliminar productos -->
<a href="agregar_productos.php">Agregar Producto</a>

<?php if (!empty($productos)): ?>
<table>
    <tr>
        <th>Item</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Puntos</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($productos as $producto): ?>
        <tr>
            <td><?php echo $producto['Item']; ?></td>
            <td><?php echo $producto['nombre']; ?></td>
            <td><?php echo $producto['descripcion']; ?></td>
            <td><?php echo $producto['cantidad']; ?></td>
            <td><?php echo $producto['puntos']; ?></td>
            <td>
                <a href="editar_productos.php?item=<?php echo $producto['Item']; ?>">Editar</a>
                <a href="eliminar_productos.php?item=<?php echo $producto['Item']; ?>">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php endif; ?>

<br>
</body>
</html>

<br>
<a href="home.php"><input type="submit" value="Regresar al inicio"></a>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Enlazar la hoja de estilos -->
</head>
<body>
<div class="header">
    <h1>Gestión de Productos</h1>
</div>
<div class="container">
    <!-- El contenido de la página -->
</div>
<div class="footer">
    <p>&copy; Almacén CDI BO-0608</p>
</div>





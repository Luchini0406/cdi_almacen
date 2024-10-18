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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-top: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .acciones a input {
            display: inline-block;
            background-color: #2980b9;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .acciones a input:hover {
            background-color: #3498db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #34495e;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        a {
            text-decoration: none;
            color: #2980b9;
        }

        a input {
            background-color: #27ae60;
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a input:hover {
            background-color: #2ecc71;
        }

        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 79%;
            bottom: 0;
        }
        .titulo h1 {
            color: #2980b9; /* Color del texto */
    font-size: 48px; /* Tamaño de la letra */
    margin-bottom: 20px;
    font-weight: bold;
    letter-spacing: 2px; /* Espaciado entre letras */
    text-transform: uppercase; /* Texto en mayúsculas */
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Sombra en el texto */
    background-color: #34495e; /* Fondo del rectángulo */
    padding: 10px 20px; /* Espacio interno */
    display: center; /* Ajusta el ancho al contenido */
    border-radius: 8px; /* Bordes redondeados para un toque elegante */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra del rectángulo */
}


    </style>
</head>
<body>


<div class="container">
    <div class="titulo">
    <h1>Gestión de Productos.</h1><br>
<a href="agregar_productos.php"><input type="button" value="Agregar Producto"></a>
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
            <a href="editar_beneficiarios.php?item=<?php echo $beneficiario['codigo']; ?>"><input type="button" value="Editar"></a>
            <a href="eliminar_beneficiarios.php?item=<?php echo $beneficiario['codigo']; ?>"><input type="button" value="Eliminar"></a>
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
<div class="footer">
    <p>&copy; Almacén CDI BO-0608</p>
</div>
</body>
</html>







<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el Item para eliminar
if (isset($_GET['item'])) {
    $item = $_GET['item'];

    // Eliminar producto de la base de datos
    $sql = "DELETE FROM productos WHERE Item = '$item'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Producto eliminado exitosamente.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Eliminar Producto</h1>
<p>¿Está seguro de que desea eliminar el producto?</p>

<a href="productos.php">Volver a la lista de productos</a>

</body>
</html>

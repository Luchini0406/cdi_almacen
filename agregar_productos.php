<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item = $_POST['item'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $puntos = $_POST['puntos'];

    // Insertar producto en la base de datos
    $sql = "INSERT INTO productos (Item, nombre, descripcion, cantidad, puntos) VALUES ('$item', '$nombre', '$descripcion', $cantidad, $puntos)";
    
    if (mysqli_query($conn, $sql)) {
        echo "Producto agregado exitosamente.";
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
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Agregar Producto</h1>
<form method="post" action="agregar_productos.php">
    <label for="item">Item:</label>
    <input type="text" name="item" required>
    <br>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required>
    <br>
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" required></textarea>
    <br>
    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" required>
    <br>
    <label for="puntos">Puntos:</label>
    <input type="number" name="puntos" required>
    <br>
    <input type="submit" value="Agregar Producto">
</form>

<br>
<a href="productos.php">Volver a la lista de productos</a>

</body>
</html>


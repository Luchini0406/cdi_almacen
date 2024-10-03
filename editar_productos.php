<?php
session_start();
include 'conexion.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el Item para editar
if (isset($_GET['item'])) {
    $item = $_GET['item'];

    // Obtener datos del producto
    $sql = "SELECT * FROM productos WHERE Item = '$item'";
    $result = mysqli_query($conn, $sql);
    $producto = mysqli_fetch_assoc($result);
}

// Actualizar el producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $puntos = $_POST['puntos'];

    // Actualizar en la base de datos
    $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', cantidad=$cantidad, puntos=$puntos WHERE Item='$item'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Producto actualizado exitosamente.";
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
    <title>Editar Producto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1>Editar Producto</h1>
<form method="post" action="editar_productos.php?item=<?php echo $item; ?>">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>
    <br>
    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" required><?php echo $producto['descripcion']; ?></textarea>
    <br>
    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>
    <br>
    <label for="puntos">Puntos:</label>
    <input type="number" name="puntos" value="<?php echo $producto['puntos']; ?>" required>
    <br>
    <input type="submit" value="Actualizar Producto">
</form>

<br>
<a href="productos.php">Volver a la lista de productos</a>

</body>
</html>

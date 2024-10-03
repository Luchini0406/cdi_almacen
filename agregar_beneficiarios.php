<?php
session_start();
include 'conexion.php'; 

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_beneficiario'])) {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $curso = $_POST['curso'];
    $puntos = $_POST['puntos'];

    // Insertar nuevo beneficiario en la base de datos
    $sql = "INSERT INTO beneficiarios (codigo, nombre, apellido, curso, puntos) VALUES ('$codigo', '$nombre', '$apellido', '$curso', '$puntos')";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='mensaje-exito'>Beneficiario agregado con éxito.</div>";
    } else {
        echo "<div class='mensaje-error'>Error al agregar beneficiario: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Beneficiario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Agregar Beneficiario</h1>
    <form method="post" action="agregar_beneficiarios.php">
        <label for="codigo">Código:</label>
        <input type="text" name="codigo" required>
        
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required>
        
        <label for="curso">Curso:</label>
        <input type="text" name="curso" required>
        
        <label for="puntos">Puntos:</label>
        <input type="number" name="puntos" value="0" min="0" required>
        
        <input type="submit" name="agregar_beneficiario" value="Agregar Beneficiario">
    </form>
    
    <a href="beneficiarios.php"><input type="button" value="Regresar a la lista de beneficiarios"></a>
</div>

</body>
</html>

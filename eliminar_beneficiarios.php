<?php
session_start();
include 'conexion.php'; 

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['codigo'])) {
    $codigo_beneficiario = $_GET['codigo'];

    // Eliminar el beneficiario de la base de datos
    $sql_delete = "DELETE FROM beneficiarios WHERE codigo = '$codigo_beneficiario'";
    if (mysqli_query($conn, $sql_delete)) {
        echo "<div class='mensaje-exito'>Beneficiario eliminado con éxito.</div>";
    } else {
        echo "<div class='mensaje-error'>Error al eliminar beneficiario: " . mysqli_error($conn) . "</div>";
    }
}

$beneficiarios = mysqli_query($conn, "SELECT * FROM beneficiarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Beneficiario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Eliminar Beneficiario</h1>
    
    <table border="1">
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Acción</th>
        </tr>
        <?php while ($beneficiario = mysqli_fetch_assoc($beneficiarios)): ?>
        <tr>
            <td><?php echo $beneficiario['codigo']; ?></td>
            <td><?php echo $beneficiario['nombre']; ?></td>
            <td><?php echo $beneficiario['apellido']; ?></td>
            <td>
                <a href="eliminar_beneficiarios.php?codigo=<?php echo $beneficiario['codigo']; ?>" onclick="return confirm('¿Estás seguro de eliminar a este beneficiario?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <a href="beneficiarios.php"><input type="button" value="Regresar a la lista de beneficiarios"></a>
</div>

</body>
</html>

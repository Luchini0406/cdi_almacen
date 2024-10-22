<?php
session_start();
include 'conexion.php'; 

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$codigo_beneficiario = '';
if (isset($_POST['buscar'])) {
    $codigo_beneficiario = $_POST['codigo_buscar'];
}

if (isset($_GET['codigo'])) {
    $codigo_eliminar = $_GET['codigo'];

    $sql_delete = "DELETE FROM beneficiarios WHERE codigo = '$codigo_eliminar'";
    if (mysqli_query($conn, $sql_delete)) {
        echo "<div class='mensaje-exito'>Beneficiario eliminado con éxito.</div>";
    } else {
        echo "<div class='mensaje-error'>Error al eliminar beneficiario: " . mysqli_error($conn) . "</div>";
    }
}

if (!empty($codigo_beneficiario)) {
    $beneficiarios = mysqli_query($conn, "SELECT * FROM beneficiarios WHERE codigo = '$codigo_beneficiario'");
} else {
    $beneficiarios = mysqli_query($conn, "SELECT * FROM beneficiarios");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Beneficiario</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         table a {
            text-decoration: none;
            color: #2980b9;
            display: inline-block;
            background-color: #0056b3;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Eliminar Beneficiario</h1>
    <a href="beneficiarios.php"><input type="button" value="Regresar a la lista de beneficiarios"></a>
    <br><br>
    
    <form method="post" action="eliminar_beneficiarios.php">
        <label for="codigo_buscar">Buscar por código:</label>
        <input type="text" id="codigo_buscar" name="codigo_buscar" placeholder="Ingrese el código">
        <input type="submit" name="buscar" value="Buscar"><br><br>
    </form>

    <table border="1">
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Acción</th>
        </tr>
        <?php if (mysqli_num_rows($beneficiarios) > 0): ?>
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
        <?php else: ?>
            <tr>
                <td colspan="4">No se encontraron beneficiarios con ese código.</td>
            </tr>
        <?php endif; ?>
    </table>
    <br>
    <a href="beneficiarios.php"><input type="button" value="Regresar a la lista de beneficiarios"></a>
</div>

</body>
</html>

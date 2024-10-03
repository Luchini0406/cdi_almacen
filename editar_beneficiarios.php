<?php
session_start();
include 'conexion.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha enviado el formulario para buscar y editar un beneficiario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar_beneficiario'])) {
    $codigo_beneficiario = $_POST['codigo_beneficiario'];

    // Obtener datos del beneficiario por código
    $sql = "SELECT * FROM beneficiarios WHERE codigo = '$codigo_beneficiario'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error al obtener el beneficiario: " . mysqli_error($conn));
    }

    $beneficiario = mysqli_fetch_assoc($result);
}

// Procesar la actualización de los puntos del beneficiario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['actualizar_beneficiario'])) {
    $codigo_beneficiario = $_POST['codigo_beneficiario'];
    $nuevos_puntos = $_POST['nuevos_puntos'];

    // Actualizar los puntos del beneficiario
    $sql_actualizar_puntos = "UPDATE beneficiarios SET puntos = puntos + '$nuevos_puntos' WHERE codigo = '$codigo_beneficiario'";
    if (mysqli_query($conn, $sql_actualizar_puntos)) {
        echo "<div class='mensaje-exito'>Puntos actualizados correctamente.</div>";
    } else {
        echo "<div class='mensaje-error'>Error al actualizar los puntos: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Beneficiario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Editar Beneficiario</h1>

    <!-- Formulario para buscar beneficiario -->
    <div class="form-container">
        <h2>Buscar Beneficiario por Código</h2>
        <form method="post" action="editar_beneficiarios.php">
            <label for="codigo_beneficiario">Código del beneficiario:</label>
            <input type="text" name="codigo_beneficiario" required>
            <input type="submit" name="buscar_beneficiario" value="Buscar">
        </form>
    </div>

    <!-- Mostrar detalles del beneficiario si se encontró -->
    <?php if (isset($beneficiario)): ?>
        <div class="info-beneficiario">
            <h3>Beneficiario: <?php echo $beneficiario['nombre'] . " " . $beneficiario['apellido']; ?></h3>
            <p>Puntos actuales: <?php echo $beneficiario['puntos']; ?></p>
        </div>

        <!-- Formulario para agregar puntos -->
        <div class="form-container">
            <h2>Agregar Puntos al Beneficiario</h2>
            <form method="post" action="editar_beneficiarios.php">
                <input type="hidden" name="codigo_beneficiario" value="<?php echo $beneficiario['codigo']; ?>">
                
                <label for="nuevos_puntos">Puntos a agregar:</label>
                <input type="number" name="nuevos_puntos" required><br><br>

                <input type="submit" name="actualizar_beneficiario" value="Actualizar Puntos">
            </form>
        </div>
    <?php endif; ?>

    <a href="beneficiarios.php"><input type="button" value="Regresar a Gestión de Beneficiarios"></a>
</div>

</body>
</html>

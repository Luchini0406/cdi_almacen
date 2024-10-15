<?php
session_start();
include 'conexion.php'; // Incluimos la conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Variable para almacenar los productos
$beneficiarios = [];

// Verificar si se ha enviado un Codigo para la búsqueda
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo_beneficiario'])) {
    $codigo_beneficiario = $_POST['codigo_beneficiario'];

    // Buscar beneficiario por el codigo ingresado
    $sql_beneficiarios = "SELECT * FROM beneficiarios WHERE Codigo = '$codigo_beneficiario'";
    $result_beneficiarios = mysqli_query($conn, $sql_beneficiarios);

    // Verificar si hay beneficiarios con ese Codigo
    if (mysqli_num_rows($result_beneficiarios) > 0) {
        $beneficiarios = mysqli_fetch_all($result_beneficiarios, MYSQLI_ASSOC);
    } else {
        echo "No se encontró ningún beneficiario con ese Código.";
    }
} else {
    // Si no se ha enviado un Codigo, mostrar todos los beneficiarios
    $sql_beneficiarios = "SELECT * FROM beneficiarios";
    $result_beneficiarios = mysqli_query($conn, $sql_beneficiarios);
    $beneficiarios = mysqli_fetch_all($result_beneficiarios, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Beneficiarios</title>
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

<h1>Gestión de Beneficiarios</h1>

<!-- Formulario para buscar beneficiario por Codigo -->
<h2>Buscar Beneficiario por Codigo</h2>

<div class="acciones">
    <a href="agregar_beneficiarios.php"><input type="button" value="Agregar Beneficiario"></a>
    <a href="eliminar_beneficiarios.php"><input type="button" value="Eliminar Beneficiario"></a>
    <a href="entrega_productos.php"><input type="button" value="Ir a Entrega de Productos"></a>
    <a href="home.php"><input type="button" value="Regresar al inicio"></a>
</div>
<br><br>

<form method="post" action="beneficiarios.php">
    <label for="codigo_beneficiario">Codigo del beneficiario:</label>
    <input type="text" name="codigo_beneficiario" required>
    <input type="submit" value="Buscar">
</form>

<!-- Mostrar la lista de beneficiarios -->
<h2>Lista de Beneficiarios</h2>
<!-- Agregar enlaces para agregar, editar y eliminar beneficiarios -->
<a href="agregar_beneficiarios.php"><input type="button" value="Agregar Beneficiarios"></a> <br> <br>

<?php if (!empty($beneficiarios)): ?>
<table>
    <tr>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Curso</th>
        <th>Puntos</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($beneficiarios as $beneficiario): ?>
        <tr>
            <td><?php echo $beneficiario['codigo']; ?></td>
            <td><?php echo $beneficiario['nombre']; ?></td>
            <td><?php echo $beneficiario['apellido']; ?></td>
            <td><?php echo $beneficiario['curso']; ?></td>
            <td><?php echo $beneficiario['puntos']; ?></td>
            <td>
                <a href="editar_beneficiarios.php?item=<?php echo $beneficiario['codigo']; ?>"> <input type="button" value="Editar"></a>
                <a href="eliminar_beneficiarios.php?item=<?php echo $beneficiario['codigo']; ?>"> <input type="button" value="Eliminar"></a>
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
    <title>Gestión de Beneficiarios</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Enlazar la hoja de estilos -->
</head>
<body>
<div class="header">
    <h1>Gestión de Beneficiarios</h1>
</div>
<div class="container">
    <!-- El contenido de la página -->
</div>
<div class="footer">
    <p>&copy; Almacén CDI BO-0608</p>
</div>

</body>
</html>

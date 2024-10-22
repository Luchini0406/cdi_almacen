<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$beneficiarios = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo_beneficiario'])) {
    $codigo_beneficiario = $_POST['codigo_beneficiario'];

    $sql_beneficiarios = "SELECT * FROM beneficiarios WHERE Codigo = '$codigo_beneficiario'";
    $result_beneficiarios = mysqli_query($conn, $sql_beneficiarios);

    if (mysqli_num_rows($result_beneficiarios) > 0) {
        $beneficiarios = mysqli_fetch_all($result_beneficiarios, MYSQLI_ASSOC);
    } else {
        echo "No se encontró ningún beneficiario con ese Código.";
    }
} else {
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
    <link rel="stylesheet" href="styles.css">
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
            background-color: #0056b3;
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
            padding: 1px 0;
            width: 100%;
            bottom: 0;
        }
        .titulo h1 {
            color: #2980b9;
            font-size: 48px;
            margin-bottom: 20px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            background-color: #34495e;
            padding: 10px 20px;
            display: center;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

<div class="container">
<div class="titulo">
    <h1>Gestión de Beneficiarios</h1>

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

    <h2>Lista de Beneficiarios</h2>

    <?php if (!empty($beneficiarios)): ?>
    <table>
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Curso</th>
            <th>Puntos</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($beneficiarios as $beneficiario): ?>
            <tr>
                <td><?php echo $beneficiario['codigo']; ?></td>
                <td><?php echo $beneficiario['nombre']; ?></td>
                <td><?php echo $beneficiario['apellido']; ?></td>
                <td><?php echo $beneficiario['segundo_apellido']; ?></td>
                <td><?php echo $beneficiario['curso']; ?></td>
                <td><?php echo $beneficiario['puntos']; ?></td>
                <td>
                    <a href="editar_beneficiarios.php?item=<?php echo $beneficiario['codigo']; ?>"><input type="button" value="Editar"></a>
                    <a href="eliminar_beneficiarios.php?item=<?php echo $beneficiario['codigo']; ?>"><input type="button" value="Eliminar"></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div>

<div class="footer">
    <p>&copy; Almacén CDI BO-0608</p>
</div>

</body>
</html>

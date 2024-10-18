<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $tipo = $_POST['tipo']; // Captura del tipo de usuario

    // Hash de la contraseña ingresada por el usuario
    $contrasena_hashed = password_hash($contrasena, PASSWORD_DEFAULT);

    // Inserción de usuario con tipo
    $sql = "INSERT INTO usuarios (usuario, contrasena, tipo) VALUES ('$usuario', '$contrasena_hashed', '$tipo')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success-message'>Usuario creado con éxito</div>";
    } else {
        echo "<div class='error-message'>Error al crear el usuario: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
        }

        h2 {
            color: #2980b9;
            border: none;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            color: #555555;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"],
        select,
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #dddddd;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #2980b9;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #555555;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            margin-top: 10px;
        }

        .error-message {
            color: #dc3545;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Crear Usuario</h2>
    <form method="post" action="crear_usuario.php">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="">Seleccionar tipo de usuario</option>
            <option value="admin">Admin</option>
            <option value="usuario">Usuario</option>
        </select>

        <input type="submit" value="Crear usuario">
    </form>
    <a href="home.php"><input type="button" value="Regresar al inicio"></a>
</div>

</body>
</html>

<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

         // Almacenar información del usuario en la sesión
         $_SESSION['usuario'] = $row['usuario'];
         $_SESSION['tipo'] = $row['tipo']; // Guardar el tipo de usuario
 
         // Verificación del tipo de usuario
         if ($row['tipo'] == 'admin') {
             // Redirige a home.php si el usuario es administrador
             header("Location: home.php");
         } else if ($row['tipo'] == 'usuario') {
             // Redirige a homeus.php si el usuario es un usuario regular
             header("Location: homeus.php");
         }
         exit();
    } else {
        echo "<div class='error-msg'>Credenciales incorrectas</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Iniciar Sesión</h2>
        <style>
            /* Estilos generales */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}

.login-box {
    background-color: #fff;
    padding: 20px 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

label {
    display: block;
    text-align: left;
    margin-bottom: 8px;
    font-weight: bold;
    color: #555;
}

input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #2980b9;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
}

input[type="submit"]:hover {
    background-color: #555555;
}

.error-msg {
    color: #ff4d4d;
    font-weight: bold;
    margin-top: 10px;
}

/* Estilos responsivos */
@media (max-width: 768px) {
    .login-box {
        width: 90%;
        padding: 20px;
    }
}

        </style>
        <form method="post" action="login.php">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            
            <input type="submit" value="Iniciar Sesión">
        </form>
    </div>
</div>

</body>
</html>

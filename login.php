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

        
        $_SESSION['usuario'] = $row['usuario'];
        header("Location: home.php"); 
        exit();
    } else {
        echo "Credenciales incorrectas";
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
    <h2>Iniciar Sesión</h2>
    <form method="post" action="login.php">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>
        
        <input type="submit" value="Iniciar Sesión">
    </form>
</div>

</body>
</html>

<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = password_hash('cdi608', PASSWORD_DEFAULT); // Contraseña fija cdi608

    $sql = "INSERT INTO usuarios (usuario, contrasena) VALUES ('$usuario', '$contrasena')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario creado con éxito";
    } else {
        echo "Error al crear el usuario: " . $conn->error;
    }
}
?>

<form method="post" action="crear_usuario.php">
    Usuario: <input type="text" name="usuario" required><br>
    <input type="submit" value="Crear usuario">
</form>

<?php
session_start();
include 'conexion.php'; 

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Sistema de Almacén</title>
    <link rel="stylesheet" href="css/styles.css"> 
    <style>
        a {
            display: block;
            margin: 10px auto;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            width: fit-content; 
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2 class="titulo-almacen">Opciones disponibles</h2>

<style>
   

    .titulo-almacen {
        font-family: 'Georgia', serif; 
        text-align: center;
        color: #2C3E50; 
        font-size: 36px; 
        letter-spacing: 2px; 
        text-transform: uppercase; 
        background-color: #F5F5F5; 
        padding: 20px;
        border: 5px solid #2980B9; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        border-radius: 10px; 
        margin: 20px auto; 
        width: fit-content;
    }

    a {
        display: block;
        margin: 10px auto;
        padding: 15px;
        background-color: #007BFF; 
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 8px;
        width: 220px; 
        font-size: 18px; 
        font-family: 'Arial', sans-serif; 
        font-weight: bold; 
        transition: background-color 0.3s ease, transform 0.3s ease; 
    }

    body {
        background-color: #ECF0F1; 
        font-family: 'Arial', sans-serif; 
        color: #34495E; 
    }

</style>

<a href="beneficiarios.php">Gestión de Beneficiarios</a>
<a href="crear_usuario.php">Crear Nuevo Usuario</a>
<a href="productos.php">Gestión de Productos</a>
<a href="reportes.php">Generar Reportes</a> 
<a href="logout.php">Cerrar Sesión</a>

</body>
</html>

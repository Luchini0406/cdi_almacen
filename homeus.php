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
    <title>Inicio - Sistema de Almacén (Usuario Limitado)</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-image: url('fondo.jpg'); /* Fondo de pantalla */
            background-size: cover;
            background-position: center;
            font-family: 'Arial', sans-serif;
            color: #34495E;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .imagen-logo {
            margin-right: 30px;
            text-align: center;
        }

        img {
            border: 2px solid black;
            max-width: 200px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

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

        .opciones {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        a {
            display: block;
            margin: 10px auto;
            padding: 15px;
            background-color: #3498DB;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            width: 220px;
            font-size: 18px;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        a:hover {
            background-color: #2980B9;
            transform: translateY(-3px);
        }

        /* Estilos de respuesta móvil */
        @media screen and (max-width: 768px) {
            .container {
                flex-direction: column;
                text-align: center;
                padding: 10px;
            }

            .imagen-logo {
                margin-bottom: 20px;
                margin-right: 0;
            }

            img {
                max-width: 150px;
            }

            a {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>

<h2 class="titulo-almacen">Opciones de Usuario</h2>
<div class="container">
    <div class="imagen-logo">
        <img src="logo CDI.jpg" alt="Logo CDI" style="border: 2px solid black; margin: 10px auto; display: block; max-width: 300px; height: auto;">
    </div>
    <div class="opciones">
        <a href="beneficiarios.php">Gestión de Beneficiarios</a>
        <a href="productos.php">Gestión de Productos</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</div>

</body>
</html>

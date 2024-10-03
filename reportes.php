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
    <title>Reportes - Sistema de Almacén</title>
    <link rel="stylesheet" href="css/estyles.css">
    <style>
        body {
            background-color: #ECF0F1;
            font-family: 'Arial', sans-serif;
            color: #34495E;
        }
        .reporte-opciones {
            text-align: center;
            margin: 50px auto;
            padding: 20px;
            background-color: #F5F5F5;
            border: 5px solid #2980B9;
            border-radius: 10px;
            width: fit-content;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .reporte-opciones h2 {
            color: #2C3E50;
            font-size: 28px;
        }
        .reporte-opciones a {
            display: block;
            margin: 15px auto;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            width: 220px;
            font-size: 18px;
            font-family: 'Arial', sans-serif;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .reporte-opciones a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="reporte-opciones">
    <h2>Generar Reportes</h2>
    <a href="generar_reporte.php?tipo=diario">Reporte Diario</a>
    <a href="generar_reporte.php?tipo=semanal">Reporte Semanal</a>
    <a href="generar_reporte.php?tipo=mensual">Reporte Mensual</a>
</div>

</body>
</html>

<?php
session_start();
include 'conexion.php';

if (!isset($_POST['codigo_beneficiario'])) {
    die("No se ha seleccionado un beneficiario.");
}

$codigo_beneficiario = $_POST['codigo_beneficiario'];

// Consulta para obtener los datos del beneficiario
$sql_beneficiario = "SELECT * FROM beneficiarios WHERE codigo = '$codigo_beneficiario'";
$result_beneficiario = mysqli_query($conn, $sql_beneficiario);

if (!$result_beneficiario || mysqli_num_rows($result_beneficiario) == 0) {
    die("Beneficiario no encontrado.");
}

$beneficiario = mysqli_fetch_assoc($result_beneficiario);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Productos Entregados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h1>Recibo de Productos Entregados</h1>
    <p>Beneficiario: <?php echo $beneficiario['nombre'] . " " . $beneficiario['apellido']; ?></p>
    <p>Código: <?php echo $beneficiario['codigo']; ?></p>

    <table>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Puntos</th>
            <th>Total Puntos</th>
        </tr>
        <?php
        $costo_total = 0;
        foreach ($_SESSION['productos_seleccionados'] as $producto) {
            $total_puntos = $producto['puntos'] * $producto['cantidad'];
            $costo_total += $total_puntos;
            echo "<tr>
                    <td>{$producto['nombre']}</td>
                    <td>{$producto['cantidad']}</td>
                    <td>{$producto['puntos']}</td>
                    <td>{$total_puntos}</td>
                  </tr>";
        }
        ?>
        <tr>
            <td colspan="3"><strong>Total Puntos</strong></td>
            <td><strong><?php echo $costo_total; ?></strong></td>
        </tr>
    </table>

    <button onclick="window.print()">Imprimir</button>
</div>

</body>
</html>

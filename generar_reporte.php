<?php
session_start();
require 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Inicializar la variable de resultado como vacía
$resultado = null;

// Si el usuario ha enviado el formulario con las fechas
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Si las fechas están vacías, obtener todas las encomiendas
    if (empty($fecha_inicio) || empty($fecha_fin)) {
        $sql = "SELECT * FROM entregas";
        $resultado = $conn->query($sql);
    } else {
        // Consulta para buscar encomiendas entre las fechas si las fechas están definidas
        $sql = "SELECT * FROM entregas WHERE fecha_entrega BETWEEN ? AND ?";
        $sentencia = $conn->prepare($sql);
        $sentencia->bind_param("ss", $fecha_inicio, $fecha_fin);
        $sentencia->execute();
        $resultado = $sentencia->get_result();
    }
} else {
    // Consulta para obtener todas las encomiendas si no se ha hecho una búsqueda
    $sql = "SELECT * FROM entregas";
    $resultado = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Reportes </h2>
        
        <!-- Formulario para buscar encomiendas por fechas -->
        <form method="POST" action="" class="mb-4">
            <div class="form-row">
                <div class="col">
                    <label for="fecha_inicio">Fecha de Inicio:</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="<?php echo isset($fecha_inicio) ? $fecha_inicio : ''; ?>">
                </div>
                <div class="col">
                    <label for="fecha_fin">Fecha de Fin:</label>
                    <input type="date" name="fecha_fin" class="form-control" value="<?php echo isset($fecha_fin) ? $fecha_fin : ''; ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Buscar</button>
        </form>

        <!-- Tabla para mostrar los registros de encomiendas -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código del Beneficiario</th>
                    <th>Id del Producto</th>
                    <th>Cantidad</th>
                    <th>Puntos Gastados</th>
                    <th>Fecha de Entrega</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado && $resultado->num_rows > 0): ?>
                    <?php while($entregas = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $entregas['id']; ?></td>
                            <td><?php echo $entregas['codigo_beneficiario']; ?></td>
                            <td><?php echo $entregas['producto_id']; ?></td>
                            <td><?php echo $entregas['cantidad']; ?></td>
                            <td><?php echo $entregas['puntos_gastados']; ?></td>
                            <td><?php echo $entregas['fecha_entrega']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No se encontraron registros.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="home.php"><input type="button" value="Regresar al inicio"></a>
    </div>
</body>
</html>

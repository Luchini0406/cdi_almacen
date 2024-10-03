<?php
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "almacen_cdi";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>


<?php
$servername = "localhost";
$username = "cdi";
$password = "cdi608";
$dbname = "almacen_cdi";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>

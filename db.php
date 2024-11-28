
<?php
// Configuración de la base de datos
$host = 'localhost'; // Servidor
$user = 'root';      // Usuario predeterminado de MAMP
$password = 'root';  // Contraseña predeterminada de MAMP
$dbname = 'todolist'; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

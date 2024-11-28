

<?php
require 'db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: indexto.php"); // Redirigir después de eliminar
exit();
?>

<?php
// Incluir la conexión a la base de datos
require 'db.php';

// Manejar la solicitud POST para agregar una tarea
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $stmt = $conn->prepare("INSERT INTO tasks (task) VALUES (?)");
        if ($stmt === false) {
            die("Error en la preparación: " . $conn->error);
        }
        $stmt->bind_param("s", $task);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: indexto.php"); // Recargar para evitar doble envío del formulario
    exit();
}

// Manejar la solicitud GET para eliminar una tarea
if (isset($_GET['delete'])) {
    $task_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
    if ($stmt === false) {
        die("Error en la preparación: " . $conn->error);
    }
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();
    header("Location: indexto.php");
    exit();
}

// Obtener todas las tareas
$result = $conn->query("SELECT * FROM tasks ORDER BY created_at DESC");
if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0b0b0b;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #6fc2d5;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #000;
            border-radius: 3px;
            background: #fff;
            color: #000;
            margin-right: 10px;
        }

        button {
            padding: 10px;
            background: #FFD700;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background: #e0c200;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 10px;
            background: #1c1515;
            margin-bottom: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 3px;
        }

        li span {
            flex: 1;
            color: #fff;
        }

        a.delete {
            text-decoration: none;
            color: #FFD700;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ToDo List</h1>
        <!-- Formulario para agregar tareas -->
        <form action="indexto.php" method="POST">
            <input type="text" name="task" placeholder="Nueva tarea..." required>
            <button type="submit">Agregar</button>
        </form>

        <!-- Lista de tareas -->
        <ul>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <li>
                        <span><?php echo htmlspecialchars($row['task']); ?></span>
                        <a href="indexto.php?delete=<?php echo $row['id']; ?>" class="delete">Eliminar</a>
                    </li>
                <?php endwhile; ?>
            <?php else: ?>
                <li>No hay tareas pendientes.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>

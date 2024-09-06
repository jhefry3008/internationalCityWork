<?php
session_start();
include 'db_connect.php';

// Verificar si el usuario es un administrador
if ($_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Procesar eliminación de usuario
// Procesar eliminación de usuario
if (isset($_POST['eliminar_usuario_id'])) {
    $usuario_id = $_POST['eliminar_usuario_id'];

    // Primero, elimina los libros relacionados con el cliente
    $queryEliminarLibros = "DELETE FROM cliente_libros WHERE cliente_id = ?";
    $stmtEliminarLibros = $conn->prepare($queryEliminarLibros);
    $stmtEliminarLibros->bind_param('i', $usuario_id);

    if ($stmtEliminarLibros->execute()) {
        // Luego, elimina el usuario
        $queryEliminarUsuario = "DELETE FROM usuarios WHERE id = ?";
        $stmtEliminarUsuario = $conn->prepare($queryEliminarUsuario);
        $stmtEliminarUsuario->bind_param('i', $usuario_id);

        if ($stmtEliminarUsuario->execute()) {
            echo "<div class='alert alert-success' role='alert'>Usuario y libros eliminados correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al eliminar el usuario.</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al eliminar los libros del usuario.</div>";
    }
}


// Obtener la lista de usuarios
$queryUsuarios = "SELECT id, nombre_usuario, rol FROM usuarios";
$resultUsuarios = $conn->query($queryUsuarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuarios</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .table-container {
            margin-top: 20px;
        }
        .botones {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Usuarios Registrados</h1>

        <div class="table-container">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($usuario = $resultUsuarios->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="eliminar_usuario_id" value="<?php echo $usuario['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="botones text-center">
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <!-- Incluir jQuery y Bootstrap JS al final del documento -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


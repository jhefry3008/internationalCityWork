<?php
session_start();
include 'db_connect.php';

// Verificar si el usuario es un administrador
if ($_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Procesar selección de cliente
if (isset($_POST['cliente_seleccionado'])) {
    $_SESSION['cliente_id'] = $_POST['cliente_seleccionado'];
} elseif (!isset($_SESSION['cliente_id'])) {
    $_SESSION['cliente_id'] = null;
}

// Procesar asignación de libro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['libro_id']) && isset($_SESSION['cliente_id'])) {
    $libro_id = $_POST['libro_id'];
    $cliente_id = $_SESSION['cliente_id'];

    // Insertar la asignación del libro al cliente
    $queryAsignarLibro = "INSERT INTO cliente_libros (cliente_id, libro_id) VALUES (?, ?)";
    $stmt = $conn->prepare($queryAsignarLibro);
    $stmt->bind_param('ii', $cliente_id, $libro_id);

    if ($stmt->execute()) {
        echo "Libro asignado correctamente.";
    } else {
        echo "Error al asignar el libro.";
    }
}

// Procesar eliminación de libro asignado
if (isset($_POST['eliminar_libro_id']) && isset($_SESSION['cliente_id'])) {
    $libro_id = $_POST['eliminar_libro_id'];
    $cliente_id = $_SESSION['cliente_id'];

    // Eliminar la relación entre el cliente y el libro
    $queryEliminarLibro = "DELETE FROM cliente_libros WHERE cliente_id = ? AND libro_id = ?";
    $stmtEliminarLibro = $conn->prepare($queryEliminarLibro);
    $stmtEliminarLibro->bind_param('ii', $cliente_id, $libro_id);

    if ($stmtEliminarLibro->execute()) {
        echo "Libro eliminado correctamente.";
    } else {
        echo "Error al eliminar el libro.";
    }
}

// Obtener la lista de clientes
$queryClientes = "SELECT id, nombre_usuario FROM usuarios WHERE rol = 'cliente'";
$resultClientes = $conn->query($queryClientes);

// Obtener libros disponibles
$queryLibrosDisponibles = "SELECT id, titulo FROM libros";
$resultLibrosDisponibles = $conn->query($queryLibrosDisponibles);

// Obtener libros asignados al cliente seleccionado
$librosAsignados = [];
$clienteSeleccionadoNombre = '';

if (isset($_SESSION['cliente_id'])) {
    $cliente_id = $_SESSION['cliente_id'];
    
    // Obtener nombre del cliente seleccionado
    $queryClienteSeleccionado = "SELECT nombre_usuario FROM usuarios WHERE id = ?";
    $stmtClienteSeleccionado = $conn->prepare($queryClienteSeleccionado);
    $stmtClienteSeleccionado->bind_param('i', $cliente_id);
    $stmtClienteSeleccionado->execute();
    $resultClienteSeleccionado = $stmtClienteSeleccionado->get_result();
    if ($clienteSeleccionado = $resultClienteSeleccionado->fetch_assoc()) {
        $clienteSeleccionadoNombre = $clienteSeleccionado['nombre_usuario'];
    }

    // Obtener libros asignados al cliente seleccionado
    $queryLibrosAsignados = "
        SELECT l.id, l.titulo
        FROM libros l
        JOIN cliente_libros cl ON l.id = cl.libro_id
        WHERE cl.cliente_id = ?";
    $stmtLibrosAsignados = $conn->prepare($queryLibrosAsignados);
    $stmtLibrosAsignados->bind_param('i', $cliente_id);
    $stmtLibrosAsignados->execute();
    $resultLibrosAsignados = $stmtLibrosAsignados->get_result();
    $librosAsignados = $resultLibrosAsignados->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Libros a Clientes</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="../img/internacional.png">
    <style>
        .cliente, .libros-asignados, .libros-disponibles {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Asignar y Eliminar Libros a Clientes</h1>

        <?php if (!isset($_SESSION['cliente_id'])): ?>
            <form method="post">
                <div class="form-group">
                    <label for="cliente_seleccionado">Selecciona un Cliente:</label>
                    <select name="cliente_seleccionado" id="cliente_seleccionado" class="form-control" required>
                        <option value="">Selecciona un cliente</option>
                        <?php while ($cliente = $resultClientes->fetch_assoc()): ?>
                            <option value="<?php echo $cliente['id']; ?>"><?php echo htmlspecialchars($cliente['nombre_usuario']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Seleccionar Cliente</button>
                <button onclick="window.location.href='index.php';" class="btn btn-secondary">Volver</button>
            </form>
        <?php else: ?>
            <h2>Cliente Seleccionado: <?php echo htmlspecialchars($clienteSeleccionadoNombre); ?></h2>

            <!-- Libros asignados al cliente -->
            <div class="libros-asignados">
                <h3>Libros Asignados:</h3>
                <ul class="list-group">
                    <?php if (count($librosAsignados) > 0): ?>
                        <?php foreach ($librosAsignados as $libro): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo htmlspecialchars($libro['titulo']); ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="eliminar_libro_id" value="<?php echo $libro['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="list-group-item">No hay libros asignados a este cliente.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Asignar libros a cliente -->
            <div class="libros-disponibles">
                <h3>Asignar Nuevo Libro:</h3>
                <form method="post">
                    <div class="form-group">
                        <label for="libro_id">Selecciona un Libro:</label>
                        <select name="libro_id" id="libro_id" class="form-control" required>
                            <option value="">Selecciona un libro</option>
                            <?php while ($libroDisponible = $resultLibrosDisponibles->fetch_assoc()): ?>
                                <option value="<?php echo $libroDisponible['id']; ?>"><?php echo htmlspecialchars($libroDisponible['titulo']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Asignar Libro</button>
                </form>
            </div>

            <!-- Botones para aplicar cambios y volver -->
            <div class="mt-4">
                <form method="post" style="display:inline;">
                    <button type="submit" class="btn btn-secondary" name="reset_cliente">Volver a Seleccionar Cliente</button>
                </form>
            </div>

            <?php
            // Limpiar la selección de cliente si se presiona el botón de volver
            if (isset($_POST['reset_cliente'])) {
                unset($_SESSION['cliente_id']);
                header("Location: asignar_libros.php");
                exit;
            }
            ?>
        <?php endif; ?>
    </div>


    <!-- Incluir jQuery y Bootstrap JS al final del documento -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

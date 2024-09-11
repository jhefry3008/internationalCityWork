<?php
session_start();
include 'db_connect.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica el rol del usuario
$rol = $_SESSION['rol'];  // Asumiendo que guardaste el rol del usuario en la sesión durante el login
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="../img/internacional.png">
    <!-- Incluir tu archivo CSS -->
    <link href="styles.css" rel="stylesheet">
</head>

<body>
    <div class="container-index">
        <h1 class="mt-4 mb-4">Bienvenido, <?php echo isset($_SESSION['nombre_usuario']) ? htmlspecialchars($_SESSION['nombre_usuario']) : 'Invitado'; ?>!</h1>

        <!-- Si el usuario es administrador -->
        <?php if ($rol === 'admin'): ?>
            <div class="admin">
                <h2>Opciones de Administrador</h2> <hr>
                <div class="opciones-container">
                    <!-- Envuelve los botones en un contenedor de fila y columna -->
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <a href="registro.php" class="btn btn-primary btn-block">Registrar Usuario</a>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <a href="asignar_libros.php" class="btn btn-primary btn-block">Asignar Libros a Clientes</a>
                        </div>
                        <div class="col-12 col-md-4 mb-3">
                            <a href="admin.php" class="btn btn-primary btn-block">Administrar Libros</a>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .row {
                    background-color: rgb(255, 255, 255);
                }

                .col-12 {
                    background-color: rgb(255, 255, 255);
                }
            </style>


            <!-- Si el usuario es cliente -->
        <?php elseif ($rol === 'cliente'): ?>
            <div class="cliente">
                <h2 style="text-align: center;">Libros para ti</h2> <hr>
                <?php
                $usuario_id = $_SESSION['usuario_id'];

                // Obtener los libros asignados al cliente
                $query = "SELECT l.titulo, l.contenido, l.pdf_url, l.portada_url 
                          FROM libros l
                          JOIN cliente_libros cl ON l.id = cl.libro_id
                          WHERE cl.cliente_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('i', $usuario_id);
                $stmt->execute();
                $result = $stmt->get_result();
                ?>

                <!-- Mostrar los libros -->
                <div class="books-container">
                    <?php while ($libro = $result->fetch_assoc()): ?>
                        <div class="book-card">
                            <?php if ($libro['portada_url']): ?>
                                <img src="<?php echo htmlspecialchars($libro['portada_url']); ?>" alt="Portada">
                            <?php endif; ?>
                            <h5><?php echo htmlspecialchars($libro['titulo']); ?></h5>
                            <p><?php echo htmlspecialchars($libro['contenido']); ?></p>
                            <?php if ($libro['pdf_url']): ?>
                                <a href="<?php echo htmlspecialchars($libro['pdf_url']); ?>" class="acquire-button" target="_blank">Ver Libro</a>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="logout">
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            <a href="cambiar_contrasena.php" class="btn btn-primary">Cambiar Contraseña</a>

        </div>
    </div>

    <!-- Incluir jQuery y Bootstrap JS al final del documento -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
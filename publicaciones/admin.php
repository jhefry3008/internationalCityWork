<?php
session_start();
include 'db_connect.php';

// Verificar si el usuario es un administrador
if ($_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Eliminar un libro si se ha enviado la solicitud
if (isset($_POST['eliminar_libro_id'])) {
    $libro_id = $_POST['eliminar_libro_id'];

    // Primero, elimina las filas dependientes
    $queryEliminarDependencias = "DELETE FROM cliente_libros WHERE libro_id = ?";
    $stmtEliminarDependencias = $conn->prepare($queryEliminarDependencias);
    $stmtEliminarDependencias->bind_param('i', $libro_id);

    if ($stmtEliminarDependencias->execute()) {
        // Luego, elimina el libro
        $queryEliminarLibro = "DELETE FROM libros WHERE id = ?";
        $stmtEliminarLibro = $conn->prepare($queryEliminarLibro);
        $stmtEliminarLibro->bind_param('i', $libro_id);

        if ($stmtEliminarLibro->execute()) {
            echo "<div class='alert alert-success' role='alert'>Libro eliminado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error al eliminar el libro.</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error al eliminar las dependencias del libro.</div>";
    }
}

// Procesar la creación de un nuevo libro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo']) && isset($_POST['contenido']) && isset($_FILES['pdf_file']) && isset($_FILES['portada_file'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    // Manejar el archivo PDF
    $pdf_file = $_FILES['pdf_file'];
    $pdf_file_name = basename($pdf_file['name']);
    $pdf_file_tmp_name = $pdf_file['tmp_name'];
    $pdf_file_error = $pdf_file['error'];

    // Manejar la imagen de portada
    $portada_file = $_FILES['portada_file'];
    $portada_file_name = basename($portada_file['name']);
    $portada_file_tmp_name = $portada_file['tmp_name'];
    $portada_file_error = $portada_file['error'];

    if ($pdf_file_error === UPLOAD_ERR_OK && $portada_file_error === UPLOAD_ERR_OK) {
        // Definir la ruta de destino para el archivo PDF y la imagen de portada
        $upload_dir_pdf = 'uploads/pdf/';
        $pdf_file_path = $upload_dir_pdf . $pdf_file_name;

        $upload_dir_portada = 'uploads/portadas/';
        $portada_file_path = $upload_dir_portada . $portada_file_name;

        // Crear los directorios si no existen
        if (!is_dir($upload_dir_pdf)) {
            mkdir($upload_dir_pdf, 0777, true);
        }
        if (!is_dir($upload_dir_portada)) {
            mkdir($upload_dir_portada, 0777, true);
        }

        // Mover los archivos al directorio de destino
        if (move_uploaded_file($pdf_file_tmp_name, $pdf_file_path) && move_uploaded_file($portada_file_tmp_name, $portada_file_path)) {
            // Insertar el nuevo libro en la base de datos
            $query = "INSERT INTO libros (titulo, contenido, pdf_url, portada_url) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);

            // Asegúrate de que estás vinculando el número correcto de parámetros
            $stmt->bind_param('ssss', $titulo, $contenido, $pdf_file_path, $portada_file_path);

            if ($stmt->execute()) {
                echo "<p>Libro creado exitosamente.</p>";
            } else {
                echo "<p>Error al crear el libro.</p>";
            }
        } else {
            echo "<p>Error al mover los archivos.</p>";
        }
    } else {
        echo "<p>Error en la carga de archivos.</p>";
    }
}

// Obtener la lista de libros
$queryLibros = "SELECT id, titulo, contenido, pdf_url, portada_url FROM libros";
$resultLibros = $conn->query($queryLibros);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Libros</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="../img/internacional.png">
    <style>
        .custom-container {
            margin-top: 20px;
        }

        .custom-table img {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container custom-container">
        <h1 class="text-center mb-4">Administrar Libros</h1> <hr>

        <!-- Mostrar libros existentes -->
        <div class="mb-4">
            <h2>Libros Creados</h2>
            <div class="table-responsive">
                <table class="table table-bordered custom-table">
                    <thead class="thead-dark">
                        <tr>
                            <th>Título</th>
                            <th>Contenido</th>
                            <th>PDF</th>
                            <th>Portada</th>
                            <!--<th>Acciones</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($libro = $resultLibros->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($libro['contenido']); ?></td>
                                <td><a href="<?php echo htmlspecialchars($libro['pdf_url']); ?>" target="_blank" class="btn btn-primary btn-sm">Ver PDF</a></td>
                                <td><img src="<?php echo htmlspecialchars($libro['portada_url']); ?>" alt="Portada"></td>
                                <!-- <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="eliminar_libro_id" value="<?php echo $libro['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>-->
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Formulario para crear un nuevo libro 
        <div class="mb-4">
            <h2>Crear Nuevo Libro</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="contenido">Contenido</label>
                    <textarea id="contenido" name="contenido" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="pdf_file">Archivo PDF</label>
                    <input type="file" id="pdf_file" name="pdf_file" class="form-control-file" accept=".pdf" required>
                </div>
                <div class="form-group">
                    <label for="portada_file">Imagen de Portada</label>
                    <input type="file" id="portada_file" name="portada_file" class="form-control-file" accept=".jpg,.jpeg,.png" required>
                </div>
                <button type="submit" class="btn btn-primary">Crear Libro</button>
            </form>
        </div>-->

        <!-- Botones de navegación -->
        <div class="text-center">
            <a href="index.php" class="btn btn-secondary">Volver al Inicio</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
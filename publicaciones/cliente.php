<?php
session_start();
include 'db_connect.php';

if ($_SESSION['rol'] !== 'cliente') {
    echo "Acceso denegado.";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$query = "SELECT l.titulo, l.contenido, l.pdf_url, l.portada_url 
          FROM libros l
          JOIN cliente_libros cl ON l.id = cl.libro_id
          WHERE cl.cliente_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

while ($libro = $result->fetch_assoc()) {
    echo "<h2>{$libro['titulo']}</h2>";
    echo "<p>{$libro['contenido']}</p>";
    if ($libro['portada_url']) {
        echo "<img src='{$libro['portada_url']}' alt='Portada' style='width: 200px; height: auto;'>";
    }
    if ($libro['pdf_url']) {
        echo "<a href='{$libro['pdf_url']}' download>Descargar PDF</a>";
    }
}
?>

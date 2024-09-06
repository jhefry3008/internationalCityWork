<?php
session_start();
include 'db_connect.php';

// Verificar si se ha enviado el ID del cliente
if (isset($_POST['cliente_id'])) {
    $cliente_id = $_POST['cliente_id'];

    // Obtener los detalles del cliente
    $queryCliente = "SELECT nombre_usuario FROM usuarios WHERE id = ? AND rol = 'cliente'";
    $stmtCliente = $conn->prepare($queryCliente);
    $stmtCliente->bind_param('i', $cliente_id);
    $stmtCliente->execute();
    $resultCliente = $stmtCliente->get_result();
    $cliente = $resultCliente->fetch_assoc();

    // Obtener los libros asignados al cliente
    $queryLibrosAsignados = "
        SELECT l.id, l.titulo
        FROM libros l
        JOIN cliente_libros cl ON l.id = cl.libro_id
        WHERE cl.cliente_id = ?";
    $stmtLibrosAsignados = $conn->prepare($queryLibrosAsignados);
    $stmtLibrosAsignados->bind_param('i', $cliente_id);
    $stmtLibrosAsignados->execute();
    $resultLibrosAsignados = $stmtLibrosAsignados->get_result();

    $libros_asignados = [];
    while ($libro = $resultLibrosAsignados->fetch_assoc()) {
        $libros_asignados[] = $libro;
    }

    // Devolver los datos en formato JSON
    echo json_encode([
        'nombre_usuario' => $cliente['nombre_usuario'],
        'libros_asignados' => $libros_asignados
    ]);
}
?>

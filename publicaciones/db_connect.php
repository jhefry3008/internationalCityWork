<?php
// Configuración de la conexión
$servername = "localhost"; // Cambia esto si es necesario, por ejemplo, "db" si estás usando Docker
$username = "root"; // Cambia si tu configuración de base de datos usa un usuario diferente
$password = ""; // Cambia si tu base de datos tiene una contraseña diferente
$dbname = "international"; // El nombre de tu base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "";
?>

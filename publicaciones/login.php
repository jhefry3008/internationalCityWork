<?php
session_start();
include 'db_connect.php';

// Función para verificar el estado de la cuenta
function verificarEstadoCuenta($email) {
    global $conn;
    $query = "SELECT fecha_registro, estado FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario) {
        $fecha_registro = new DateTime($usuario['fecha_registro']);
        $hoy = new DateTime();
        $intervalo = $hoy->diff($fecha_registro);

        if ($intervalo->m >= 6 && $usuario['estado'] === 'activo') {
            // Cambiar el estado a inactivo si han pasado 6 meses
            $queryUpdate = "UPDATE usuarios SET estado = 'inactivo' WHERE email = ?";
            $stmtUpdate = $conn->prepare($queryUpdate);
            $stmtUpdate->bind_param('s', $email);
            $stmtUpdate->execute();
            return 'inactivo';
        } else {
            return $usuario['estado'];
        }
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $query = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $nombre_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();

    if ($usuario) {
        // Verificar el estado de la cuenta del usuario
        $estadoCuenta = verificarEstadoCuenta($usuario['email']);

        if ($estadoCuenta === 'inactivo') {
            echo "<div class='alert alert-danger' class='text-center' role='alert'>Cuenta inactiva.</div>";
        } else {
            // Verifica si el usuario existe y la contraseña es correcta
            if (password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
                $_SESSION['rol'] = $usuario['rol'];
                header("Location: index.php");
                exit;
            } else {
                $error = "Credenciales incorrectas.";
            }
        }
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../img/internacional.png">
  
    <link rel="stylesheet" href="css/login.css">
    <style>

        .container {
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: auto;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            max-width: 400px;
            margin: auto;
            box-shadow: 10px 10px 10px rgba(108, 180, 228, 0.534);
            border: 3px solid rgba(108, 180, 228, 0.534);
            border-radius: 10px;
            text-align: center;
            margin-top: 100px;

        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #06779d;
        }
        .form-group label{
            color: #06779d;
        }
       
    </style>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <h2 class="text-center">Iniciar Sesión</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="nombre_usuario">Nombre de Usuario</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" placeholder="Nombre de Usuario" required>
                </div>
                <div class="form-group">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
            </form>
        </div>
    </div>

    <!-- Incluir jQuery y Bootstrap JS al final del documento -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
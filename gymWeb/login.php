<?php
session_start();
include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    
    if (empty($usuario) || empty($contraseña)) {
        $error = "Por favor, complete todos los campos";
    } else {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($contraseña, $user['contraseña'])) {
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['id_usuario'] = $user['id'];
            header("Location: tienda.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Tienda Gym</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <div class="login-container">
        <h1>Acceso a Tienda Gym</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
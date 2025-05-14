<?php
session_start();
include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitización básica
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $contraseña = filter_input(INPUT_POST, 'contraseña', FILTER_SANITIZE_STRING);
    
    if (empty($usuario) || empty($contraseña)) {
        $error = "Por favor, complete todos los campos";
    } else {
        // Prepared statement para evitar SQL injection
        $stmt = $conn->prepare("SELECT id, usuario, contraseña FROM usuarios WHERE usuario = ? LIMIT 1");
        $stmt->execute([$usuario]);
        
        if ($stmt->rowCount() == 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (password_verify($contraseña, $user['contraseña'])) {
                $_SESSION['usuario'] = htmlspecialchars($user['usuario']);
                $_SESSION['id_usuario'] = (int)$user['id'];
                header("Location: tienda.php");
                exit();
            }
        }
        
        $error = "Usuario o contraseña incorrectos";
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
        <h1>Acceso a Tienda de los magnates</h1>
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

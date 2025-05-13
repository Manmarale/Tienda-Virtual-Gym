<?php
include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    
    try {
        // Insertar cliente
        $stmt = $conn->prepare("INSERT INTO clientes (nombre, apellidos, correo) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $apellidos, $correo]);
        $id_cliente = $conn->lastInsertId();
        
        // Insertar usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, contraseña, id_cliente) VALUES (?, ?, ?)");
        $stmt->execute([$usuario, $contraseña, $id_cliente]);
        
        header("Location: login.php?registro=exito");
        exit();
    } catch(PDOException $e) {
        $error = "Error al registrar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Tienda Gym</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <div class="registro-container">
        <h1>Registro en Tienda Gym</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellidos" placeholder="Apellidos" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
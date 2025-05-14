<?php
include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitización de datos
    $usuario = trim(filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING));
    $contraseña = $_POST['contraseña'];
    $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
    $apellidos = trim(filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING));
    $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : NULL;
    $genero = !empty($_POST['genero']) ? $_POST['genero'] : NULL;

    // Validaciones
    $errores = [];
    if (empty($usuario)) $errores[] = "Usuario requerido";
    if (empty($contraseña)) $errores[] = "Contraseña requerida";
    if (strlen($contraseña) < 8) $errores[] = "La contraseña debe tener al menos 8 caracteres";
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "Email no válido";

    if (empty($errores)) {
        try {
            $conn->beginTransaction();

            // 1. Insertar cliente
            $stmtCliente = $conn->prepare("INSERT INTO clientes 
                (nombre, apellidos, correo, fecha_nacimiento, genero) 
                VALUES (?, ?, ?, ?, ?)");
            
            $stmtCliente->execute([
                $nombre,
                $apellidos,
                $correo,
                $fecha_nacimiento,
                $genero
            ]);
            
            $id_cliente = $conn->lastInsertId();

            // 2. Insertar usuario
            $hash = password_hash($contraseña, PASSWORD_BCRYPT);
            $stmtUsuario = $conn->prepare("INSERT INTO usuarios 
                (usuario, contraseña, id_cliente) 
                VALUES (?, ?, ?)");
                
            $stmtUsuario->execute([
                $usuario,
                $hash,
                $id_cliente
            ]);

            $conn->commit();
            header("Location: login.php?registro=exito");
            exit();

        } catch(PDOException $e) {
            $conn->rollBack();
            $error = "Error en el registro: " . $e->getMessage();
            // Para debugging:
            error_log("Error de registro: " . $e->getMessage());
            error_log("Consulta cliente: " . $sqlCliente ?? '');
            error_log("Consulta usuario: " . $sqlUsuario ?? '');
        }
    } else {
        $error = implode("<br>", $errores);
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
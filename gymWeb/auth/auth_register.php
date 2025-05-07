<?php
session_start();
include('../includes/conexion.php'); // Asegúrate de que la ruta sea correcta

$usuario = $_POST['usuario'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
$rol = $_POST['rol'];

// Verifica si el usuario existe
$sql_check = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt_check = $conexion->prepare($sql_check);
$stmt_check->bind_param("s", $usuario);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows > 0) {
    // Redirige de vuelta al formulario de registro (ajusta la ruta)
    header("Location: ../productos/register.php?error=El+usuario+ya+existe");
    exit();
}

// Inserta el nuevo usuario
$sql_insert = "INSERT INTO usuarios (usuario, contraseña, rol) VALUES (?, ?, ?)";
$stmt_insert = $conexion->prepare($sql_insert);
$stmt_insert->bind_param("sss", $usuario, $contraseña, $rol);

if ($stmt_insert->execute()) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = $rol;
    // Redirige a la página principal (ajusta la ruta)
    header("Location: ../index.php"); // O "../productos/index.php" si es necesario
} else {
    // Muestra el error y redirige
    die("Error al registrar: " . $stmt_insert->error);
}
?>
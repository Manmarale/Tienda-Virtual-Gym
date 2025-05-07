<?php
session_start();
include('../includes/conexion.php');

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

// Consulta preparada para evitar SQL injection
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($contraseña, $user['contraseña'])) {
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['rol'] = $user['rol'];
        header("Location: ../index.php");
    } else {
        header("Location: login.php?error=Contraseña incorrecta");
    }
} else {
    header("Location: login.php?error=Usuario no encontrado");
}

$stmt->close();
$conexion->close();
?>
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['referencia'])) {
    $referencia = $_POST['referencia'];
    $id_usuario = $_SESSION['id_usuario'];  
    $stmt = $conn->prepare("SELECT nombre FROM productos WHERE referencia = ?");
    $stmt->execute([$referencia]);
    $producto = $stmt->fetch();
    
    $mensaje = "¡Compra realizada! Has adquirido: " . $producto['nombre'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra - Tienda Gym</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <div class="compra-container">
        <?php if (isset($mensaje)): ?>
            <h1><?php echo $mensaje; ?></h1>
            <a href="tienda.php">Volver a la tienda</a>
        <?php else: ?>
            <h1>Error en el proceso de compra</h1>
            <a href="tienda.php">Volver a la tienda</a>
        <?php endif; ?>
    </div>
</body>
</html>
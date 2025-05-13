<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'includes/conexion.php';

// Obtener productos
$stmt = $conn->query("SELECT * FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Gym</title>
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>
<body>
    <header>
        <h1>Bienvenido a Tienda Gym, <?php echo $_SESSION['usuario']; ?></h1>
        <a href="logout.php">Cerrar sesión</a>
    </header>
    
    <main>
        <h2>Nuestros Productos</h2>
        <div class="productos-grid">
            <?php foreach ($productos as $producto): ?>
                <div class="producto">
                    <h3><?php echo $producto['nombre']; ?></h3>
                    <p><?php echo $producto['descripcion']; ?></p>
                    <p class="precio">€<?php echo number_format($producto['precio'], 2); ?></p>
                    <form action="proceso_compra.php" method="POST">
                        <input type="hidden" name="referencia" value="<?php echo $producto['referencia']; ?>">
                        <button type="submit">Comprar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    
    <footer>
        <p>Tienda Gym &copy; <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
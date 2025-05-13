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
        <h1>Bienvenido a la tienda de los magnates, <?php echo $_SESSION['usuario']; ?></h1>
        <a href="logout.php">Cerrar sesión</a>
    </header>
    
    <main>
        <h2>Nuestros Productos</h2>
        <div class="productos-grid">
    <?php foreach ($productos as $producto): ?>
        <div class="producto">
            <div class="producto-img-container">
                <?php 
                $imagenPath = "assets/img/producto_" . $producto['referencia'] . ".jpg";
                $imagenExists = file_exists($imagenPath);
                ?>
                <img src="<?php echo $imagenExists ? $imagenPath : 'assets/img/placeholder.jpg'; ?>" 
                     alt="<?php echo htmlspecialchars($producto['nombre']); ?>"
                     class="producto-img">
            </div>
            <div class="producto-content">
                <h3><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                <p><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                <div class="producto-footer">
                    <span class="precio">€<?php echo number_format($producto['precio'], 2); ?></span>
                    <form method="POST" action="proceso_compra.php">
                        <input type="hidden" name="referencia" value="<?php echo $producto['referencia']; ?>">
                        <button type="submit" class="btn-comprar">
                            <i class="fas fa-shopping-cart"></i> Añadir al carrito
                        </button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
    </main>
    
    <footer>
        <p>los magnates &copy; <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
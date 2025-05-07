<?php
include('../includes/conexion.php');
include('../includes/header.php');

$sql = "SELECT * FROM productos";
$result = $conexion->query($sql);
?>

<div class="container">
    <h1>Catálogo de Productos</h1>
    <div class="product-grid">
        <?php while($producto = $result->fetch_assoc()): ?>
        <div class="product-card">
            <img src="../assets/images/<?= $producto['imagen'] ?: 'default.jpg' ?>" alt="<?= $producto['nombre'] ?>">
            <div class="product-info">
                <h3><?= $producto['nombre'] ?></h3>
                <p><?= substr($producto['descripcion'], 0, 100) ?>...</p>
                <span class="price">€<?= $producto['precio'] ?></span>
                <a href="detalle.php?ref=<?= $producto['referencia'] ?>" class="btn">Ver Detalle</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
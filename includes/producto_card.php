<?php
// Este archivo espera que exista una variable $product (array asociativo)
// con los datos del producto actual.

// Asegurarse de que $product sea un array
if (!is_array($product)) {
    if (is_object($product)) {
        $product = (array) $product;
    } else {
        echo '<div style="color: red; padding: 20px; background: #ffe6e6; border: 1px solid #ff9999;">Error: Producto no válido.</div>';
        return;
    }
}
?>

<div class="product-card">
     <?php if (!empty($product['image'])): ?>
      <img src="<?= htmlspecialchars($product['image']) ?>" 
         alt="<?= htmlspecialchars($product['name']) ?>"
         onerror="this.src='<?= ASSETS_PATH ?>img/placeholder.jpg'; this.onerror=null;">
    <?php else: ?>
        <img src="<?= ASSETS_PATH ?>img/placeholder.jpg" alt="Sin imagen">
    <?php endif; ?>
    
    <div class="product-info">
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <?php if (!empty($product['silueta'])): ?>
            <p><strong>Silueta:</strong> <?= htmlspecialchars($product['silueta']) ?></p>
        <?php endif; ?>
        <p><?= htmlspecialchars(substr($product['description'] ?? '', 0, 100)) ?>...</p>
        <div class="price">€<?= number_format($product['price'] ?? 0, 2, ',', '.') ?></div>
        <a href="agendar_cita.php?producto_id=<?= $product['id'] ?>" class="btn-agendar">Agendar cita</a>
    </div>
</div>
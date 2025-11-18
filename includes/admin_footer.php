<?php
// Asegurarse de que las constantes estén definidas
require_once '../config/config.php';
?>

<footer class="admin-footer">
    <div class="footer-container">
        <!-- Logo y Copyright -->
        <div class="footer-logo-section">
            <img src="<?php echo ASSETS_PATH; ?>img/logo/logo_theveil.png" alt="The Veil Admin" class="footer-logo" />
            <p>© 2025 The Veil Admin. Solo personal autorizado.</p>
        </div>

        <!-- Acceso Rápido -->
        <div class="footer-links-section">
            <h3>Acceso Rápido</h3>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="citas.php">Citas</a></li>
            </ul>
        </div>

        <!-- Redes Sociales -->
        <div class="footer-social-section">
         <a href="https://www.instagram.com/" target="_blank" rel="noopener">
          <img src="<?php echo ASSETS_PATH; ?>img/icons/iconoinstagram.png" alt="Instagram" />
        </a>
        <a href="https://ar.pinterest.com/" target="_blank" rel="noopener">
          <img src="<?php echo ASSETS_PATH; ?>img/icons/iconopinterest.png" alt="Pinterest" />
        </a>
        <a href="https://www.facebook.com/?locale=es_LA" target="_blank" rel="noopener">
          <img src="<?php echo ASSETS_PATH; ?>img/icons/icono.png" alt="Facebook" />
        </a>
        </div>
    </div>
</footer>
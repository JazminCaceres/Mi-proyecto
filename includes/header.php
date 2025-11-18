<!-- Encabezado Principal -->
<header class="site-header">
  <div class="logo-container">
    <div class="logo-background">
      <img src="<?php echo ASSETS_PATH; ?>img/logo/logo_theveil.png" alt="The Veil Logo" class="brand-logo" />
    </div>
  </div>

  <!-- Menú Principal -->
  <nav class="main-nav">
    <ul class="nav-list">
      <li><a href="index.php">Inicio</a></li>
      <li><a href="vestidos.php">Vestidos de Novia</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle">Accesorios ▾</a>
        <div class="dropdown-content-grid">
          <a href="accesorios.php?tipo=zapatos" class="dropdown-item">
            <img src="<?=ASSETS_PATH ?>img/productos/zapatos2.jpg" alt="Zapatos" />
            <span>Zapatos</span>
          </a>
          <a href="accesorios.php?tipo=pendientes" class="dropdown-item">
            <img src="<?=ASSETS_PATH ?>img/productos/pendiente.jpg" alt="Pendientes" />
            <span>Pendientes</span>
          </a>
          <a href="accesorios.php?tipo=velos" class="dropdown-item">
            <img src="<?= ASSETS_PATH ?>img/productos/velo2.jpg" alt="Velos" />
            <span>Velos</span>
          </a>
        </div>
      </li>
      <li><a href="agendar_cita.php">Agenda Tu Cita</a></li>
      <li><a href="quienes_somos.php">Quiénes Somos</a></li>
    </ul>
  </nav>
</header>

<script src="<?php echo ASSETS_PATH; ?>js/dropdown.js"></script>
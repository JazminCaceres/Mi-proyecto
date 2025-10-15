<!-- includes/header.php -->
<div class="top-bar">
  <div class="social-icons">
    <a href="https://www.facebook.com/?locale=es_LA"><img src="assets/images/icons/icono.png" alt="Facebook" /></a>
    <a href="https://www.instagram.com/"><img src="assets/images/icons/iconoinstagram.png" alt="Instagram" /></a>
    <a href="https://ar.pinterest.com/"><img src="assets/images/icons/iconopinterest.png" alt="Pinterest" /></a>
  </div>
  <div class="user-cart-icons">
    <a href="#" class="user-link"><img src="assets/images/icons/user.png" alt="Iniciar Sesión" /> Iniciar Sesión</a>
    <a href="#" class="cart-link"><img src="assets/images/icons/bag.png" alt="Carrito" /></a>
  </div>
</div>

<header class="site-header">
  <div class="logo-container">
    <div class="logo-background">
      <img src="assets/images/logo-camellia.png" alt="The Veil Logo" class="brand-logo" />
    </div>
  </div>

  <nav class="main-nav">
    <ul>
      <li><a href="index.php">Inicio</a></li>
      <li><a href="vestidos.php">Vestidos de Novia</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle">Accesorios ▾</a>
        <div class="dropdown-content-grid">
          <a href="accesorios.php?tipo=zapatos" class="dropdown-item">
            <img src="assets/images/productos/zapatos2.jpg" alt="Zapatos" />
            <span>Zapatos</span>
          </a>
          <a href="accesorios.php?tipo=pendientes" class="dropdown-item">
            <img src="assets/images/productos/pendiente.jpg" alt="Pendientes" />
            <span>Pendientes</span>
          </a>
          <a href="accesorios.php?tipo=velos" class="dropdown-item">
            <img src="assets/images/productos/velo2.jpg" alt="Velos" />
            <span>Velos</span>
          </a>
          <a href="accesorios.php?tipo=tocados" class="dropdown-item">
            <img src="assets/images/productos/tocado3.jpg" alt="Tocados" />
            <span>Tocados</span>
          </a>
        </div>
      </li>
      <li><a href="agenda-cita.php">Agenda Tu Cita</a></li>
      <li><a href="quienes-somos.php">Quiénes Somos</a></li>
      <li><a href="testimonios.php">Qué Dicen las Novias</a></li>
    </ul>
  </nav>
</header>

<!-- Línea divisoria -->
<div class="divider-line"></div>

<!-- Breadcrumb -->
<nav aria-label="Breadcrumb" class="breadcrumb-nav">
  <ol class="breadcrumb">
    <?php if (isset($breadcrumb)) echo $breadcrumb; ?>
  </ol>
</nav>
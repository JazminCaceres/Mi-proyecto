<!-- includes/admin-header.php -->
<?php require_once '../includes/auth.php'; ?>

<div class="top-bar admin-top-bar">
  <div class="admin-welcome">
    Hola, <strong><?php echo htmlspecialchars(getAdminEmail()); ?></strong>
  </div>
  <div class="admin-actions">
    <a href="../index.php" target="_blank">Ver sitio público</a>
    <a href="logout.php" class="btn-logout">Cerrar sesión</a>
  </div>
</div>

<header class="site-header admin-header">
  <div class="logo-container">
    <div class="logo-background">
      <img src="../assets/images/logo-camellia.png" alt="The Veil Admin" class="brand-logo" />
    </div>
  </div>

  <nav class="main-nav">
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="productos.php">Gestionar Productos</a></li>
      <li><a href="citas.php">Gestionar Citas</a></li>
      <li><a href="novias.php">Novias Registradas</a></li>
      <li><a href="perfil.php">Mi Perfil</a></li>
    </ul>
  </nav>
</header>

<!-- Línea divisoria -->
<div class="divider-line"></div>
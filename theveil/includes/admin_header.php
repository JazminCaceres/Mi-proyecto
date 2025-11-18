<?php require_once '../includes/auth.php'; 
// Asegurarse de que las constantes estén definidas
require_once '../config/config.php';
?>

<!-- Barra Superior del Admin -->
<header class="admin-top-bar">
  <div class="admin-brand">
    <img src="<?php echo ASSETS_PATH; ?>img/logo/logo_theveil.png" alt="The Veil Admin" class="brand-logo" />
    <h2>The Veil Administrador</h2>
  </div>

  <nav class="admin-nav">
    <a href="dashboard.php">Dashboard</a>
    <a href="productos.php">Productos</a>
    <a href="citas.php">Citas</a>
    <a href="novias.php">Novias</a>
    <a href="perfil.php">Mi Perfil</a>
  </nav>

  <div class="admin-actions">
    <span class="welcome-text">Hola, <strong><?php echo htmlspecialchars(getAdminEmail()); ?></strong></span>
    <a href="../index.php" target="_blank" class="btn-view-site">Ver sitio público</a>
    <a href="logout.php" class="btn-logout">Cerrar sesión</a>
  </div>
</header>
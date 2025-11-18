<?php
require_once '../includes/auth.php';
requireAdminLogin();

require_once '../classes/Database.php';
require_once '../classes/Product.php';
require_once '../classes/Appointment.php';

$pdo = (new Database())->getConnection();
$product = new Product($pdo);
$appointment = new Appointment($pdo);

$total_products = count($product->getAll());
$total_appointments = count($appointment->getAll());
$pending_appointments = $pdo->query("SELECT COUNT(*) FROM appointments WHERE estado = 'pendiente'")->fetchColumn();
$registered_novias = $pdo->query("SELECT COUNT(*) FROM novias")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - The Veil Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>

  <?php include '../includes/admin-header.php'; ?>

  <main class="admin-main">

    <!-- Hero Section -->
    <div class="hero-dashboard">
      <h1>Dashboard</h1>
      <p>Bienvenido, <strong><?php echo htmlspecialchars(getAdminEmail()); ?></strong></p>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-number"><?php echo $total_products; ?></div>
        <div class="stat-label">Productos Totales</div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-number"><?php echo $pending_appointments; ?></div>
        <div class="stat-label">Citas Pendientes</div>
      </div>

      <div class="stat-card">
        <div class="stat-icon">👰</div>
        <div class="stat-number"><?php echo $registered_novias; ?></div>
        <div class="stat-label">Novias Registradas</div>
      </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="quick-actions">
      <a href="productos.php" class="action-btn">🔍 Ver Productos</a>
      <a href="citas.php" class="action-btn">📝 Gestionar Citas</a>
      <a href="novias.php" class="action-btn">👥 Novias Registradas</a>
    </div>

    <!-- Últimas Citas (opcional) -->
    <div class="recent-section">
      <h3>Últimas Citas Agendadas</h3>
      <table class="appointments-table">
        <thead>
          <tr>
            <th>Novia</th>
            <th>Fecha</th>
            <th>Servicio</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $stmt = $pdo->prepare("SELECT a.*, n.nombre AS novia_nombre FROM appointments a LEFT JOIN novias n ON a.novia_id = n.id ORDER BY a.fecha_cita DESC LIMIT 5");
          $stmt->execute();
          $last_appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

          foreach ($last_appointments as $ap): ?>
            <tr>
              <td><?php echo htmlspecialchars($ap['novia_nombre'] ?? 'Sin nombre'); ?></td>
              <td><?php echo $ap['fecha_cita']; ?></td>
              <td><?php echo htmlspecialchars($ap['servicio']); ?></td>
              <td><span class="status-<?php echo $ap['estado']; ?>"><?php echo ucfirst($ap['estado']); ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </main>

  <?php include '../includes/admin-footer.php'; ?>

</body>
</html>
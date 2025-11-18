<?php
require_once '../includes/auth.php';
requireAdminLogin();

require_once '../config/Database.php';
require_once '../classes/Appointment.php';

$pdo = (new Database())->getConnection();
$appointment = new Appointment($pdo);

// Obtener todas las citas con datos de la novia
$stmt = $pdo->prepare("
  SELECT a.*, n.nombre AS novia_nombre, n.email AS novia_email
  FROM appointments a
  LEFT JOIN novias n ON a.novia_id = n.id
  ORDER BY a.fecha_cita DESC, a.hora_cita
");
$stmt->execute();
$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Citas Agendadas - The Veil Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>

  <?php include '../includes/admin_header.php'; ?>
   
    <div class=admin-container>
      <main class="admin-main">

        <h1>Gestionar Citas</h1>

        <!-- Botón para volver -->
        <a href="dashboard.php" class="btn-back">← Volver al Dashboard</a>

        <!-- Tabla de citas -->
        <div class="appointments-table-container">
          <table class="appointments-table">
            <thead>
              <tr>
                <th>nombre</th>
                <th>apellido</th>
                <th>Email</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Servicio</th>
                <th>Asesora Preferida</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($citas): ?>
                <?php foreach ($citas as $c): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($c['nombre'] ?? 'Sin nombre'); ?></td>
                    <td><?php echo htmlspecialchars($c['apellido']?? 'Sin apellido'); ?></td>
                    <td><?php echo htmlspecialchars($c['email'] ?? ''); ?></td>
                    <td><?php echo $c['fecha_cita']; ?></td>
                    <td><?php echo $c['hora_cita']; ?></td>
                    <td><?php echo htmlspecialchars($c['servicio']); ?></td>
                    <td><?php echo htmlspecialchars($c['asesora_preferida'] ?? 'No asignada'); ?></td>
                    <td><span class="status-<?php echo $c['estado']; ?>"><?php echo ucfirst($c['estado']); ?></span></td>
                    <td>
                      <a href="#" onclick="confirmStatusChange(<?php echo $c['id']; ?>, 'confirmada')" class="action-link">Confirmar</a> |
                      <a href="#" onclick="confirmStatusChange(<?php echo $c['id']; ?>, 'cancelada')" class="action-link">Cancelar</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" style="text-align: center; padding: 20px;">No hay citas agendadas.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </main>
    

      <?php include '../includes/admin_footer.php'; ?>
    </div>  

  <script>
    function confirmStatusChange(id, nuevoEstado) {
      const mensaje = nuevoEstado === 'confirmada' ? 
        "¿Estás seguro de confirmar esta cita?" : 
        "¿Estás seguro de cancelar esta cita?";

      if (confirm(mensaje)) {
        window.location.href = 'actualizar_cita.php?id=' + id + '&estado=' + nuevoEstado;
      }
    }
  </script>

</body>
</html>
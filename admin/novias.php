<?php
// admin/novias.php
require_once '../includes/auth.php';
requireAdminLogin();

require_once '../config/Database.php';
require_once '../classes/Novia.php';

$pdo = (new Database())->getConnection();
$novia = new Novia($pdo);

$novias = $novia->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Novias Registradas - The Veil Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>

  <?php include '../includes/admin_header.php'; ?>
    
    <div class=admin-container>
      <main class="admin-main">
        <h1>Novias Registradas</h1>
        <p>Total: <?php echo count($novias); ?></p>

        <?php if ($novias): ?>
          <table class="appointments-table">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Ciudad</th>
                <th>Fecha Boda</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($novias as $n): ?>
                <tr>
                  <td><?php echo htmlspecialchars($n['nombre'] . ' ' . $n['apellido']); ?></td>
                  <td><?php echo htmlspecialchars($n['email']); ?></td>
                  <td><?php echo htmlspecialchars($n['telefono']); ?></td>
                  <td><?php echo htmlspecialchars($n['ciudad']); ?></td>
                  <td><?php echo $n['fecha_boda'] ? $n['fecha_boda'] : 'Sin definir'; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>No hay novias registradas aún.</p>
        <?php endif; ?>
      </main>

     <?php include '../includes/admin_footer.php'; ?>

    </div>  


</body>
</html>
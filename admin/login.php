<?php
// admin/login.php
require_once '../classes/Auth.php';
require_once '../classes/user.php';
require_once '../classes/Database.php';

// Si ya está logueado, redirige al dashboard
if (Auth::isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_POST) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $pdo = (new Database())->getConnection();
        $user = new User($pdo);
        $admin = $user->findByEmail($email);

        if ($admin && password_verify($password, $admin['password'])) {
            Auth::login($admin);
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Email o contraseña incorrectos.';
        }
    } catch (Exception $e) {
        $error = 'Error en el sistema. Intente más tarde.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Iniciar Sesión - The Veil Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body class="login-body">

  <?php include '../includes/admin_header.php'; ?>

  <div class="login-container">
    <div class="brand">
      <h2>The Veil Admin</h2>
      <p>Panel de gestión seguro</p>
    </div>

    <!-- Mensaje de éxito al cerrar sesión -->
    <?php if (isset($_GET['logged_out'])): ?>
      <div class="alert success">Sesión cerrada correctamente.</div>
    <?php endif; ?>

    <!-- Mensaje de error -->
    <?php if ($error): ?>
      <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <!-- Formulario de login -->
    <form method="POST">
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required />
      </div>
      <div class="form-group">
        <label>Contraseña</label>
        <input type="password" name="password" required />
      </div>
      <button type="submit" class="btn-primary">Ingresar</button>
    </form>
  </div>

  <?php include '../includes/admin_footer.php'; ?>
</body>
</html>
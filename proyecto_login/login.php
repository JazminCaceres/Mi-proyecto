<?php
session_start();


if (isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';

    if ($usuario && $contrasena) {
        require_once 'config/db.php';

        $stmt = $pdo->prepare("SELECT id, usuario, contrasena FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($contrasena, $user['contrasena'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario'] = $user['usuario'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); width: 350px; }
        .form-container h2 { text-align: center; margin-bottom: 20px; color: #333; }
        .form-container input { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .form-container button { width: 100%; padding: 12px; background: #007BFF; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .form-container button:hover { background: #0056b3; }
        .error { color: #e74c3c; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Iniciar Sesión</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
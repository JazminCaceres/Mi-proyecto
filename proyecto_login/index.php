<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
$usuario = htmlspecialchars($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; padding: 0; }
        header { background: #343a40; color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center; }
        main { padding: 2rem; text-align: center; }
        .welcome { font-size: 1.5rem; color: #495057; margin-bottom: 1.5rem; }
        .card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
        .logout-btn { background: #dc3545; color: white; text-decoration: none; padding: 8px 16px; border-radius: 4px; }
        .logout-btn:hover { background: #c82333; }
    </style>
</head>
<body>
    <header>
        <h2>Panel de Control</h2>
        <a href="logout.php" class="logout-btn">Cerrar sesión</a>
    </header>
    <main>
        <div class="card">
            <div class="welcome">¡Bienvenido, <strong><?= $usuario ?></strong>!</div>
            <p>Has ingresado correctamente al sistema.</p>
        </div>
    </main>
</body>
</html>
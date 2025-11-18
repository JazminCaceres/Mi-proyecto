<<?php
require_once 'config/config.php';
require_once 'config/Database.php';

$error = '';
$success = '';

if ($_POST) {
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $fecha_cita = $_POST['fecha_cita'] ?? '';
    $hora_cita = $_POST['hora_cita'] ?? '';
    $servicio = $_POST['servicio'] ?? '';
    $asesora = trim($_POST['asesora_preferida'] ?? '');
    $comentarios = trim($_POST['comentarios'] ?? '');

    // Validaciones
    if (!$nombre || !$email || !$telefono || !$fecha_cita || !$hora_cita || !$servicio) {
        $error = 'Todos los campos marcados con * son obligatorios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'El email no es válido.';
    } elseif (strtotime("$fecha_cita $hora_cita") < time()) {
        $error = 'La fecha y hora deben ser futuras.';
    } else {
        try {
            $pdo = (new Database())->getConnection();
            $sql = "INSERT INTO appointments (nombre, apellido, email, telefono, fecha_cita, hora_cita, servicio, asesora_preferida, comentarios) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nombre, $apellido, $email, $telefono, $fecha_cita, $hora_cita, $servicio, $asesora, $comentarios]);

            $success = '¡Cita agendada con éxito! Nos pondremos en contacto contigo pronto.';
            $_POST = []; // Limpiar formulario
        } catch (Exception $e) {
            $error = 'Error al agendar. Por favor, inténtalo más tarde.';
        }
    }
}

// Cargar producto si viene desde una tarjeta
$producto_id = $_GET['producto_id'] ?? null;
$producto_nombre = '';
if ($producto_id) {
    try {
        $pdo = (new Database())->getConnection();
        $stmt = $pdo->prepare("SELECT name FROM products WHERE id = ?");
        $stmt->execute([$producto_id]);
        $prod = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($prod) $producto_nombre = $prod['name'];
    } catch (Exception $e) {}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/style.css">
    
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main class="page-content">
        <section class="cita-hero">
            <h1>Agenda Tu Cita</h1>
            <p>Reserva tu hora para encontrar el look perfecto para tu gran día</p>
        </section>

        <section class="form-container">
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label class="required">Nombre completo</label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="required">Apellido</label>
                    <input type="text" name="apellido" value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="required">Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>

                <div class="form-group">
                    <label class="required">Teléfono</label>
                    <input type="tel" name="telefono" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" placeholder="+54 11 1234-5678" required>
                </div>

                <div class="form-group">
                    <label class="required">Fecha de la Cita</label>
                    <input type="date" name="fecha_cita" value="<?= $_POST['fecha_cita'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label class="required">Hora de la Cita</label>
                    <input type="time" name="hora_cita" value="<?= $_POST['hora_cita'] ?? '' ?>" required>
                </div>

                <div class="form-group">
                    <label class="required">Servicio de interés</label>
                    <select name="servicio" required>
                        <option value="">Selecciona...</option>
                        <option value="vestido" <?= ($_POST['servicio'] ?? '') === 'vestido' ? 'selected' : '' ?>>Vestido de Novia</option>
                        <option value="zapatos" <?= ($_POST['servicio'] ?? '') === 'zapatos' ? 'selected' : '' ?>>Zapatos</option>
                        <option value="pendientes" <?= ($_POST['servicio'] ?? '') === 'pendientes' ? 'selected' : '' ?>>Pendientes</option>
                        <option value="velos" <?= ($_POST['servicio'] ?? '') === 'velos' ? 'selected' : '' ?>>Velos</option>
                        <option value="asesoria completa" <?= ($_POST['servicio'] ?? '') === 'asesoria completa' ? 'selected' : '' ?>>Asesoría Completa</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Asesora preferida (opcional)</label>
                    <input type="text" name="asesora_preferida" value="<?= htmlspecialchars($_POST['asesora_preferida'] ?? '') ?>" placeholder="Ej: María López">
                </div>

                <div class="form-group">
                    <label>Mensaje / Comentarios (opcional)</label>
                    <textarea name="comentarios" placeholder="¿Tienes alguna preferencia o comentario?"><?= htmlspecialchars($_POST['comentarios'] ?? '') ?></textarea>
                </div>

                <button type="submit" class="btn-submit">Agendar Cita</button>
            </form>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
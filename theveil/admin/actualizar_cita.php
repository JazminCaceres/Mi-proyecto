<?php
require_once '../includes/auth.php';
requireAdminLogin();

require_once '../config/Database.php';
require_once '../classes/Appointment.php';

$id = $_GET['id'] ?? null;
$estado = $_GET['estado'] ?? null;

// Validar entrada
$estadosPermitidos = ['pendiente', 'confirmada', 'cancelada'];
if (!$id || !in_array($estado, $estadosPermitidos)) {
    header('Location: citas.php?error=1');
    exit;
}

$pdo = (new Database())->getConnection();
$appointment = new Appointment($pdo);

if ($appointment->updateStatus($id, $estado)) {
    header("Location: citas.php?success=$estado");
} else {
    header('Location: citas.php?error=1');
}
exit;
?>
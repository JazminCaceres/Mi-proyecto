<?php
require_once '../includes/auth.php';
requireAdminLogin();

require_once '../config/Database.php';
require_once '../classes/Product.php';

$pdo = (new Database())->getConnection();
$product = new Product($pdo);

$id = $_GET['id'] ?? null;

if ($id && $product->delete($id)) {
    header('Location: productos.php?deleted=1');
} else {
    header('Location: productos.php?error=1');
}
exit;
?>
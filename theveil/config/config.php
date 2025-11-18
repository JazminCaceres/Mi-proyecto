<?php
// config/config.php

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Definir constantes globales
define('SITE_NAME', 'The Veil | Atelier de Novias');
define('BASE_URL', 'http://localhost/theveil/'); // Cambia esto si usas un dominio real
define('ASSETS_PATH', BASE_URL . 'assets/');
define('UPLOADS_PATH', __DIR__ . '/../uploads/');

// Configurar zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Funciones de autenticación (opcional)
function isAdmin() {
    return isset($_SESSION['admin_id']);
}

/*
function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>*/
<?php
// includes/auth.php

require_once '../classes/Auth.php';

/**
 * Verifica si el admin está logueado
 */
function isAdminLoggedIn() {
    return Auth::isLoggedIn();
}

/**
 * Redirige si no está logueado
 */
function requireAdminLogin() {
    Auth::requireAuth();
}

/**
 * Obtiene el email del admin actual
 */
function getAdminEmail() {
    return Auth::getAdminEmail();
}

/**
 * Cierra sesión del admin
 */
function logoutAdmin() {
    session_start();
    session_destroy();
}
?>
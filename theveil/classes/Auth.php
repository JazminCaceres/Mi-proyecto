<?php
// classes/Auth.php

class Auth {
    public static function login($user) {
        // Solo inicia sesión si no está activa
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_email'] = $user['email'];
    }

    public static function isLoggedIn() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['admin_id']);
    }

    public static function requireAuth() {
        if (!self::isLoggedIn()) {
            header('Location: login.php');
            exit;
        }
    }

    public static function logout() {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }

    public static function getAdminEmail() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['admin_email'] ?? 'Usuario';
    }

    public static function getAdminId() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        return $_SESSION['admin_id'] ?? null;
    }
}
?>
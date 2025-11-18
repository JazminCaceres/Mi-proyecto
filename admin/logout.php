<?php
// admin/logout.php

// Incluye el archivo que tiene la función logoutAdmin()
require_once '../includes/auth.php';

// Cierra la sesión
logoutAdmin(); // Esta función llama a session_destroy()

// Redirige al login con un mensaje
header('Location: login.php?logged_out=1');
exit;
?>
<?php
// admin/logout.php
require_once '../includes/auth.php';
logoutAdmin();
header('Location: login.php?logged_out=1');
exit;
?>
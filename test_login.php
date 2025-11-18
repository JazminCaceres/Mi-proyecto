<?php
// test-login.php

echo "<h2>🔍 Prueba de Login - Depuración</h2><hr>";

// 1. Verificar conexión a la base de datos
echo "<h3>1. Conexión a la Base de Datos</h3>";
try {
    require_once 'classes/Database.php';
    $db = new Database();
    $pdo = $db->getConnection();
    echo "✅ Conexión exitosa a la base de datos.<br>";
} catch (Exception $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
    die();
}

// 2. Buscar el admin en la BD
echo "<h3>2. Buscando al usuario admin@theveil.com</h3>";
try {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute(['admin@theveil.com']);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        echo "✅ Usuario encontrado:<br>";
        echo "ID: " . $admin['id'] . "<br>";
        echo "Email: " . $admin['email'] . "<br>";
        echo "Hash almacenado: " . $admin['password'] . "<br><br>";

        // 3. Probar verificación de contraseña
        echo "<h3>3. Verificación de Contraseña</h3>";
        if (password_verify('admin123', $admin['password'])) {
            echo "✅ <strong>password_verify('admin123', \$hash) → CORRECTO</strong><br>";
            echo "🔐 Puedes iniciar sesión con 'admin123'<br>";
        } else {
            echo "❌ <strong>password_verify('admin123', \$hash) → FALLÓ</strong><br>";
            echo "🔑 El hash NO coincide con 'admin123'<br>";
        }
    } else {
        echo "❌ No se encontró ningún usuario con email 'admin@theveil.com'<br>";
        echo "⚠️ Debes insertarlo con el SQL correcto.<br>";
    }
} catch (Exception $e) {
    echo "❌ Error al consultar la tabla 'admins': " . $e->getMessage() . "<br>";
}

echo "<hr><p><small>Si todo está bien, deberías ver ✅ en todos los pasos.</small></p>";
?>
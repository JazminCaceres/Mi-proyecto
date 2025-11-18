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

  //<?php echo ASSETS_PATH; ?> 





  //*<!-- Sección Quiénes Somos -->
        <section class="about-us-section">
            <div class="container">
                <div class="about-us-grid">
                    <div class="about-us-text">
                        <h2>The Veil</h2>
                        <p>Nos especializamos en vestidos de novia de alta costura, diseñados con amor y atención al detalle. Ofrecemos colecciones exclusivas inspiradas en la elegancia y la sofisticación.</p>
                        <a href="quienes_somos.php" class="btn-secondary">Saber Más</a>
                    </div>
                    <div class="about-us-image">
                        <img src="<?php echo ASSETS_PATH; ?>img/inicio/presentacion.jpg" alt="Novia The Veil" />
                    </div>
                </div>
            </div>
        </section>



        /* ==================== */
/* === QUIÉNES SOMOS === */
/* ==================== */

.about-us-section {
  padding: 80px 0;
  background-color: var(--bg-base);
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.about-us-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 50px;
  align-items: center;
}

.about-us-text h2 {
  font-family: var(--font-title);
  font-size: 2.5rem;
  color: var(--charcoal);
  margin-bottom: 20px;
}

.about-us-text p {
  font-size: 1.1rem;
  line-height: 1.6;
  color: var(--charcoal);
  margin-bottom: 30px;
}

.btn-secondary {
  display: inline-block;
  background-color: transparent;
  color: var(--charcoal);
  padding: 12px 30px;
  border: 2px solid var(--charcoal);
  border-radius: 5px;
  text-decoration: none;
  font-weight: bold;
  transition: all 0.3s ease;
}

.btn-secondary:hover {
  background-color: var(--charcoal);
  color: white;
}

.about-us-image img {
  width: 100%;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* ==================== */
/* === RESPONSIVO === */
/* ==================== */

@media (max-width: 768px) {
  .hero-content h2 {
      font-size: 2rem;
  }

  .about-us-grid {
      grid-template-columns: 1fr;
      gap: 30px;
  }

  .about-us-text {
      text-align: center;
  }
}

<?php
// Configuración inicial
define('ASSETS_PATH', 'assets/');
$page_title = "The Veil - Vestidos de Novia de Alta Costura";
$breadcrumb = '<li class="breadcrumb-item active" aria-current="page">Inicio</li>';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>The Veil | Atelier de Novias</title>
  <!-- Usa ASSETS_PATH para cargar el CSS -->
  <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/style.css" />
</head>
<body>

  <?php include 'includes/header.php'; ?>
   
  <main>
        <!-- Hero Banner -->
        <section class="hero-banner">
            <img src="<?php echo ASSETS_PATH; ?>img/inicio/herobanner" alt="Novia con vestido" class="hero-image" />
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <h2>Descubre tu vestido ideal</h2>
                <a href="vestidos.php" class="btn-primary">Ver Colección</a>
            </div>
        </section>

        <!-- Sección Quiénes Somos Mejorada y Centrada -->
        <section class="about-us-section enhanced" aria-labelledby="about-us-title">
            <div class="container">
                <div class="about-us-grid centered">
                    <div class="about-us-text">
                        <h2 id="about-us-title" class="section-title centered">The Veil</h2>
                        <p class="about-us-description centered">
                            Nos especializamos en vestidos de novia de alta costura, diseñados con amor 
                            y atención al detalle. Ofrecemos colecciones exclusivas inspiradas en la 
                            elegancia y la sofisticación.
                        </p>
                        <div class="button-container centered">
                            <a href="quienes_somos.php" class="btn btn-secondary">Saber Más</a>
                        </div>
                    </div>
                    <div class="about-us-image">
                        <img 
                            src="<?php echo ASSETS_PATH; ?>img/inicio/presentacion.jpg" 
                            alt="Novia con vestido The Veil posando elegantemente" 
                            class="about-image"
                            loading="lazy"
                        />
                    </div>
                </div>
            </div>
        </section>




        <!-- seccion de agendar cita -->
        <section class="appointment-cta-section">
            <div class="container">
                <div class="appointment-cta-content">
                    <h2 class="cta-title"> ¿Lista para vivir la experiencia The Veil? </h2>
                    <p class="cta-text"> Agenda una cita y descubre el vestido de tus sueños </p>

                    <a href="agendar_cita.php" class="btn btn-primary"> agendar mi cita </a>
                </div>  
                
            </div>   
            
         </section>    








    </main>
  








  <?php include 'includes/footer.php'; ?>

</body>
</html>
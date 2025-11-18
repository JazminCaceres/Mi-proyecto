<?php
// Configuración inicial
define('ASSETS_PATH', 'assets/');
$page_title = "The Veil - Quiénes Somos";
$breadcrumb = '<li class="breadcrumb-item"><a href="index.php">Inicio</a></li><li class="breadcrumb-item active" aria-current="page">Quiénes Somos</li>';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    
    <!-- Estilos -->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/style.css">
    
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Incluir Header -->
    <?php include 'includes/header.php'; ?>

    <main class="main-content">

        <!-- Hero Section para Quiénes Somos -->
        <section class="page-hero">
            <div class="container">
                <div class="hero-content">
                    <h1>Quiénes Somos</h1>
                    <p>Conoce la historia, pasión y dedicación detrás de The Veil</p>
                </div>
            </div>
        </section>

        <!-- Sección Principal -->
        <section class="page-section quienes-somos">
            <div class="container">
  
                <!-- Historia + Filosofía + Nombre en una sección -->
                <div class="historia-filosofia-container">
                    <div class="historia-filosofia-image">
                        <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/bocetovestido.jpg" alt="Nuestra historia The Veil" loading="lazy" />
                    </div>
  
                    <div class="historia-filosofia-texto">
                        <!-- La Historia -->
                        <div class="historia">
                            <h2>La Historia de The Veil</h2>
                            <p>
                                Todo comenzó hace más de 5 años en Corrientes, donde nació The Veil con el sueño de convertir en realidad el vestido perfecto para cada novia. Con pasión por el diseño nupcial y dedicación absoluta, hemos crecido sin perder nuestra esencia.
                            </p>
                            <p>
                                Hoy contamos con una trayectoria consolidada, ofreciendo atenciones personalizadas y un catálogo amplio de vestidos y accesorios exclusivos que se adaptan a los gustos de cada novia.
                            </p>
                        </div>
  
                        <!-- Filosofía -->
                        <div class="filosofia">
                            <h2>Nuestra Filosofía</h2>
                            <p>
                                Creemos que el día más especial de tu vida merece ser celebrado desde el primer momento. Por eso, nos guían valores como la autenticidad, el respeto a la identidad de cada novia y la excelencia en cada servicio.
                            </p>
                        </div>
  
                        <!-- El nombre -->
                        <div class="nombre-marca">
                            <h2>El Nombre "The Veil"</h2>
                            <p>
                                "Veil" significa velo en inglés. Elegimos este nombre porque simboliza misterio, belleza y la revelación de quien eres en el altar. Queremos que cada novia se sienta única, elegante y emocionada al descubrir su vestido ideal.
                            </p>
                        </div>
                    </div>
                </div>
  
                <!-- Misión y Visión -->
                <div class="destacados">
                    <div class="destacado-box mission">
                        <div class="icono"></div>
                        <h3>Misión</h3>
                        <p>
                            Brindar a cada novia una experiencia inolvidable, ayudándola a encontrar su vestido ideal y hacerla sentir especial desde el primer momento hasta el día de su boda.
                        </p>
                    </div>
                    <div class="destacado-box vision">
                        <div class="icono"></div>
                        <h3>Visión</h3>
                        <p>
                            Convertirnos en un referente en vestidos de novia en Corrientes y en toda Argentina, siendo reconocidos por nuestro trato cercano y calidad en cada prenda.
                        </p>
                    </div>
                </div>
  
                <!-- Equipo -->
                <div class="equipo">
                    <div class="section-header">
                        <h2>Nuestro Equipo</h2>
                        <p>Profesionales apasionados por hacer de tu día especial algo inolvidable</p>
                    </div>
                    <div class="team-grid">
                        <div class="team-card">
                            <div class="team-image">
                                <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/fundadora.jpg" alt="Ana López - Diseñadora principal y fundadora" loading="lazy" />
                            </div>
                            <h4>Ana López</h4>
                            <span class="team-role">Diseñadora Principal</span>
                            <p>Fundadora y apasionada por la moda nupcial con más de 5 años de experiencia.</p>
                        </div>

                        <div class="team-card">
                            <div class="team-image">
                                <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/asesor.jpg" alt="Marta Ríos - Asesora de estilo" loading="lazy" />
                            </div>
                            <h4>Marta Ríos</h4>
                            <span class="team-role">Asesora de Estilo</span>
                            <p>Especialista en encontrar el vestido perfecto para cada personalidad.</p>
                        </div>

                        <div class="team-card">
                            <div class="team-image">
                                <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/encargada.jpg" alt="Camila Fernández - Coordinadora" loading="lazy" />
                            </div>
                            <h4>Camila Fernández</h4>
                            <span class="team-role">Coordinadora</span>
                            <p>Encargada del proceso integral y coordinación con proveedores.</p>
                        </div>

                        <div class="team-card">
                            <div class="team-image">
                                <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/asesorlaura.jpg" alt="Laura Martinez- asesora de novias" loading="lazy" />
                            </div>
                            <h4>Laura Martinez</h4>
                            <span class="team-role">Asesora de Novias</span>
                            <p>Especialista en atención personalizadas y experiencia en compra memorable.</p>
                        </div>

                        <div class="team-card">
                            <div class="team-image">
                                <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/asesorcarlos.jpg" alt="Carlos Rodriguez - especialista en  accesorios" loading="lazy" />    
                            </div>
                            <h4>Carlos Rodriguez</h4>
                            <span class="team-role">Especialista en Accesorios</span>
                            <p>Experto en complementar el look nupcial con los accesorios perfectos.</p>
                        </div>

                        <div class="team-card">
                            <div class="team-image">
                                <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/asesorvalentina.jpg" alt="Valentina Herrera - diseñadora asistente" loading="lazy" />
                            </div>
                            <h4>Valentina Herrera</h4>
                            <span class="team-role">Diseñadora Asistente</span>
                            <p> Creativa apasionada por los detalles y la perfección en cada acabado.</p>
                        </div>

                    </div>
                </div>
  
                <!-- Ubicación -->
                <div class="ubicacion">
                    <div class="section-header">
                        <h2>Nuestra Ubicación</h2>
                        <p>Corrientes, corazón del norte argentino</p>
                    </div>
                    <div class="ubicacion-content">
                        <div class="ubicacion-texto">
                            <p>
                                Estamos ubicados en Corrientes, corazón del norte argentino. Este lugar nos inspira y nos permite conectar profundamente con cada novia local y nacional. Nuestra ubicación estratégica nos permite servir a novias de toda la región.
                            </p>
                            <div class="ubicacion-details">
                                <div class="detail-item">
                                    <span class="detail-icon">📍</span>
                                    <span>Corrientes, Argentina</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-icon">⏰</span>
                                    <span>Lun a Vie: 9:00 - 18:00</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-icon">📞</span>
                                    <span>+54 379 123-4567</span>
                                </div>
                            </div>
                        </div>
                        <div class="ubicacion-mapa">
                            <!-- Aquí puedes agregar un mapa de Google Maps -->
                            <div class="mapa-placeholder">
                                <span>📍 Mapa de ubicación</span>
                                <p>Corrientes, Argentina</p>
                            </div>
                        </div>
                    </div>
                </div>
  
                <!-- Galería -->
                <div class="galeria">
                    <div class="section-header">
                        <h2>Galería de Imágenes</h2>
                        <p>Un vistazo a nuestro mundo The Veil</p>
                    </div>
                    <div class="gallery-grid">
                        <div class="gallery-item">
                            <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/atelier.jpg" alt="Atelier The Veil" loading="lazy" />
                        </div>
                        <div class="gallery-item">
                            <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/vestido.jpg" alt="Equipo trabajando" loading="lazy" />
                        </div>
                        <div class="gallery-item">
                            <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/bordado1.jpg" alt="Detalles de bordados" loading="lazy" />
                        </div>
                        <div class="gallery-item">
                            <img src="<?php echo ASSETS_PATH; ?>img/quienes_somos/pruebavestido.jpg" alt="Novia probándose vestido" loading="lazy" />
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="quienes-somos-cta">
                    <h3>¿Lista para vivir la experiencia The Veil?</h3>
                    <p>Agenda una cita y descubre el vestido de tus sueños</p>
                    <a href="agendar_cita.php" class="btn btn-primary">Agendar Mi Cita</a>
                </div>
  
            </div>
        </section>

    </main>

    <!-- Incluir Footer -->
    <?php include 'includes/footer.php'; ?>

</body>
</html>
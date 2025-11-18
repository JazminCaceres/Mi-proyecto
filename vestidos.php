<?php
// Incluir configuración global (session_start(), constantes, etc.)
require_once 'config/config.php';
// No necesitamos autenticación aquí, es público
// Pero sí necesitamos conexión a BD y clase Product
require_once 'config/Database.php';
require_once 'classes/Product.php';

$pdo = (new Database())->getConnection();
$product = new Product($pdo);

// === PAGINACIÓN ===
$limit = 6; // Productos por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Evitar página 0 o negativa
$offset = ($page - 1) * $limit;

// Obtener filtro de silueta
$siluetaFiltro = trim($_GET['silueta'] ?? '');

// Definir opciones de silueta
$opcionesSilueta = [
    'sirena' => 'Sirena',
    'princesa' => 'Princesa',
    'encaje' => 'Encaje',
    'elegante' => 'Elegante'
];

// Contar productos y obtener datos
if ($siluetaFiltro && isset($opcionesSilueta[$siluetaFiltro])) {
    $total = $product->countByCategoryAndSilueta('vestido', [$siluetaFiltro]);
    $vestidos = $product->getPaginatedByCategoryAndSilueta('vestido', [$siluetaFiltro], $limit, $offset);
} else {
    $total = $product->countByCategory('vestido');
    $vestidos = $product->getPaginatedByCategory('vestido', $limit, $offset);
    $siluetaFiltro = '';
}

$totalPages = ceil($total / $limit);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vestidos de Novia - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/style.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main class="page-content page-vestidos">
        <!-- Hero Section - Estilo Base -->
        <div class="page-producto-hero">
            <div class="hero-content">
                <h1>Vestidos de Novia</h1>
                <p>Encuentra el vestido perfecto para tu gran día</p>
            </div>
        </div>    
       

        <!-- Filtros -->
       <!-- Layout con filtros a la izquierda -->
        <div class="products-layout">
            <!-- Sidebar de filtros -->
            <aside class="filters-sidebar">
                <h3>Filtrar Vestidos</h3>
                <form method="GET" class="filters-form">
                    <label>Filtrar por silueta:</label>
                    <select name="silueta" onchange="this.form.submit()">
                        <option value="">Todas las siluetas</option>
                        <option value="sirena" <?= isset($_GET['silueta']) && $_GET['silueta'] === 'sirena' ? 'selected' : '' ?>>Sirena</option>
                        <option value="princesa" <?= isset($_GET['silueta']) && $_GET['silueta'] === 'princesa' ? 'selected' : '' ?>>Princesa</option>
                        <option value="encaje" <?= isset($_GET['silueta']) && $_GET['silueta'] === 'encaje' ? 'selected' : '' ?>>Encaje</option>
                        <option value="elegante" <?= isset($_GET['silueta']) && $_GET['silueta'] === 'elegante' ? 'selected' : '' ?>>Elegante</option>
                    </select>
                </form>
            </aside>

            <!-- Contenedor de productos -->
            <section class="products-container">
                <div class="products-grid">
                    <?php if (empty($vestidos)): ?>
                        <div class="no-products">
                            Aún no hay vestidos disponibles. ¡Vuelve pronto!
                        </div>
                    <?php else: ?>
                        <?php foreach ($vestidos as $vestido): ?>
                            <?php $product = $vestido; ?>
                            <?php include 'includes/producto_card.php'; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>



        
        <!-- Paginación -->
        <!-- Paginación -->
        <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <div class="pagination-item">
                    <a href="?<?= http_build_query(array_filter(array_merge($_GET, ['page' => $page - 1]))) ?>" class="pagination-link">«</a>
                    <span class="pagination-text">Anterior</span>
                </div>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="pagination-current"><?= $i ?></span>
                <?php else: ?>
                    <a href="?<?= http_build_query(array_filter(array_merge($_GET, ['page' => $i]))) ?>" class="pagination-link"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <div class="pagination-item">
                    <span class="pagination-text">Siguiente</span>
                    <a href="?<?= http_build_query(array_filter(array_merge($_GET, ['page' => $page + 1]))) ?>" class="pagination-link">»</a>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </main>

    <?php include 'includes/footer.php'; ?>

    <!-- Script opcional: alerta al hacer clic en "Agendar cita" -->
    <script>
        document.querySelectorAll('.btn-agendar').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                alert('¡Pronto podrás agendar tu cita sin registrarte!');
                window.location.href = this.href;
            });
        });
    </script>


   

</body>
</html>
<?php
// Incluir configuración global
require_once 'config/config.php';
require_once 'config/Database.php';
require_once 'classes/Product.php';

$pdo = (new Database())->getConnection();
$product = new Product($pdo);


// === PAGINACIÓN ===
$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);
$offset = ($page - 1) * $limit;


// Obtener el tipo de accesorio desde la URL
$tipo = $_GET['tipo'] ?? 'todos';
$subtipo = trim($_GET['subtipo'] ?? '');


// Mapeo de tipos a palabras clave en la columna 'silueta'
$mapeoSilueta = [
    'zapatos' => ['zapato', 'stiletto', 'adornos', 'sandalias', 'clásico'],
    'pendientes' => ['pendiente', 'pendiente largo ', 'pendiente corto', 'oreja'],
    'velos' => ['velo corto', 'velo largo', 'encaje', 'cabeza', 'novia'],
    'todos' => [] // Mostrar todos los accesorios
];

$titulo = match($tipo) {
    'zapatos' => 'Zapatos de Novia',
    'pendientes' => 'Pendientes de Novia',
    'velos' => 'Velos de Novia',
    default => 'Accesorios de Novia'
};

$descripcion = match($tipo) {
    'zapatos' => 'Completa tu look con los zapatos perfectos para tu gran día.',
    'pendientes' => 'Brilla con elegancia con nuestros pendientes diseñados para novias.',
    'velos' => 'Añade un toque de romanticismo con nuestro exclusivo catálogo de velos.',
    default => 'Descubre nuestros accesorios exclusivos para tu boda.'
};

// Definir opciones de subfiltro según el tipo
$opcionesSubfiltro = [];
if ($tipo === 'zapatos') {
    $opcionesSubfiltro = ['stiletto' => 'Stilettos', 'adorno' => 'Adornos', 'sandalias' => 'Sandalias', 'clásico' => 'Clásicos'];
} elseif ($tipo === 'pendientes') {
    $opcionesSubfiltro = [ 'pendientes largo' => 'Pendientes largo', 'pendientes cortos' => 'Pendientes cortos'];
} elseif ($tipo === 'velos') {
    $opcionesSubfiltro = ['velo corto' => 'Velo corto', 'velo largo' => 'Velo largo'];
}


// Obtener productos
// Contar y obtener productos
if ($tipo === 'todos') {
    $total = $product->countByCategory('accesorio');
    $accesorios = $product->getPaginatedByCategory('accesorio', $limit, $offset);
} else {
    if ($subtipo && isset($opcionesSubfiltro[$subtipo])) {
        $total = $product->countByCategoryAndSilueta('accesorio', [$subtipo]);
        $accesorios = $product->getPaginatedByCategoryAndSilueta('accesorio', [$subtipo], $limit, $offset);
    } else {
        $keywords = $mapeoSilueta[$tipo] ?? [];
        $total = $product->countByCategoryAndSilueta('accesorio', $keywords); // ← ¡Añadido!
        $accesorios = $product->getPaginatedByCategoryAndSilueta('accesorio', $keywords, $limit, $offset);
        $subtipo = '';
    }
}

$totalPages = ceil($total / $limit);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?> - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>css/style.css">
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <main class="page-content page-accesorios">

        <div class="page-producto-hero">
            <div class="hero-content">
                <h1><?= htmlspecialchars($titulo) ?></h1>
                <p><?= htmlspecialchars($descripcion) ?></p>
           </div>
        </div>


        <!-- Layout con filtros a la izquierda -->
        <div class="products-layout">
            <!-- Sidebar de filtros -->
            <aside class="filters-sidebar">
                <h3>Filtrar <?= htmlspecialchars($titulo) ?></h3>
                <form method="GET" class="filters-form">
                    <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo) ?>">
                    <label>Filtrar por tipo:</label>
                    <select name="subtipo" onchange="this.form.submit()">
                        <option value="">Todos los <?= strtolower(explode(' ', $titulo)[0]) ?></option>
                        <?php foreach ($opcionesSubfiltro as $valor => $label): ?>
                            <option value="<?= htmlspecialchars($valor) ?>" <?= $subtipo === $valor ? 'selected' : '' ?>>
                                <?= htmlspecialchars($label) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </aside>

            <!-- Contenedor de productos -->
            <section class="products-container">
                <div class="products-grid">
                    <?php if (empty($accesorios)): ?>
                        <div class="no-products">
                            No se encontraron accesorios con ese filtro. ¡Prueba otra opción!
                        </div>
                    <?php else: ?>
                        <?php foreach ($accesorios as $item): ?>
                            <?php $product = $item; ?>
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
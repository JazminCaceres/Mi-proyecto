<?php

require_once '../includes/auth.php';
requireAdminLogin();

require_once '../config/Database.php';
require_once '../config/config.php';
require_once '../classes/Product.php';

$pdo = (new Database())->getConnection();
$product = new Product($pdo);


// Obtener parámetros de búsqueda y filtros
$search = trim($_GET['search'] ?? '');
$category = $_GET['category'] ?? '';
$order_by = $_GET['order_by'] ?? 'id DESC';

// Obtener productos filtrados
$products = $product->searchAndFilter($search, $category, $order_by);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Productos - The Veil Admin</title>
  <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/style.css">
</head>
<body>

  <?php include '../includes/admin_header.php'; ?>

  <div class=admin-container>
      <main class="admin-main">
        <h1>Gestión de Productos</h1>
        <a href="agregar_producto.php" class="btn-primary">➕ Agregar Producto</a>

         <!-- Buscador y Filtros -->
        <div class="admin-filters">
            <form method="GET" class="filters-form">
                <div class="filter-group">
                    <label>Buscar:</label>
                    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Nombre, categoría, silueta..." />
                </div>

                <div class="filter-group">
                    <label>Categoría:</label>
                    <select name="category" onchange="this.form.submit()">
                        <option value="">Todas las categorías</option>
                        <option value="vestido" <?= isset($_GET['category']) && $_GET['category'] === 'vestido' ? 'selected' : '' ?>>Vestido</option>
                        <option value="accesorio" <?= isset($_GET['category']) && $_GET['category'] === 'accesorio' ? 'selected' : '' ?>>Accesorio</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Ordenar por:</label>
                    <select name="order_by" onchange="this.form.submit()">
                        <option value="id DESC" <?= isset($_GET['order_by']) && $_GET['order_by'] === 'id DESC' ? 'selected' : '' ?>>ID (descendente)</option>
                        <option value="name ASC" <?= isset($_GET['order_by']) && $_GET['order_by'] === 'name ASC' ? 'selected' : '' ?>>Nombre (ascendente)</option>
                        <option value="price ASC" <?= isset($_GET['order_by']) && $_GET['order_by'] === 'price ASC' ? 'selected' : '' ?>>Precio (ascendente)</option>
                        <option value="price DESC" <?= isset($_GET['order_by']) && $_GET['order_by'] === 'price DESC' ? 'selected' : '' ?>>Precio (descendente)</option>
                        <option value="created_at DESC" <?= isset($_GET['order_by']) && $_GET['order_by'] === 'created_at DESC' ? 'selected' : '' ?>>Fecha (más reciente)</option>
                    </select>
                </div>

                <button type="submit" class="btn-primary">Buscar</button>
                <a href="productos.php" class="btn-secondary">Limpiar filtros</a>
            </form>
        </div>

        <!-- Tabla de productos -->
        <?php if ($products): ?>
          <table class="appointments-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($products as $p): ?>
                <tr>
                  <td><?php echo $p['id']; ?></td>
                  <td><?php echo htmlspecialchars($p['name']); ?></td>
                  <td><?php echo ucfirst($p['category']); ?></td>
                  <td>$<?php echo number_format($p['price'], 2); ?></td>
                  <td>
                      <?php
                      // Obtener la ruta de la imagen desde la BD
                      $imagePath = trim($p['image']);
                      
                      if (!empty($imagePath)) {
                          // La imagen en BD puede estar como:
                          // - "img/productos/vestido1.jpg"
                          // - "assets/img/productos/vestido1.jpg"
                          // - "productos/vestido1.jpg"
                          
                          // Limpiar cualquier "assets/" inicial
                          $cleanPath = preg_replace('#^assets/#', '', $imagePath);
                          $cleanPath = ltrim($cleanPath, '/');
                          
                          // Construir URL completa usando ASSETS_PATH (que ya incluye 'assets/')
                          $imageUrl = ASSETS_PATH . $cleanPath;
                          
                          // Para verificar existencia: usar ruta del sistema de archivos
                          // Estamos en /admin/, así que subimos un nivel y entramos a /assets/
                          $fullPath = __DIR__ . '/../assets/' . $cleanPath;
                          $imageExists = file_exists($fullPath);
                      } else {
                          $imageExists = false;
                          $imageUrl = '';
                          $cleanPath = '';
                      }
                      ?>
                      
                      <?php if (!empty($imagePath)): ?>
                          <img src="<?= htmlspecialchars($imageUrl); ?>" 
                               alt="<?= htmlspecialchars($p['name']); ?>" 
                               style="width:50px; height:50px; object-fit:cover; border-radius:4px; display:<?= $imageExists ? 'block' : 'none' ?>;" 
                               onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                          <div style="display:<?= $imageExists ? 'none' : 'flex' ?>; width:50px; height:50px; background:#f5f5f5; align-items:center; justify-content:center; border-radius:4px; font-size:1.2rem; color:#999;" title="Error al cargar: <?= htmlspecialchars($cleanPath) ?>">
                              📷
                          </div>
                      <?php else: ?>
                          <div style="width:50px; height:50px; background:#f5f5f5; display:flex; align-items:center; justify-content:center; border-radius:4px; font-size:1.2rem; color:#999;" title="Sin imagen">
                              ❌
                          </div>
                      <?php endif; ?>
                  </td>
                  <td>
                    <a href="editar_producto.php?id=<?php echo $p['id']; ?>" class="btn-secondary" style="margin-right:5px;">✏️ Editar</a>
                    <a href="eliminar_producto.php?id=<?php echo $p['id']; ?>" class="btn-danger" onclick="return confirmDelete(event)" >🗑️ Eliminar</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php else: ?>
          <p>No hay productos registrados aún.</p>
        <?php endif; ?>

      </main>
    </div>  

  <?php include '../includes/admin_footer.php'; ?>

  <script src="<?= ASSETS_PATH; ?>js/admin_productos.js"></script>


</body>
</html>
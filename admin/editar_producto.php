<?php
require_once '../includes/auth.php';
requireAdminLogin();

require_once '../config/Database.php';
require_once '../config/config.php';
require_once '../classes/Product.php';

$pdo = (new Database())->getConnection();
$product = new Product($pdo);

$id = $_GET['id'] ?? null;
$prod = $product->getById($id);

if (!$prod) {
    die("Producto no encontrado.");
}

$error = '';
$success = '';

if ($_POST) {
    $data = [
        'name' => $_POST['name'] ?? '',
        'category' => $_POST['category'] ?? '',
        'silueta' => $_POST['silueta'] ?? '',
        'description' => $_POST['description'] ?? '',
        'price' => $_POST['price'] ?? ''
    ];

    // Validaciones básicas
    if (!$data['name'] || !$data['category'] || !$data['price']) {
        $error = 'Nombre, categoría y precio son obligatorios.';
    } elseif (!is_numeric($data['price']) || $data['price'] <= 0) {
        $error = 'El precio debe ser un número positivo.';
    } else {
        $imagePath = $prod['image']; // Por defecto, mantener la imagen actual

            // Si se subió una nueva imagen
          if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $baseDir = __DIR__ . '/../'; // Sube un nivel desde admin/
            $uploadDir = $baseDir . 'assets/img/productos/';
            $fileTmpPath = $_FILES['image_file']['tmp_name'];
            $fileName = $_FILES['image_file']['name'];
            $fileSize = $_FILES['image_file']['size'];
            $fileType = $_FILES['image_file']['type'];

            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!in_array($fileType, $allowedTypes)) {
                $error = 'Solo se permiten imágenes JPG, PNG o WebP.';
            } elseif ($fileSize > 5 * 1024 * 1024) {
                $error = 'La imagen no debe superar los 5MB.';
            } else {
                $fileName = uniqid('prod_') . '_' . basename($fileName);
                $destPath = $uploadDir . $fileName;

                // Mover la nueva imagen 
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    // Eliminar imagen anterior si existe
                    $oldImagePath = $baseDir . $prod['image'];
                    if ($oldImagePath && file_exists( $oldImagePath)) {
                        unlink( $oldImagePath);
                    }
                    $imagePath = 'assets/img/productos/' . $fileName;
                } else {
                    $error = 'Error al guardar la imagen. Verifica permisos o espacio en disco.';
                }
            }
          }
        // Si no hubo error, actualizar producto
        if (!$error) {
            $data['image'] = $imagePath;
            if ($product->update($id, $data)) {
                header('Location: productos.php?updated=1');
                exit;
            } else {
                $error = 'Error al actualizar el producto en la base de datos.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Producto - The Veil Admin</title>
  <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>css/style.css">

  
</head>



<body>

  <?php include '../includes/admin_header.php'; ?>

  <main class="admin-main">
    <h1>Editar Producto</h1>

    <?php if ($error): ?>
      <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Nombre *</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($prod['name']); ?>" required />
      </div>

      <div class="form-group">
        <label>Categoría *</label>
        <select name="category" required>
          <option value="">Selecciona...</option>
          <option value="vestido" <?php echo $prod['category'] == 'vestido' ? 'selected' : ''; ?>>Vestido</option>
          <option value="accesorio" <?php echo $prod['category'] == 'accesorio' ? 'selected' : ''; ?>>Accesorio</option>
        </select>
      </div>

      <div class="form-group">
        <label>Silueta (opcional)</label>
        <input type="text" name="silueta" value="<?php echo htmlspecialchars($prod['silueta']); ?>" placeholder="Ej: salón, stilettos, velo largo" />
      </div>

      <div class="form-group">
        <label>Descripción</label>
        <textarea name="description" rows="4"><?php echo htmlspecialchars($prod['description']); ?></textarea>
      </div>

      <div class="form-group">
        <label>Precio * ($)</label>
        <input type="number" step="0.01" name="price" value="<?php echo $prod['price']; ?>" required />
      </div>

      <!-- Imagen Actual -->
      <div class="current-image">
        <label>Imagen Actual</label>
        <?php if ($prod['image']): ?>
            <img src="../<?= htmlspecialchars($prod['image']) ?>"
                alt="Imagen actual"
                onerror="this.src='../assets/img/placeholder.jpg'; this.onerror=null;"
                style="max-width: 200px;"/>
        <?php else: ?>
           <p>No hay imagen asignada.</p>
        <?php endif; ?>
      </div>

      <!-- Nueva Imagen -->
      <div class="form-group">
        <label>Cambiar Imagen (opcional)</label>
        <input type="file" name="image_file" accept="image/*" />
        <small>Deja vacío para mantener la imagen actual. Formatos: JPG, PNG, WebP | Máx: 5MB</small>
      </div>

      <button type="submit" class="btn-primary">Guardar Cambios</button>
      <a href="productos.php" class="btn-back">Cancelar</a>
    </form>
  </main>

  <?php include '../includes/admin_footer.php'; ?>

</body>
</html>
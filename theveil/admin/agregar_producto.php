<?php
require_once '../includes/auth.php';
requireAdminLogin();

require_once '../config/Database.php';
require_once '../classes/Product.php';

$pdo = (new Database())->getConnection();
$product = new Product($pdo);

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
        $imagePath = ''; // Inicializar vacío

        // Verificar si se subió una imagen
        if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image_file']['tmp_name'];
            $fileName = $_FILES['image_file']['name'];
            $fileSize = $_FILES['image_file']['size'];
            $fileType = $_FILES['image_file']['type'];

            // Validar tipo de archivo
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!in_array($fileType, $allowedTypes)) {
                $error = 'Solo se permiten imágenes JPG, PNG o WebP.';
            } elseif ($fileSize > 5 * 1024 * 1024) { // 5MB máximo
                $error = 'La imagen no debe superar los 5MB.';
            } else {
                // Nombre único para evitar conflictos
                $fileName = uniqid('prod_') . '_' . basename($fileName);
                $baseDir = __DIR__ . '/../'; // Sube dos niveles desde admin/
                $uploadDir = $baseDir . 'assets/img/productos/';
                $destPath = $uploadDir . $fileName;


                // Mover la nueva imagen al servidor
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    $imagePath = 'assets/img/productos/' . $fileName; // Ruta relativa para BD
                } else {
                    $error = 'Error al mover la imagen. Verifica permisos de la carpeta.';
                }
            }
        } else {
            $error = 'Debes subir una imagen.';
        }

        // Si no hay error, guardar producto
        if (!$error && !empty($imagePath)) {
            $data['image'] = $imagePath;
            if ($product->create($data)) {
                header('Location: productos.php?created=1');
                exit;
            } else {
                $error = 'Error al guardar en la base de datos.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Agregar Producto - The Veil Admin</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <style>
    .form-group label,
    .form-group input,
    .form-group select,
    .form-group textarea,
    .form-group button {
      display: block;
      width: 100%;
      margin-bottom: 10px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group select,
    .form-group textarea {
      padding: 8px;
      border: 1px solid var(--gray-pearl);
      border-radius: 5px;
    }

    .btn-back {
      background: #6c757d;
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 10px;
      display: inline-block;
    }
  </style>
</head>
<body>

  <?php include '../includes/admin_header.php'; ?>

  <main class="admin-main">
    <h1>Agregar Nuevo Producto</h1>

    <?php if ($error): ?>
      <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Nombre *</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required />
      </div>

      <div class="form-group">
        <label>Categoría *</label>
        <select name="category" required>
          <option value="">Selecciona...</option>
          <option value="vestido" <?php echo ($_POST['category'] ?? '') == 'vestido' ? 'selected' : ''; ?>>Vestido</option>
          <option value="accesorio" <?php echo ($_POST['category'] ?? '') == 'accesorio' ? 'selected' : ''; ?>>Accesorio</option>
        </select>
      </div>

      <div class="form-group">
        <label>Silueta (opcional)</label>
        <input type="text" name="silueta" value="<?php echo htmlspecialchars($_POST['silueta'] ?? ''); ?>" placeholder="Ej: salón, stilettos, velo largo" />
      </div>

      <div class="form-group">
        <label>Descripción</label>
        <textarea name="description" rows="4"><?php echo htmlspecialchars($_POST['description'] ?? ''); ?></textarea>
      </div>

      <div class="form-group">
        <label>Precio * ($)</label>
        <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($_POST['price'] ?? ''); ?>" required />
      </div>

      <div class="form-group">
        <label>Imagen del Producto *</label>
        <input type="file" name="image_file" accept="image/*" required />
        <small>Formatos: JPG, PNG, WebP | Máx: 5MB</small>
      </div>

      <button type="submit" class="btn-primary">Guardar Producto</button>
      <a href="productos.php" class="btn-back">Cancelar</a>
    </form>
  </main>

  <?php include '../includes/admin_footer.php'; ?>

</body>
</html>
<?php
// classes/Product.php

class Product {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene todos los productos
     */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM products ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un producto por ID
     */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo producto
     */
    public function create($data) {
        $sql = "INSERT INTO products (name, category, silueta, description, price, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['category'],
            $data['silueta'] ?? '',
            $data['description'] ?? '',
            $data['price'],
            $data['image'] ?? ''
        ]);
    }

    /**
     * Actualiza un producto existente
     */
    public function update($id, $data) {
        $sql = "UPDATE products SET name = ?, category = ?, silueta = ?, description = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['category'],
            $data['silueta'] ?? '',
            $data['description'] ?? '',
            $data['price'],
            $data['image'] ?? '',
            $id
        ]);
    }

    /**
     * Elimina un producto
     */
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Obtener productos por categoría
     */
    public function getByCategory($category, $orderBy = 'created_at DESC') {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category = ? ORDER BY $orderBy");
        $stmt->execute([$category]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener por categoría y palabras clave en 'silueta'
     */
    public function getByCategoryAndSilueta($category, $siluetaKeywords, $orderBy = 'created_at DESC') {
        // Validar que $orderBy sea uno de los valores permitidos
        switch ($orderBy) {
            case 'created_at ASC':
                $orderClause = 'created_at ASC';
                break;
            case 'price ASC':
                $orderClause = 'price ASC';
                break;
            case 'price DESC':
                $orderClause = 'price DESC';
                break;
            case 'name ASC':
                $orderClause = 'name ASC';
                break;
            case 'name DESC':
                $orderClause = 'name DESC';
                break;
            case 'created_at DESC':
            default:
                $orderClause = 'created_at DESC';
                break;
        }
    
        // Construir la condición WHERE
        $conditions = [];
        $params = [$category];
        
        foreach ($siluetaKeywords as $keyword) {
            $conditions[] = "silueta LIKE ?";
            $params[] = "%$keyword%";
        }
        
        $whereClause = implode(" OR ", $conditions);
    
        // Construir la consulta con ORDER BY fijo
        $sql = "SELECT * FROM products WHERE category = ? AND ($whereClause) ORDER BY $orderClause";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener productos con paginación
     */
    public function getPaginatedByCategory($category, $limit, $offset, $orderBy = 'created_at DESC') {
        // Validar que $orderBy sea uno de los valores permitidos
        switch ($orderBy) {
            case 'created_at ASC':
                $orderClause = 'created_at ASC';
                break;
            case 'price ASC':
                $orderClause = 'price ASC';
                break;
            case 'price DESC':
                $orderClause = 'price DESC';
                break;
            case 'name ASC':
                $orderClause = 'name ASC';
                break;
            case 'name DESC':
                $orderClause = 'name DESC';
                break;
            case 'created_at DESC':
            default:
                $orderClause = 'created_at DESC';
                break;
        }
        
        // Convertir a enteros
        $limit = (int)$limit;
        $offset = (int)$offset;
    
        $sql = "SELECT * FROM products WHERE category = :category ORDER BY $orderClause LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener productos con paginación y filtro de silueta
     */
    public function getPaginatedByCategoryAndSilueta($category, $siluetaKeywords, $limit, $offset, $orderBy = 'created_at DESC') {
        // Validar que $orderBy sea uno de los valores permitidos
        switch ($orderBy) {
            case 'created_at ASC':
                $orderClause = 'created_at ASC';
                break;
            case 'price ASC':
                $orderClause = 'price ASC';
                break;
            case 'price DESC':
                $orderClause = 'price DESC';
                break;
            case 'name ASC':
                $orderClause = 'name ASC';
                break;
            case 'name DESC':
                $orderClause = 'name DESC';
                break;
            case 'created_at DESC':
            default:
                $orderClause = 'created_at DESC';
                break;
        }

        if (empty($siluetaKeywords)) {
            return $this->getPaginatedByCategory($category, $limit, $offset, $orderClause);
        }

        // Convertir a enteros
        $limit = (int)$limit;
        $offset = (int)$offset;

        // Construir condiciones y parámetros
        $conditions = [];
        $paramIndex = 1;
        
        foreach ($siluetaKeywords as $keyword) {
            $conditions[] = "silueta LIKE :silueta$paramIndex";
            $paramIndex++;
        }
        $whereClause = implode(" OR ", $conditions);

        // Construir la consulta con named parameters
        $sql = "SELECT * FROM products WHERE category = :category AND ($whereClause) ORDER BY $orderClause LIMIT :limit OFFSET :offset";
        
        $stmt = $this->pdo->prepare($sql);
        
        // Bind de la categoría
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);
        
        // Bind de los parámetros de silueta
        $paramIndex = 1;
        foreach ($siluetaKeywords as $keyword) {
            $stmt->bindValue(":silueta$paramIndex", "%$keyword%", PDO::PARAM_STR);
            $paramIndex++;
        }
        
        // Bind de limit y offset
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Contar productos por categoría
     */
    public function countByCategory($category) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM products WHERE category = ?");
        $stmt->execute([$category]);
        return $stmt->fetchColumn();
    }

    /**
     * Contar productos por categoría y silueta
     */
    public function countByCategoryAndSilueta($category, $siluetaKeywords) {
        if (empty($siluetaKeywords)) {
            return $this->countByCategory($category);
        }

        $conditions = [];
        $params = [$category];
        foreach ($siluetaKeywords as $keyword) {
            $conditions[] = "silueta LIKE ?";
            $params[] = "%$keyword%";
        }
        $whereClause = implode(" OR ", $conditions);

        $sql = "SELECT COUNT(*) FROM products WHERE category = ? AND ($whereClause)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }



   // Obtener productos con búsqueda y filtros (pagina de productos.php)
   public function searchAndFilter($search = '', $category = '', $orderBy = 'id DESC') {
    $conditions = [];
    $params = [];

    // Búsqueda general
    if (!empty($search)) {
        $conditions[] = "(name LIKE ? OR category LIKE ? OR silueta LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    // Filtro por categoría
    if (!empty($category)) {
        $conditions[] = "category = ?";
        $params[] = $category;
    }

    // Construir la consulta
    $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
    $sql = "SELECT * FROM products $whereClause ORDER BY $orderBy";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
        




      
}
?>
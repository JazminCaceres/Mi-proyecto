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
}
?>
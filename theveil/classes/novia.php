<?php
// classes/Novia.php

class Novia {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene todas las novias
     */
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM novias ORDER BY creado_en DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca una novia por email
     */
    public function getByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM novias WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva novia
     */
    public function create($data) {
        $sql = "INSERT INTO novias (nombre, apellido, email, telefono, ciudad, fecha_boda, preferencias, acompanantes) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['apellido'] ?? '',
            $data['email'],
            $data['telefono'] ?? '',
            $data['ciudad'] ?? '',
            $data['fecha_boda'] ?? null,
            $data['preferencias'] ?? '',
            $data['acompanantes'] ?? 1
        ]);
    }

    /**
     * Actualiza una novia existente
     */
    public function update($id, $data) {
        $sql = "UPDATE novias SET nombre = ?, apellido = ?, telefono = ?, ciudad = ?, fecha_boda = ?, preferencias = ?, acompanantes = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['nombre'],
            $data['apellido'] ?? '',
            $data['telefono'] ?? '',
            $data['ciudad'] ?? '',
            $data['fecha_boda'] ?? null,
            $data['preferencias'] ?? '',
            $data['acompanantes'] ?? 1,
            $id
        ]);
    }
}
?>
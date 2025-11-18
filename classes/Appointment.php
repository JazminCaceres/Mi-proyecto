<?php
// classes/Appointment.php

class Appointment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtiene todas las citas con datos de la novia
     */
    public function getAll() {
        $sql = "SELECT a.*, n.nombre AS novia_nombre 
                FROM appointments a 
                LEFT JOIN novias n ON a.novia_id = n.id 
                ORDER BY a.fecha_cita DESC, a.hora_cita";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una cita por ID
     */
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva cita
     */
    public function create($data) {
        $sql = "INSERT INTO appointments (novia_id, fecha_cita, hora_cita, servicio, asesora_preferida, comentarios, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['novia_id'],
            $data['fecha_cita'],
            $data['hora_cita'],
            $data['servicio'],
            $data['asesora_preferida'] ?? '',
            $data['comentarios'] ?? '',
            $data['estado'] ?? 'pendiente'
        ]);
    }

    /**
     * Actualiza el estado de una cita
     */
    public function updateStatus($id, $estado) {
        $stmt = $this->pdo->prepare("UPDATE appointments SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }
}
?>
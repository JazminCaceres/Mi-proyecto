<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'theveil';
    private $username = 'root';
    private $password = '';
    private $pdo;

    public function getConnection() {
        $this->pdo = null;
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4", 
                $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
        return $this->pdo;
    }
}
?>
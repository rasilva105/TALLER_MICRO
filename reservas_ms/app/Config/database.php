<?php
class Database {
    private string $host     = 'localhost';
    private string $db_name  = 'reservas_db';
    private string $username = 'root';
    private string $password = '';
    private ?PDO   $conn     = null;

    public function getConnection(): PDO {
        if ($this->conn !== null) return $this->conn;
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error de conexión: ' . $e->getMessage()]);
            exit;
        }
        return $this->conn;
    }
}

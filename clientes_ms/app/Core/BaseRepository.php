<?php
require_once __DIR__ . '/Repository.php';
require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/../Config/database.php';

/**
 * Repositorio base abstracto.
 * Implementa la interfaz Repository y provee la conexión PDO a las subclases.
 * POO: herencia, encapsulamiento, template method.
 */
abstract class BaseRepository implements Repository {
    protected PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    /** Ejecuta una consulta preparada y retorna todos los registros */
    protected function query(string $sql, array $params = []): array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /** Ejecuta una consulta preparada y retorna un solo registro */
    protected function queryOne(string $sql, array $params = []): ?array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** Ejecuta un INSERT/UPDATE/DELETE y retorna éxito */
    protected function execute(string $sql, array $params = []): bool {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /** Retorna el último ID insertado */
    protected function lastId(): int {
        return (int)$this->db->lastInsertId();
    }
}

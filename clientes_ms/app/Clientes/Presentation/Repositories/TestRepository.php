<?php
require_once __DIR__ . '/../../../../Core/BaseRepository.php';

class TestRepository extends BaseRepository {
    public function findAll(): array        { return []; }
    public function findById(int $id): ?array { return null; }
    public function create(Model $m): array  { return []; }
    public function delete(int $id): bool    { return false; }

    public function ping(): array {
        try {
            $this->db->query("SELECT 1");
            return ['status' => 'ok', 'service' => 'clientes_ms', 'db' => 'connected'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

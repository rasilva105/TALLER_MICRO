<?php
require_once __DIR__ . '/../../../../Core/BaseRepository.php';
require_once __DIR__ . '/../../Models/Cliente.php';

/**
 * Repositorio de clientes. Extiende BaseRepository (POO: herencia, polimorfismo).
 */
class ClientesRepository extends BaseRepository {

    private function hydrate(array $row): array {
        return (new Cliente())->fill($row)->toArray();
    }

    public function findAll(): array {
        return array_map([$this, 'hydrate'],
            $this->query("SELECT * FROM clientes ORDER BY id ASC"));
    }

    public function findById(int $id): ?array {
        $row = $this->queryOne("SELECT * FROM clientes WHERE id = ?", [$id]);
        return $row ? $this->hydrate($row) : null;
    }

    public function create(Model $model): array {
        /** @var Cliente $model */
        $this->execute(
            "INSERT INTO clientes (nombre, telefono, correo, numero_licencia) VALUES (?, ?, ?, ?)",
            [$model->nombre, $model->telefono, $model->correo, $model->numero_licencia]
        );
        $model->id = $this->lastId();
        return $model->toArray();
    }

    public function update(int $id, array $data): ?array {
        $current = $this->findById($id);
        if (!$current) return null;
        $merged = array_merge($current, $data);
        $this->execute(
            "UPDATE clientes SET nombre=?, telefono=?, correo=?, numero_licencia=? WHERE id=?",
            [$merged['nombre'], $merged['telefono'], $merged['correo'], $merged['numero_licencia'], $id]
        );
        return $this->findById($id);
    }

    public function delete(int $id): bool {
        return $this->execute("DELETE FROM clientes WHERE id = ?", [$id]);
    }
}

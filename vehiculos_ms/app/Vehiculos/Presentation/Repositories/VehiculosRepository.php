<?php
require_once __DIR__ . '/../../../../Core/BaseRepository.php';
require_once __DIR__ . '/../../Models/Vehiculo.php';

/**
 * Repositorio de vehículos.
 * Extiende BaseRepository e implementa Repository (POO: herencia, polimorfismo).
 */
class VehiculosRepository extends BaseRepository {

    private function hydrate(array $row): array {
        return (new Vehiculo())->fill($row)->toArray();
    }

    public function findAll(): array {
        $rows = $this->query("SELECT * FROM vehiculos ORDER BY id ASC");
        return array_map([$this, 'hydrate'], $rows);
    }

    public function findById(int $id): ?array {
        $row = $this->queryOne("SELECT * FROM vehiculos WHERE id = ?", [$id]);
        return $row ? $this->hydrate($row) : null;
    }

    public function findByEstado(string $estado): array {
        $rows = $this->query("SELECT * FROM vehiculos WHERE estado = ? ORDER BY id ASC", [$estado]);
        return array_map([$this, 'hydrate'], $rows);
    }

    public function create(Model $model): array {
        /** @var Vehiculo $model */
        $this->execute(
            "INSERT INTO vehiculos (marca, modelo, anio, categoria, estado) VALUES (?, ?, ?, ?, ?)",
            [$model->marca, $model->modelo, $model->anio, $model->categoria, $model->estado]
        );
        $model->id = $this->lastId();
        return $model->toArray();
    }

    public function updateEstado(int $id, string $estado): bool {
        $v = new Vehiculo();
        try {
            $v->setEstado($estado);
        } catch (InvalidArgumentException) {
            return false;
        }
        return $this->execute("UPDATE vehiculos SET estado = ? WHERE id = ?", [$estado, $id]);
    }

    public function delete(int $id): bool {
        return $this->execute("DELETE FROM vehiculos WHERE id = ?", [$id]);
    }
}

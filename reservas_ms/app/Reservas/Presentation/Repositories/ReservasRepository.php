<?php
require_once __DIR__ . '/../../../../Core/BaseRepository.php';
require_once __DIR__ . '/../../../../Core/HttpClient.php';
require_once __DIR__ . '/../../Models/Reserva.php';

/**
 * Repositorio de reservas.
 * Extiende BaseRepository y usa HttpClient para comunicación entre microservicios.
 * POO: herencia, composición, encapsulamiento.
 */
class ReservasRepository extends BaseRepository {
    private HttpClient $http;

    private const VEHICULOS_URL = 'http://localhost:8001';
    private const CLIENTES_URL  = 'http://localhost:8002';

    public function __construct() {
        parent::__construct();
        $this->http = new HttpClient();
    }

    private function hydrate(array $row): array {
        return (new Reserva())->fill($row)->toArray();
    }

    public function findAll(): array {
        return array_map([$this, 'hydrate'],
            $this->query("SELECT * FROM reservas ORDER BY id ASC"));
    }

    public function findById(int $id): ?array {
        $row = $this->queryOne("SELECT * FROM reservas WHERE id = ?", [$id]);
        return $row ? $this->hydrate($row) : null;
    }

    public function findByCliente(int $clienteId): array {
        return array_map([$this, 'hydrate'],
            $this->query("SELECT * FROM reservas WHERE cliente_id = ? ORDER BY id ASC", [$clienteId]));
    }

    public function create(Model $model): array|string {
        /** @var Reserva $model */
        // Validar vehículo disponible (comunicación entre MS)
        $vehiculo = $this->http->get(self::VEHICULOS_URL . '/vehiculos/' . $model->vehiculo_id);
        if (!$vehiculo || ($vehiculo['estado'] ?? '') !== 'disponible') {
            return 'El vehículo no está disponible o no existe';
        }

        // Validar que el cliente exista
        $cliente = $this->http->get(self::CLIENTES_URL . '/clientes/' . $model->cliente_id);
        if (!$cliente || isset($cliente['error'])) {
            return 'El cliente no existe';
        }

        // Marcar vehículo como alquilado
        $this->http->patch(self::VEHICULOS_URL . '/vehiculos/' . $model->vehiculo_id . '/estado', ['estado' => 'alquilado']);

        $this->execute(
            "INSERT INTO reservas (cliente_id, vehiculo_id, fecha_inicio, fecha_fin, estado) VALUES (?, ?, ?, ?, ?)",
            [$model->cliente_id, $model->vehiculo_id, $model->fecha_inicio, $model->fecha_fin, $model->estado]
        );
        $model->id = $this->lastId();
        return $model->toArray();
    }

    public function updateEstado(int $id, string $estado): bool {
        $reserva = $this->findById($id);
        if (!$reserva) return false;

        try {
            (new Reserva())->fill($reserva)->setEstado($estado);
        } catch (InvalidArgumentException) {
            return false;
        }

        $ok = $this->execute("UPDATE reservas SET estado = ? WHERE id = ?", [$estado, $id]);

        // Liberar vehículo si la reserva termina
        if ($ok && in_array($estado, ['completada', 'cancelada'])) {
            $this->http->patch(self::VEHICULOS_URL . '/vehiculos/' . $reserva['vehiculo_id'] . '/estado', ['estado' => 'disponible']);
        }
        return $ok;
    }

    public function delete(int $id): bool {
        return $this->execute("DELETE FROM reservas WHERE id = ?", [$id]);
    }
}

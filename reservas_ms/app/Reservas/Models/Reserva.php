<?php
require_once __DIR__ . '/../../../Core/Model.php';

/**
 * Modelo Reserva. Hereda de Model (POO: herencia).
 */
class Reserva extends Model {
    public ?int   $id           = null;
    public int    $cliente_id   = 0;
    public int    $vehiculo_id  = 0;
    public string $fecha_inicio = '';
    public string $fecha_fin    = '';
    public string $estado       = 'activa';

    private const ESTADOS_VALIDOS = ['activa', 'completada', 'cancelada'];

    public function toArray(): array {
        return [
            'id'           => $this->id,
            'cliente_id'   => $this->cliente_id,
            'vehiculo_id'  => $this->vehiculo_id,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin'    => $this->fecha_fin,
            'estado'       => $this->estado,
        ];
    }

    public function setEstado(string $estado): self {
        if (!in_array($estado, self::ESTADOS_VALIDOS)) {
            throw new InvalidArgumentException("Estado inválido: {$estado}");
        }
        $this->estado = $estado;
        return $this;
    }

    public function estaActiva(): bool {
        return $this->estado === 'activa';
    }

    public function duracionDias(): int {
        $ini = new DateTime($this->fecha_inicio);
        $fin = new DateTime($this->fecha_fin);
        return (int)$ini->diff($fin)->days;
    }

    public static function estadosValidos(): array {
        return self::ESTADOS_VALIDOS;
    }
}

<?php
require_once __DIR__ . '/../../../Core/Model.php';

/**
 * Modelo Vehiculo.
 * Hereda de Model (POO: herencia, encapsulamiento).
 */
class Vehiculo extends Model {
    public ?int   $id        = null;
    public string $marca     = '';
    public string $modelo    = '';
    public int    $anio      = 0;
    public string $categoria = '';
    public string $estado    = 'disponible';

    private const ESTADOS_VALIDOS = ['disponible', 'alquilado', 'mantenimiento'];

    public function toArray(): array {
        return [
            'id'        => $this->id,
            'marca'     => $this->marca,
            'modelo'    => $this->modelo,
            'anio'      => $this->anio,
            'categoria' => $this->categoria,
            'estado'    => $this->estado,
        ];
    }

    public function setEstado(string $estado): self {
        if (!in_array($estado, self::ESTADOS_VALIDOS)) {
            throw new InvalidArgumentException("Estado inválido: {$estado}");
        }
        $this->estado = $estado;
        return $this;
    }

    public function isDisponible(): bool {
        return $this->estado === 'disponible';
    }

    public static function estadosValidos(): array {
        return self::ESTADOS_VALIDOS;
    }
}

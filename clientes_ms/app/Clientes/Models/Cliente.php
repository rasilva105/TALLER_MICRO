<?php
require_once __DIR__ . '/../../../Core/Model.php';

/**
 * Modelo Cliente. Hereda de Model (POO: herencia).
 */
class Cliente extends Model {
    public ?int   $id              = null;
    public string $nombre          = '';
    public string $telefono        = '';
    public string $correo          = '';
    public string $numero_licencia = '';

    public function toArray(): array {
        return [
            'id'              => $this->id,
            'nombre'          => $this->nombre,
            'telefono'        => $this->telefono,
            'correo'          => $this->correo,
            'numero_licencia' => $this->numero_licencia,
        ];
    }

    public function getNombreCompleto(): string {
        return trim($this->nombre);
    }

    public function tieneCorreo(): bool {
        return !empty($this->correo) && filter_var($this->correo, FILTER_VALIDATE_EMAIL) !== false;
    }
}

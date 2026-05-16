<?php
/**
 * Clase base abstracta para todos los modelos.
 * Aplica POO: abstracción, encapsulamiento, polimorfismo.
 */
abstract class Model {
    /** Convierte el modelo a array asociativo */
    abstract public function toArray(): array;

    /** Hidrata el modelo desde un array (factory pattern) */
    public function fill(array $data): static {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    /** Convierte el modelo a JSON */
    public function toJson(): string {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}

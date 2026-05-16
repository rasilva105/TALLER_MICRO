<?php
/**
 * Controlador base abstracto.
 * Centraliza respuestas JSON y lectura del body.
 * POO: herencia, encapsulamiento.
 */
abstract class BaseController {
    /** Envía una respuesta JSON */
    protected function json(mixed $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /** Lee y decodifica el body JSON de la petición */
    protected function getBody(): array {
        $raw = file_get_contents('php://input');
        return json_decode($raw, true) ?? [];
    }

    /** Valida que los campos requeridos estén presentes en los datos */
    protected function validate(array $data, array $required): ?string {
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return "El campo '{$field}' es requerido";
            }
        }
        return null;
    }
}

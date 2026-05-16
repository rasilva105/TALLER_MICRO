<?php
/**
 * Interfaz genérica de repositorio.
 * Define el contrato que deben cumplir todos los repositorios (POO: abstracción).
 */
interface Repository {
    public function findAll(): array;
    public function findById(int $id): ?array;
    public function create(Model $model): array;
    public function delete(int $id): bool;
}

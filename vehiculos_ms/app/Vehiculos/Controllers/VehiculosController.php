<?php
require_once __DIR__ . '/../../../Core/BaseController.php';
require_once __DIR__ . '/../Presentation/Repositories/VehiculosRepository.php';
require_once __DIR__ . '/../Presentation/Repositories/TestRepository.php';
require_once __DIR__ . '/../Models/Vehiculo.php';

/**
 * Controlador de vehículos.
 * Extiende BaseController (POO: herencia, encapsulamiento).
 */
class VehiculosController extends BaseController {
    private VehiculosRepository $repo;

    public function __construct() {
        $this->repo = new VehiculosRepository();
    }

    public function index(): void {
        $this->json($this->repo->findAll());
    }

    public function disponibles(): void {
        $this->json($this->repo->findByEstado('disponible'));
    }

    public function show(int $id): void {
        $v = $this->repo->findById($id);
        $v ? $this->json($v) : $this->json(['error' => 'Vehículo no encontrado'], 404);
    }

    public function store(): void {
        $data  = $this->getBody();
        $error = $this->validate($data, ['marca', 'modelo', 'anio']);
        if ($error) { $this->json(['error' => $error], 400); return; }
        $v = (new Vehiculo())->fill($data);
        $this->json($this->repo->create($v), 201);
    }

    public function updateEstado(int $id): void {
        $data = $this->getBody();
        if (!$this->repo->updateEstado($id, $data['estado'] ?? '')) {
            $this->json(['error' => 'Estado inválido o vehículo no encontrado'], 400);
            return;
        }
        $this->json(['message' => 'Estado actualizado', 'estado' => $data['estado']]);
    }

    public function destroy(int $id): void {
        $this->repo->delete($id)
            ? $this->json(['message' => 'Vehículo eliminado'])
            : $this->json(['error' => 'Vehículo no encontrado'], 404);
    }

    public function test(): void {
        $this->json((new TestRepository())->ping());
    }
}

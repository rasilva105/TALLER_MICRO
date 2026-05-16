<?php
require_once __DIR__ . '/../../../Core/BaseController.php';
require_once __DIR__ . '/../Presentation/Repositories/ReservasRepository.php';
require_once __DIR__ . '/../Presentation/Repositories/TestRepository.php';
require_once __DIR__ . '/../Models/Reserva.php';

/**
 * Controlador de reservas. Extiende BaseController (POO: herencia).
 */
class ReservasController extends BaseController {
    private ReservasRepository $repo;

    public function __construct() {
        $this->repo = new ReservasRepository();
    }

    public function index(): void {
        $this->json($this->repo->findAll());
    }

    public function show(int $id): void {
        $r = $this->repo->findById($id);
        $r ? $this->json($r) : $this->json(['error' => 'Reserva no encontrada'], 404);
    }

    public function byCliente(int $clienteId): void {
        $this->json($this->repo->findByCliente($clienteId));
    }

    public function store(): void {
        $data  = $this->getBody();
        $error = $this->validate($data, ['cliente_id', 'vehiculo_id', 'fecha_inicio', 'fecha_fin']);
        if ($error) { $this->json(['error' => $error], 400); return; }

        $reserva = (new Reserva())->fill($data);
        $result  = $this->repo->create($reserva);
        is_string($result)
            ? $this->json(['error' => $result], 422)
            : $this->json($result, 201);
    }

    public function updateEstado(int $id): void {
        $data = $this->getBody();
        $this->repo->updateEstado($id, $data['estado'] ?? '')
            ? $this->json(['message' => 'Estado actualizado', 'estado' => $data['estado']])
            : $this->json(['error' => 'Reserva no encontrada o estado inválido'], 400);
    }

    public function destroy(int $id): void {
        $this->repo->delete($id)
            ? $this->json(['message' => 'Reserva eliminada'])
            : $this->json(['error' => 'Reserva no encontrada'], 404);
    }

    public function test(): void {
        $this->json((new TestRepository())->ping());
    }
}

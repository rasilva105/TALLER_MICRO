<?php
require_once __DIR__ . '/../../../Core/BaseController.php';
require_once __DIR__ . '/../Presentation/Repositories/ClientesRepository.php';
require_once __DIR__ . '/../Presentation/Repositories/TestRepository.php';
require_once __DIR__ . '/../Models/Cliente.php';

/**
 * Controlador de clientes. Extiende BaseController (POO: herencia).
 */
class ClientesController extends BaseController {
    private ClientesRepository $repo;

    public function __construct() {
        $this->repo = new ClientesRepository();
    }

    public function index(): void {
        $this->json($this->repo->findAll());
    }

    public function show(int $id): void {
        $c = $this->repo->findById($id);
        $c ? $this->json($c) : $this->json(['error' => 'Cliente no encontrado'], 404);
    }

    public function store(): void {
        $data  = $this->getBody();
        $error = $this->validate($data, ['nombre']);
        if ($error) { $this->json(['error' => $error], 400); return; }
        $this->json($this->repo->create((new Cliente())->fill($data)), 201);
    }

    public function update(int $id): void {
        $updated = $this->repo->update($id, $this->getBody());
        $updated ? $this->json($updated) : $this->json(['error' => 'Cliente no encontrado'], 404);
    }

    public function destroy(int $id): void {
        $this->repo->delete($id)
            ? $this->json(['message' => 'Cliente eliminado'])
            : $this->json(['error' => 'Cliente no encontrado'], 404);
    }

    public function test(): void {
        $this->json((new TestRepository())->ping());
    }
}

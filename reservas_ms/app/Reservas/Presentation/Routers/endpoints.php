<?php
require_once __DIR__ . '/../../Controllers/ReservasController.php';

$controller = new ReservasController();
$method     = $_SERVER['REQUEST_METHOD'];
$uri        = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments   = explode('/', trim($uri, '/'));

if ($segments[0] === 'test') { $controller->test(); return; }

if ($segments[0] !== 'reservas') {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
    return;
}

$id      = isset($segments[1]) && is_numeric($segments[1]) ? (int)$segments[1] : null;
$subpath = $segments[2] ?? null;

// GET /reservas/cliente/{id}
if ($method === 'GET' && ($segments[1] ?? '') === 'cliente' && isset($segments[2])) {
    $controller->byCliente((int)$segments[2]);
    return;
}

match(true) {
    $method === 'GET'    && $id === null => $controller->index(),
    $method === 'GET'    && $id !== null => $controller->show($id),
    $method === 'POST'   && $id === null => $controller->store(),
    $method === 'PATCH'  && $id !== null && $subpath === 'estado' => $controller->updateEstado($id),
    $method === 'DELETE' && $id !== null => $controller->destroy($id),
    default => (function() {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    })(),
};

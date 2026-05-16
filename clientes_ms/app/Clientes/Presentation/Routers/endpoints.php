<?php
require_once __DIR__ . '/../../Controllers/ClientesController.php';

$controller = new ClientesController();
$method     = $_SERVER['REQUEST_METHOD'];
$uri        = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments   = explode('/', trim($uri, '/'));

if ($segments[0] === 'test') { $controller->test(); return; }

if ($segments[0] !== 'clientes') {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
    return;
}

$id = isset($segments[1]) && is_numeric($segments[1]) ? (int)$segments[1] : null;

match(true) {
    $method === 'GET'    && $id === null => $controller->index(),
    $method === 'GET'    && $id !== null => $controller->show($id),
    $method === 'POST'   && $id === null => $controller->store(),
    $method === 'PUT'    && $id !== null => $controller->update($id),
    $method === 'DELETE' && $id !== null => $controller->destroy($id),
    default => (function() {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    })(),
};

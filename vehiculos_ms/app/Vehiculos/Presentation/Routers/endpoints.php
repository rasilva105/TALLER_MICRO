<?php
require_once __DIR__ . '/../../Controllers/VehiculosController.php';

$controller = new VehiculosController();
$method     = $_SERVER['REQUEST_METHOD'];
$uri        = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri        = rtrim($uri, '/');
$segments   = explode('/', trim($uri, '/'));

// Routes: /vehiculos | /vehiculos/{id} | /vehiculos/{id}/estado | /vehiculos/disponibles | /test
if ($segments[0] === 'test') {
    $controller->test();
    return;
}

if ($segments[0] !== 'vehiculos') {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
    return;
}

$id      = isset($segments[1]) && is_numeric($segments[1]) ? (int)$segments[1] : null;
$subpath = $segments[2] ?? null;

match(true) {
    $method === 'GET'    && $id === null && ($segments[1] ?? '') === 'disponibles' => $controller->disponibles(),
    $method === 'GET'    && $id === null  => $controller->index(),
    $method === 'GET'    && $id !== null  => $controller->show($id),
    $method === 'POST'   && $id === null  => $controller->store(),
    $method === 'PATCH'  && $id !== null && $subpath === 'estado' => $controller->updateEstado($id),
    $method === 'DELETE' && $id !== null  => $controller->destroy($id),
    default => (function() {
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
    })(),
};

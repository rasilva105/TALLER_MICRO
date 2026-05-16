<?php
require_once __DIR__ . '/../app/Middlewares/CorsMiddleware.php';
CorsMiddleware::handle();

// Si la petición viene al raíz sin path de API, servir el frontend
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

if ($uri === '' || $uri === 'frontend') {
    // Redirigir al frontend
    header('Location: /frontend/');
    exit;
}

require_once __DIR__ . '/../app/Vehiculos/Presentation/Routers/endpoints.php';

<?php
require_once __DIR__ . '/../app/Middlewares/CorsMiddleware.php';
CorsMiddleware::handle();
require_once __DIR__ . '/../app/Clientes/Presentation/Routers/endpoints.php';

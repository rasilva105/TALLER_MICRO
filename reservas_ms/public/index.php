<?php
require_once __DIR__ . '/../app/Middlewares/CorsMiddleware.php';
CorsMiddleware::handle();
require_once __DIR__ . '/../app/Reservas/Presentation/Routers/endpoints.php';

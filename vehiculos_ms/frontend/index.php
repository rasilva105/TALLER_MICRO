<?php
$icon   = '🚗';
$title  = 'Servicio de Vehículos';
$badge  = 'vehiculos_ms · :8001';
$scripts = ['assets/js/app.js', 'assets/js/views.js'];
$nav_links = [
  ['icon' => '📋', 'label' => 'Listar vehículos', 'view' => 'list'],
  ['icon' => '➕', 'label' => 'Nuevo vehículo',   'view' => 'create'],
];
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/layouts/sidebar.php';
require_once __DIR__ . '/layouts/footer.php';

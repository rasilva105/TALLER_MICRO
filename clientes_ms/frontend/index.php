<?php
$icon   = '👤';
$title  = 'Servicio de Clientes';
$badge  = 'clientes_ms · :8002';
$scripts = ['assets/js/app.js', 'assets/js/views.js'];
$nav_links = [
  ['icon' => '📋', 'label' => 'Listar clientes', 'view' => 'list'],
  ['icon' => '➕', 'label' => 'Nuevo cliente',   'view' => 'create'],
];
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/layouts/sidebar.php';
require_once __DIR__ . '/layouts/footer.php';

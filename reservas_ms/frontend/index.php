<?php
$icon   = '📋';
$title  = 'Servicio de Reservas';
$badge  = 'reservas_ms · :8003';
$scripts = ['assets/js/app.js', 'assets/js/views.js'];
$nav_links = [
  ['icon' => '📋', 'label' => 'Listar reservas', 'view' => 'list'],
  ['icon' => '➕', 'label' => 'Nueva reserva',   'view' => 'create'],
];
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/layouts/sidebar.php';
require_once __DIR__ . '/layouts/footer.php';

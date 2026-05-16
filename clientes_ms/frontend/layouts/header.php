<?php
/**
 * Layout: Cabecera del microservicio.
 * Recibe: $icon, $title, $badge
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($title ?? 'Microservicio') ?></title>
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="l-header">
  <div class="l-header__icon"><?= $icon ?? '🔷' ?></div>
  <span class="l-header__title"><?= htmlspecialchars($title ?? '') ?></span>
  <span class="l-header__badge"><?= htmlspecialchars($badge ?? 'MS') ?></span>
</header>

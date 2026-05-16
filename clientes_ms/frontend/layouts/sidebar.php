<?php
/**
 * Layout: Barra lateral de navegación.
 * Recibe: $nav_links = [['icon'=>'🚗','label'=>'Vehículos','view'=>'list'], ...]
 */
?>
<div class="l-wrapper">
<nav class="l-sidebar">
  <div class="l-nav__label">Menú</div>
  <?php foreach ($nav_links ?? [] as $link): ?>
    <a href="#" class="l-nav__link" data-view="<?= htmlspecialchars($link['view']) ?>">
      <span class="icon"><?= $link['icon'] ?></span>
      <?= htmlspecialchars($link['label']) ?>
    </a>
  <?php endforeach; ?>
</nav>
<main class="l-main" id="main-content">
  <!-- Las vistas se inyectan aquí vía JS -->
</main>
</div>

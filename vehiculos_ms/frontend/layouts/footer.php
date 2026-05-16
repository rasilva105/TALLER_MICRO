<?php
/**
 * Layout: Pie de página con scripts.
 * Recibe: $scripts = ['assets/js/app.js', 'assets/js/views.js']
 */
?>
<?php foreach ($scripts ?? [] as $src): ?>
  <script src="/<?= htmlspecialchars($src) ?>"></script>
<?php endforeach; ?>
</body>
</html>

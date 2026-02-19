<h1 class="mb-3"><?= e(field($category, 'name')) ?></h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
  <?php foreach ($products as $p): ?>
    <?php $p = $p; include __DIR__ . '/../components/productCard.php'; ?>
  <?php endforeach; ?>
</div>

<?php if (count($products) === 0): ?>
  <p class="text-muted mt-3">Geen producten gevonden.</p>
<?php endif; ?>

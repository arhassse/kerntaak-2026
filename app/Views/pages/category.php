<h1 class="mb-3"><?= e(field($category, 'name')) ?></h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
  <?php foreach ($products as $p): ?>
    <div class="col">
      <?php include __DIR__ . '/../components/productCard.php'; ?>
    </div>
  <?php endforeach; ?>
</div>

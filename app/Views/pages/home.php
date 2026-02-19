<?php /** @var array $categories */ ?>
<h1 class="mb-3"><?= e(t('newest')) ?></h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-4">
  <?php foreach ($latest as $p): ?>
    <?php $p = $p; include __DIR__ . '/../components/productCard.php'; ?>
  <?php endforeach; ?>
</div>

<?php /** @var array $categories */ ?>

<div class="card p-4 mb-4">
  <div class="row align-items-center g-3">
    <div class="col-md-8">
      <div class="text-muted small mb-1">Warm • Minimal • Modesty</div>
      <h1 class="mb-2 section-title"> Tijdloze modest fashion</h1>
      <div class="text-muted mb-3">
        Ontdek abaya's, hijabs en sets in zachte beige en warme bruine kleuren.
      </div>
      <a class="btn btn-primary" href="<?= e(base_path()) ?>/category/abaya">Shop Abaya's</a>
      <a class="btn btn-outline-primary ms-2" href="<?= e(base_path()) ?>/about">Over ons</a>
    </div>
    <div class="col-md-4 text-md-end">
      <span class="badge badge-earth p-2">Nieuwe collectie</span>
    </div>
  </div>
</div>

<h2 class="mb-3 section-title">Uitgelicht per categorie</h2>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 mb-5">
  <?php foreach ($featured as $item): ?>
    <?php $cat = $item['category']; $p = $item['product']; ?>
    <div class="col">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="fw-semibold"><?= e(field($cat, 'name')) ?></div>
        <a class="small" href="<?= e(base_path()) ?>/category/<?= e($cat['slug']) ?>">Bekijk</a>
      </div>
      <?php include __DIR__ . '/../components/productCard.php'; ?>
    </div>
  <?php endforeach; ?>
</div>

<h2 class="mb-3 section-title"><?= e(t('newest')) ?></h2>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-4">
  <?php foreach ($latest as $p): ?>
    <div class="col">
      <?php include __DIR__ . '/../components/productCard.php'; ?>
    </div>
  <?php endforeach; ?>
</div>

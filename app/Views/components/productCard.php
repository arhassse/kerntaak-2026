<?php /** @var array $p */ ?>
<div class="col">
  <div class="card h-100">
    <img class="card-img-top" style="object-fit:cover; height:220px;"
         src="<?= e(base_path()) ?>/<?= e($p['image_path'] ?? 'assets/img/placeholder.jpg') ?>"
         alt="<?= e(field($p, 'name')) ?>">
    <div class="card-body">
      <h5 class="card-title"><?= e(field($p, 'name')) ?></h5>
      <p class="mb-2"><b>€ <?= e(number_format((float)$p['price'], 2, ',', '.')) ?></b></p>
      <a class="btn btn-sm btn-primary" href="<?= e(base_path()) ?>/product/<?= e((string)$p['id']) ?>">
        <?= e(t('view')) ?>
      </a>
    </div>
  </div>
</div>

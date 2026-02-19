<?php /** @var array $categories */ ?>
<!doctype html>
<html lang="<?= e(lang()) ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e(t('brand')) ?></title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= e(base_path()) ?>/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light border-bottom">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= e(base_path()) ?>/"><?= e(t('brand')) ?></a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">
      <!-- Categorieën -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php foreach (($categories ?? []) as $c): ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= e(base_path()) ?>/category/<?= e($c['slug']) ?>">
              <?= e(field($c, 'name')) ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- Rechts (cart, taal, login/logout) -->
      <div class="d-flex align-items-center gap-2">
        <a class="btn btn-outline-primary btn-sm" href="<?= e(base_path()) ?>/cart">
          Cart (<?= \App\Services\CartService::count(); ?>)
        </a>

        <a class="btn btn-outline-secondary btn-sm" href="<?= e(base_path()) ?>/lang/nl">NL</a>
        <a class="btn btn-outline-secondary btn-sm" href="<?= e(base_path()) ?>/lang/en">EN</a>

        <?php if (!empty($_SESSION['user'])): ?>
          <span class="small text-muted ms-2">👤 <?= e($_SESSION['user']['email']) ?></span>
          <a class="btn btn-outline-danger btn-sm" href="<?= e(base_path()) ?>/logout">Logout</a>
        <?php else: ?>
          <a class="btn btn-outline-primary btn-sm" href="<?= e(base_path()) ?>/login">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<main class="container py-4">

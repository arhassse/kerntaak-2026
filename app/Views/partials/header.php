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
<body data-welcome-discount="<?= !empty($_SESSION['welcome_discount']) ? '1' : '0' ?>">

<nav class="navbar border-bottom">
  <div class="container d-flex align-items-center justify-content-between">

    <!-- Left: Hamburger -->
    <button class="btn btn-outline-secondary btn-sm" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#mainMenu" aria-controls="mainMenu">
      ☰
    </button>

    <!-- Center brand -->
    <a class="navbar-brand mx-auto fw-bold brand-center" href="<?= e(base_path()) ?>/">
      Saarr's Modesty
    </a>

    <!-- Right: Cart + language -->
    <div class="d-flex align-items-center gap-2">
      <a class="btn btn-outline-primary btn-sm" href="<?= e(base_path()) ?>/cart">
        Cart (<?= \App\Services\CartService::count(); ?>)
      </a>
      <a class="btn btn-outline-secondary btn-sm" href="<?= e(base_path()) ?>/lang/nl">NL</a>
      <a class="btn btn-outline-secondary btn-sm" href="<?= e(base_path()) ?>/lang/en">EN</a>
    </div>
  </div>
</nav>

<!-- Offcanvas menu -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mainMenu" aria-labelledby="mainMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="mainMenuLabel">Menu</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">
    <div class="mb-3">
      <div class="fw-semibold mb-2">Producten</div>
      <div class="list-group">
        <?php foreach (($categories ?? []) as $c): ?>
          <a class="list-group-item list-group-item-action"
             href="<?= e(base_path()) ?>/category/<?= e($c['slug']) ?>"
             data-bs-dismiss="offcanvas">
            <?= e(field($c, 'name')) ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="mb-3">
      <div class="fw-semibold mb-2">Pagina's</div>
      <div class="list-group">
        <a class="list-group-item list-group-item-action" href="<?= e(base_path()) ?>/about" data-bs-dismiss="offcanvas">Over ons</a>
        <a class="list-group-item list-group-item-action" href="<?= e(base_path()) ?>/reviews" data-bs-dismiss="offcanvas">Reviews</a>
        <a class="list-group-item list-group-item-action" href="<?= e(base_path()) ?>/contact" data-bs-dismiss="offcanvas">Contact</a>
      </div>
    </div>

    <div class="mb-3">
      <div class="fw-semibold mb-2">Account</div>
      <div class="list-group">
        <?php if (!empty($_SESSION['user'])): ?>
          <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
            <a class="list-group-item list-group-item-action" href="<?= e(base_path()) ?>/admin" data-bs-dismiss="offcanvas">Admin</a>
          <?php endif; ?>
          <a class="list-group-item list-group-item-action text-danger" href="<?= e(base_path()) ?>/logout" data-bs-dismiss="offcanvas">Logout</a>
        <?php else: ?>
          <a class="list-group-item list-group-item-action" href="<?= e(base_path()) ?>/login" data-bs-dismiss="offcanvas">Login</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="small text-muted">
      Aardse tinten • Modesty • Minimal
    </div>
  </div>
</div>

<main class="container py-4">

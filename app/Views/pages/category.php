<form method="GET" action="<?= e(base_path()) ?>/search" class="mb-3">
  <input 
    type="text" 
    name="search" 
    value="<?= e($_GET['search'] ?? '') ?>" 
    placeholder="Zoek producten..." 
    class="form-control"
  >
</form>

<form method="GET" class="mb-3">
  <select name="sort" class="form-select" onchange="this.form.submit()">
    <option value="newest" <?= ($_GET['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Nieuwste</option>
    <option value="price_low" <?= ($_GET['sort'] ?? '') === 'price_low' ? 'selected' : '' ?>>Prijs laag → hoog</option>
    <option value="price_high" <?= ($_GET['sort'] ?? '') === 'price_high' ? 'selected' : '' ?>>Prijs hoog → laag</option>
  </select>
</form>

<h1 class="mb-3"><?= e(field($category, 'name')) ?></h1>

<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">

  <?php foreach ($products as $p): ?>
    <div class="col">
      <?php include __DIR__ . '/../components/productCard.php'; ?>
    </div>
  <?php endforeach; ?>
</div>

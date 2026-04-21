<a href="<?= e(base_path()) ?>/admin/create" class="btn btn-success mb-3">
  ➕ Product toevoegen
</a>

<h1 class="mb-3">Admin Dashboard</h1>

<?php if ($msg = flash('success')): ?>
  <div class="alert alert-success"><?= e($msg) ?></div>
<?php endif; ?>

<div class="table-responsive">
  <table class="table table-striped align-middle">
    <thead>
      <tr>
        <th>Product</th>
        <th>Variant</th>
        <th>Voorraad</th>
        <th>Actie</th>
      </tr>
    </thead>
    <tbody>

      <?php foreach ($rows as $r): ?>
        <tr>
          <td>
            <?= e($r['name_nl']) ?> / <span class="text-muted"><?= e($r['name_en']) ?></span>
            <div class="small text-muted">Product #<?= (int)$r['product_id'] ?></div>
          </td>
          <td><?= e($r['size']) ?> / <?= e($r['color']) ?></td>
          <td><b><?= (int)$r['stock'] ?></b></td>
<td style="width:320px;">
  <div class="d-flex gap-2">

    <!-- voorraad aanpassen -->
    <form method="post" action="<?= e(base_path()) ?>/admin/stock" class="d-flex gap-2">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <input type="hidden" name="variant_id" value="<?= (int)$r['variant_id'] ?>">
      <input class="form-control" type="number" min="0" name="stock" value="<?= (int)$r['stock'] ?>">
      <button class="btn btn-primary">Opslaan</button>
    </form>

    <!-- ❌ verwijderen -->
    <a href="<?= e(base_path()) ?>/admin/delete/<?= (int)$r['product_id'] ?>"
       class="btn btn-danger"
       onclick="return confirm('Weet je het zeker?')">
       Verwijder
    </a>

  </div>
</td>

          
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

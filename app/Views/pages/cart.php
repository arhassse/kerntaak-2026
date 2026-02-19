<h1 class="mb-3">Winkelwagen</h1>

<?php if ($msg = flash('success')): ?>
  <div class="alert alert-success"><?= e($msg) ?></div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
  <div class="alert alert-danger"><?= e($msg) ?></div>
<?php endif; ?>

<?php if (count($items) === 0): ?>
  <p class="text-muted">Je winkelwagen is leeg.</p>
  <a class="btn btn-primary" href="<?= e(base_path()) ?>/">Verder winkelen</a>
<?php else: ?>
<form method="post" action="<?= e(base_path()) ?>/cart/update">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

  <div class="table-responsive">
    <table class="table align-middle">
      <thead>
        <tr>
          <th>Product</th>
          <th>Variant</th>
          <th>Prijs</th>
          <th>Aantal</th>
          <th>Subtotaal</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($items as $it): ?>
        <tr>
          <td><?= e($it['product_name']) ?></td>
          <td><?= e($it['size']) ?> / <?= e($it['color']) ?></td>
          <td>€ <?= e(number_format($it['price'], 2, ',', '.')) ?></td>
          <td style="max-width:120px;">
            <input class="form-control" type="number" min="1" max="<?= (int)$it['stock'] ?>"
                   name="qty[<?= (int)$it['variant_id'] ?>]"
                   value="<?= (int)$it['qty'] ?>">
          </td>
          <td>€ <?= e(number_format($it['line_total'], 2, ',', '.')) ?></td>
          <td>
            <a class="btn btn-sm btn-outline-danger"
               href="<?= e(base_path()) ?>/cart/remove/<?= (int)$it['variant_id'] ?>">Verwijderen</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="d-flex justify-content-between">
    <button class="btn btn-outline-secondary">Update</button>
    <div class="text-end">
      <div class="fs-5"><b>Totaal: € <?= e(number_format($subtotal, 2, ',', '.')) ?></b></div>
      <a class="btn btn-primary mt-2" href="<?= e(base_path()) ?>/checkout">Afrekenen</a>
    </div>
  </div>
</form>
<?php endif; ?>

<h1 class="mb-3">Winkelwagen</h1>

<?php if ($msg = flash('success')): ?>
  <div class="alert alert-success" data-autohide="1"><?= e($msg) ?></div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
  <div class="alert alert-danger" data-autohide="1"><?= e($msg) ?></div>
<?php endif; ?>

<?php if (count($items) === 0): ?>
  <p class="text-muted">Je winkelwagen is leeg.</p>
  <a class="btn btn-primary" href="<?= e(base_path()) ?>/">Verder winkelen</a>
<?php else: ?>

<div class="row g-4">
  <div class="col-lg-8">
    <form method="post" action="<?= e(base_path()) ?>/cart/update">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>Product</th>
              <th>Variant</th>
              <th>Prijs</th>
              <th style="width:120px;">Aantal</th>
              <th>Totaal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($items as $it): ?>
              <tr>
                <td>
                  <div class="d-flex gap-3 align-items-center">
                    <img src="<?= e(base_path()) ?>/<?= e($it['image_path'] ?? 'assets/img/placeholder.jpg') ?>"
                         alt="<?= e($it['product_name']) ?>"
                         style="width:64px; height:80px; object-fit:cover; border-radius:10px; border:1px solid rgba(0,0,0,.06);">
                    <div>
                      <div class="fw-semibold"><?= e($it['product_name']) ?></div>
                      <div class="small text-muted">Variant #<?= (int)$it['variant_id'] ?></div>
                    </div>
                  </div>
                </td>
                <td><?= e($it['size']) ?> / <?= e($it['color']) ?></td>
                <td>€ <?= e(number_format((float)$it['price'], 2, ',', '.')) ?></td>
                <td>
                  <input type="number"
                         class="form-control"
                         name="qty[<?= (int)$it['variant_id'] ?>]"
                         value="<?= (int)$it['qty'] ?>"
                         min="1">
                </td>
                <td>€ <?= e(number_format((float)$it['line_total'], 2, ',', '.')) ?></td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-danger"
                     data-confirm="remove"
                     href="<?= e(base_path()) ?>/cart/remove/<?= (int)$it['variant_id'] ?>">
                    Verwijder
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <button class="btn btn-outline-secondary">Update</button>
    </form>
  </div>

  <div class="col-lg-4">
    <div class="card p-3">
      <h5 class="mb-3">Samenvatting</h5>

      <div class="d-flex justify-content-between mb-1">
        <span>Subtotaal</span>
        <span>€ <?= e(number_format((float)$subtotal, 2, ',', '.')) ?></span>
      </div>

      <?php if ($discountAmount > 0): ?>
        <div class="d-flex justify-content-between mb-1">
          <span>Korting (<?= e($discountCode ?? '') ?>)</span>
          <span>- € <?= e(number_format((float)$discountAmount, 2, ',', '.')) ?></span>
        </div>
      <?php endif; ?>

      <div class="d-flex justify-content-between fs-5 fw-bold mt-2">
        <span>Totaal</span>
        <span>€ <?= e(number_format((float)$total, 2, ',', '.')) ?></span>
      </div>

      <hr>

      <form method="post" action="<?= e(base_path()) ?>/cart/discount" class="d-flex gap-2">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <input class="form-control" name="code" placeholder="Kortingscode" value="<?= e($discountCode ?? '') ?>">
        <button class="btn btn-primary">Toepassen</button>
      </form>
      <div class="small text-muted mt-2">Tip: gebruik <b>WELCOME10</b> (10%).</div>

      <a class="btn btn-primary w-100 mt-3" href="<?= e(base_path()) ?>/checkout">Afrekenen</a>
      <a class="btn btn-outline-primary w-100 mt-2" href="<?= e(base_path()) ?>/">Verder winkelen</a>
    </div>
  </div>
</div>

<?php endif; ?>

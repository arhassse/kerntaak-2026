<h1 class="mb-3"><?= e(field($product, 'name')) ?></h1>

<div class="row g-4">
  <div class="col-md-5">
    <img class="img-fluid rounded border" style="width:100%; aspect-ratio:4/5; object-fit:cover;"
         src="<?= e(base_path()) ?>/<?= e($product['image_path'] ?? 'assets/img/placeholder.jpg') ?>"
         alt="<?= e(field($product,'name')) ?>">
  </div>

  <div class="col-md-7">
    <p><?= e(field($product, 'description')) ?></p>
    <p class="fs-4"><b>€ <?= e(number_format((float)$product['price'], 2, ',', '.')) ?></b></p>

    <?php if ($msg = flash('success')): ?>
      <div class="alert alert-success"><?= e($msg) ?></div>
    <?php endif; ?>
    <?php if ($msg = flash('error')): ?>
      <div class="alert alert-danger"><?= e($msg) ?></div>
    <?php endif; ?>

    <div class="card p-3">
      <div class="mb-2 fw-semibold"><?= e(t('choose_variant')) ?></div>

      <form method="post" action="<?= e(base_path()) ?>/cart/add">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

        <div class="mb-2">
          <label class="form-label">Variant</label>
          <select class="form-select" name="variant_id" required>
            <option value="">-- kies maat/kleur --</option>
            <?php foreach ($variants as $v): ?>
              <option value="<?= (int)$v['id'] ?>" <?= ((int)$v['stock'] <= 0) ? 'disabled' : '' ?>>
                <?= e($v['size']) ?> / <?= e($v['color']) ?>
                <?= ((int)$v['stock'] > 0) ? ('(' . (int)$v['stock'] . ')') : '(uitverkocht)' ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-2">
          <label class="form-label">Aantal</label>
          <input class="form-control" type="number" name="qty" value="1" min="1">
        </div>

        <button class="btn btn-primary mt-2"><?= e(t('add_to_cart')) ?></button>
      </form>
    </div>

    <hr>
    <h5>Varianten</h5>
    <ul class="mb-0">
      <?php foreach ($variants as $v): ?>
        <li>
          <?= e($v['size']) ?> / <?= e($v['color']) ?> —
          <?= ((int)$v['stock'] > 0) ? e(t('in_stock')) : e(t('out_of_stock')) ?>
          (<?= (int)$v['stock'] ?>)
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

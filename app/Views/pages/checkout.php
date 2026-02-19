<h1 class="mb-3">Checkout</h1>

<?php if ($msg = flash('error')): ?>
  <div class="alert alert-danger" data-autohide="1"><?= e($msg) ?></div>
<?php endif; ?>

<div class="row g-4">
  <div class="col-lg-7">
    <div class="card p-4">
      <h5 class="mb-3">Jouw gegevens</h5>

      <form method="post" action="<?= e(base_path()) ?>/checkout">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Naam</label>
            <input class="form-control" name="customer_name" value="<?= e($old['customer_name'] ?? '') ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">E-mail</label>
            <input class="form-control" name="email" value="<?= e($old['email'] ?? '') ?>" required>
          </div>
          <div class="col-md-8">
            <label class="form-label">Adres</label>
            <input class="form-control" name="address" value="<?= e($old['address'] ?? '') ?>" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Postcode</label>
            <input class="form-control" name="postal_code" value="<?= e($old['postal_code'] ?? '') ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Stad</label>
            <input class="form-control" name="city" value="<?= e($old['city'] ?? '') ?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Land</label>
            <input class="form-control" name="country" value="<?= e($old['country'] ?? '') ?>" required>
          </div>
        </div>

        <button class="btn btn-primary mt-3">Bestelling plaatsen</button>
      </form>
    </div>
  </div>

  <div class="col-lg-5">
    <div class="card p-4">
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

      <div class="small text-muted">
        <b>Demo betaling</b>: orderstatus wordt opgeslagen als <code>Paid_demo</code>.
      </div>
    </div>
  </div>
</div>

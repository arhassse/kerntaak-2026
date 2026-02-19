<h1 class="mb-3">Checkout</h1>

<?php if ($msg = flash('error')): ?>
  <div class="alert alert-danger"><?= e($msg) ?></div>
<?php endif; ?>

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

  <div class="mt-3 p-3 border rounded">
    <div><b>Demo betaling</b>: orderstatus wordt opgeslagen als <code>Paid_demo</code>.</div>
    <div class="mt-2 fs-5"><b>Totaal: € <?= e(number_format($subtotal, 2, ',', '.')) ?></b></div>
  </div>

  <button class="btn btn-primary mt-3">Bestelling plaatsen</button>
</form>

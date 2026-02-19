<h1 class="mb-3">Login</h1>

<?php if ($msg = flash('error')): ?>
  <div class="alert alert-danger"><?= e($msg) ?></div>
<?php endif; ?>

<form method="post" action="<?= e(base_path()) ?>/login">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

  <div class="mb-3">
    <label class="form-label">E-mail</label>
    <input class="form-control" name="email" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Wachtwoord</label>
    <input class="form-control" type="password" name="password" required>
  </div>

  <button class="btn btn-primary">Inloggen</button>
</form>

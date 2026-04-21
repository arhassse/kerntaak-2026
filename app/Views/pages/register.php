<h1>Registreren</h1>

<?php if ($msg = flash('error')): ?>
  <div class="alert alert-danger"><?= e($msg) ?></div>
<?php endif; ?>

<form method="POST" action="<?= e(base_path()) ?>/register">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

  <div class="mb-2">
    <label>Naam</label>
    <input class="form-control" name="name" required>
  </div>

  <div class="mb-2">
    <label>Email</label>
    <input class="form-control" type="email" name="email" required>
  </div>

  <div class="mb-2">
    <label>Wachtwoord</label>
    <input class="form-control" type="password" name="password" required>
  </div>

  <button class="btn btn-primary mt-2">Registreren</button>
</form>
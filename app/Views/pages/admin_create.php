<h1>Product toevoegen</h1>

<form method="POST" action="<?= e(base_path()) ?>/admin/create">
  <div class="mb-2">
    <label>Naam</label>
    <input class="form-control" name="name" required>
  </div>

  <div class="mb-2">
    <label>Prijs</label>
    <input class="form-control" type="number" step="0.01" name="price" required>
  </div>

  <button class="btn btn-primary mt-2">Opslaan</button>
</form>
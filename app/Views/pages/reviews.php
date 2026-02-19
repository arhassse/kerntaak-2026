<h1 class="mb-3">Reviews</h1>
<?php $reviews = $reviews ?? []; ?>
<?php if ($msg = flash('success')): ?>
  <div class="alert alert-success"><?= e($msg) ?></div>
<?php endif; ?>
<?php if ($msg = flash('error')): ?>
  <div class="alert alert-danger"><?= e($msg) ?></div>
<?php endif; ?>

<div class="row g-4">
  <div class="col-lg-5">
    <div class="card saarr-soft p-3">
      <h5 class="mb-3">Plaats een review</h5>
      
<form method="post" action="<?= e(base_path()) ?>/reviews">
  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

        <div class="mb-2">
          <label class="form-label">Naam</label>
          <input class="form-control" name="name" required>
        </div>

        <div class="mb-2">
          <label class="form-label">Sterren</label>
          <select class="form-select" name="rating" required>
            <option value="5">★★★★★ (5)</option>
            <option value="4">★★★★☆ (4)</option>
            <option value="3">★★★☆☆ (3)</option>
            <option value="2">★★☆☆☆ (2)</option>
            <option value="1">★☆☆☆☆ (1)</option>
          </select>
        </div>

        <div class="mb-2">
          <label class="form-label">Review</label>
          <textarea class="form-control" name="message" rows="4" required></textarea>
        </div>

        <button class="btn btn-primary mt-2">Versturen</button>
      </form>
    </div>
  </div>

  <div class="col-lg-7">
    <?php if (count($reviews) === 0): ?>
      <p class="text-muted">Nog geen reviews.</p>
    <?php else: ?>
      <div class="d-grid gap-3">
        <?php foreach ($reviews as $r): ?>
          <div class="card p-3">
            <div class="d-flex justify-content-between">
              <b><?= e($r['name']) ?></b>
              <span>
                <?= str_repeat('★', (int)$r['rating']) . str_repeat('☆', 5 - (int)$r['rating']) ?>
              </span>
            </div>
            <div class="text-muted small"><?= e($r['created_at']) ?></div>
            <div class="mt-2"><?= e($r['message']) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
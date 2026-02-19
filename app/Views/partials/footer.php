</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(base_path()) ?>/assets/js/app.js"></script>
</body>
</html>

<footer class="footer py-5 mt-4">
  <div class="container">
    <div class="row g-4 align-items-start">
      <div class="col-md-6">
        <div class="fw-bold mb-2">Saarr's Modesty</div>
        <div class="small text-muted">
          Warm, elegant en modest — geïnspireerd op aardse tinten.
        </div>
      </div>

      <div class="col-md-6">
        <div class="fw-semibold mb-2">Nieuwsbrief</div>
        <form class="d-flex gap-2" method="post" action="<?= e(base_path()) ?>/newsletter/subscribe">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input class="form-control" type="email" name="email" placeholder="jij@voorbeeld.nl" required>
          <button class="btn btn-primary">Abonneer</button>
        </form>
        <div class="small text-muted mt-2">
         Meld je aan en krijg 10% korting op je eerste bestelling!
        </div>
      </div>
    </div>

    <hr class="my-4">

    <div class="small text-muted">
      © <?= date('Y') ?> Saarr's Modesty
    </div>
  </div>
</footer>

<!-- Welcome discount modal -->
<div class="modal fade" id="welcomeDiscountModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Welkomskorting 🎉</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Sluiten"></button>
      </div>
      <div class="modal-body">
        Bedankt voor je inschrijving! Gebruik kortingscode
        <span class="badge badge-earth">WELCOME10</span>
        voor <b>10% korting</b> in je winkelwagen.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Top!</button>
      </div>
    </div>
  </div>
</div>

<?php unset($_SESSION['welcome_discount']); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= e(base_path()) ?>/assets/js/app.js"></script>
</body>
</html>

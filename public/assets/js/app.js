(() => {
  // Auto-hide bootstrap alerts
  setTimeout(() => {
    document.querySelectorAll('.alert[data-autohide="1"]').forEach(el => el.remove());
  }, 4500);

  // Confirm remove from cart
  document.querySelectorAll('[data-confirm="remove"]').forEach(a => {
    a.addEventListener('click', (e) => {
      if (!confirm('Item verwijderen uit je winkelwagen?')) e.preventDefault();
    });
  });

  // Welcome discount popup after newsletter subscribe
  const welcome = document.body.getAttribute('data-welcome-discount');
  if (welcome === '1') {
    setTimeout(() => {
      const modalEl = document.getElementById('welcomeDiscountModal');
      if (!modalEl) {
        alert('Welkom! Gebruik code WELCOME10 voor 10% korting 🎉');
        return;
      }
      const modal = new bootstrap.Modal(modalEl);
      modal.show();
    }, 5000);
  }
})();

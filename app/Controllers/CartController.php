<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Services\CartService;

final class CartController
{
  public function show(): void {
    $categories = Category::all();
    $items = CartService::items();
    $subtotal = CartService::subtotal();

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/cart.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }

  public function add(): void {
    csrf_check($_POST['csrf'] ?? null);

    $variantId = (int)($_POST['variant_id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);

    try {
      CartService::add($variantId, $qty);
      flash('success', 'Toegevoegd aan winkelwagen.');
    } catch (\Throwable $e) {
      flash('error', $e->getMessage());
    }

    $back = $_SERVER['HTTP_REFERER'] ?? (base_path() . '/');
    header("Location: " . $back);
    exit;
  }

  public function update(): void {
    csrf_check($_POST['csrf'] ?? null);

    foreach (($_POST['qty'] ?? []) as $variantId => $qty) {
      CartService::update((int)$variantId, (int)$qty);
    }
    header("Location: " . base_path() . "/cart");
    exit;
  }

  public function remove(int $variantId): void {
    CartService::remove($variantId);
    header("Location: " . base_path() . "/cart");
    exit;
  }
}

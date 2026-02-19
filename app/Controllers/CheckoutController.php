<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Services\CartService;
use App\Services\OrderService;

final class CheckoutController
{
  public function form(): void {
    $categories = Category::all();
    $items = CartService::items();
    if (!$items) { header("Location: " . base_path() . "/cart"); exit; }

    $subtotal = CartService::subtotal();
    $old = $_SESSION['checkout_old'] ?? [];
    unset($_SESSION['checkout_old']);

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/checkout.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }

  public function submit(): void {
    csrf_check($_POST['csrf'] ?? null);

    try {
      $orderNumber = OrderService::place($_POST);
      header("Location: " . base_path() . "/success/" . urlencode($orderNumber));
      exit;
    } catch (\Throwable $e) {
      flash('error', $e->getMessage());
      $_SESSION['checkout_old'] = $_POST;
      header("Location: " . base_path() . "/checkout");
      exit;
    }
  }

  public function success(string $orderNumber): void {
    $categories = Category::all();
    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/success.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }
}

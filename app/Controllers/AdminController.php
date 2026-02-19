<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Database;
use App\Middleware\Auth;

final class AdminController
{
  public function dashboard(): void
  {
    Auth::requireAdmin();

    $categories = Category::all();

    $pdo = Database::pdo();
    $rows = $pdo->query("
      SELECT v.id AS variant_id, v.size, v.color, v.stock,
             p.id AS product_id, p.name_nl, p.name_en
      FROM variants v
      JOIN products p ON p.id = v.product_id
      ORDER BY p.id DESC, v.size, v.color
      LIMIT 200
    ")->fetchAll();

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/admin.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }

  public function updateStock(): void
  {
    Auth::requireAdmin();
    csrf_check($_POST['csrf'] ?? null);

    $variantId = (int)($_POST['variant_id'] ?? 0);
    $stock = (int)($_POST['stock'] ?? 0);
    if ($variantId <= 0) { header("Location: " . base_path() . "/admin"); exit; }
    if ($stock < 0) $stock = 0;

    $pdo = Database::pdo();
    $stmt = $pdo->prepare("UPDATE variants SET stock = ? WHERE id = ?");
    $stmt->execute([$stock, $variantId]);

    flash('success', 'Voorraad aangepast.');
    header("Location: " . base_path() . "/admin");
    exit;
  }
}

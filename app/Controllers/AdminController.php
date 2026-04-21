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

    if ($variantId <= 0) {
      header("Location: " . base_path() . "/admin");
      exit;
    }

    if ($stock < 0) $stock = 0;

    $pdo = Database::pdo();
    $stmt = $pdo->prepare("UPDATE variants SET stock = ? WHERE id = ?");
    $stmt->execute([$stock, $variantId]);

    flash('success', 'Voorraad aangepast.');
    header("Location: " . base_path() . "/admin");
    exit;
  }

  // ➕ NIEUW: formulier tonen
  public function createForm(): void
  {
    Auth::requireAdmin();
    $categories = Category::all();

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/admin_create.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }

  // ➕ NIEUW: product opslaan
  public function create(): void
  {
    Auth::requireAdmin();

    $name_nl = trim($_POST['name_nl'] ?? '');
    $name_en = trim($_POST['name_en'] ?? '');
    $price = (float)($_POST['price'] ?? 0);

    if ($name_nl === '' || $price <= 0) {
      flash('error', 'Vul alles correct in.');
      header("Location: " . base_path() . "/admin/create");
      exit;
    }

    $pdo = Database::pdo();

    // product toevoegen
    $stmt = $pdo->prepare("
      INSERT INTO products (name_nl, name_en, price, is_active, created_at)
      VALUES (:nl, :en, :price, 1, NOW())
    ");

    $stmt->execute([
      'nl' => $name_nl,
      'en' => $name_en,
      'price' => $price
    ]);

    flash('success', 'Product toegevoegd.');
    header("Location: " . base_path() . "/admin");
    exit;
  }

  // ❌ NIEUW: product verwijderen
  public function delete(int $id): void
  {
    Auth::requireAdmin();

    $pdo = Database::pdo();

    // eerst variants verwijderen (anders foreign key error)
    $pdo->prepare("DELETE FROM variants WHERE product_id = ?")->execute([$id]);

    // dan product
    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);

    flash('success', 'Product verwijderd.');
    header("Location: " . base_path() . "/admin");
    exit;
  }
}
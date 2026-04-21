<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

final class CatalogController
{
  public function category(string $slug): void
  {
    $categories = Category::all();
    $category = Category::findBySlug($slug);

    if (!$category) {
      http_response_code(404);
      echo "Categorie niet gevonden";
      return;
    }

    $sort = $_GET['sort'] ?? 'newest';

    switch ($sort) {
      case 'price_low':
        $order = "price ASC";
        break;

      case 'price_high':
        $order = "price DESC";
        break;

      default:
        $order = "created_at DESC";
    }

    $products = Product::byCategoryId((int)$category['id'], $order);

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/category.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }

  public function search(): void
  {
    $query = trim($_GET['search'] ?? '');

    if ($query === '') {
      header("Location: " . base_path() . "/catalog");
      exit;
    }

    $products = Product::search($query);
    $categories = Category::all();

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/category.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }
}
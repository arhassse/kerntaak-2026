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

    $products = Product::byCategoryId((int)$category['id']);

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/category.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }

public function search(): void
{
    $query = trim($_GET['q'] ?? '');

    if ($query === '') {
        header("Location: " . base_path() . "/catalog");
        exit;
    }

    $products = \App\Models\Product::search($query);
    $categories = \App\Models\Category::all();

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/catalog/index.php';
    require __DIR__ . '/../Views/partials/footer.php';
}


}



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
}

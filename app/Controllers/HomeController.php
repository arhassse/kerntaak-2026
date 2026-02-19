<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

final class HomeController
{
  public function index(): void
  {
    $categories = Category::all();

    // 1 uitgelicht product per categorie (laatste in die categorie)
    $featured = [];
    foreach ($categories as $c) {
      $items = Product::byCategoryId((int)$c['id']);
      if (!empty($items)) {
        $featured[] = ['category' => $c, 'product' => $items[0]];
      }
    }

    $latest = Product::latest(8);

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/home.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }
}

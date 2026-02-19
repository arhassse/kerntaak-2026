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
    $latest = Product::latest(8);

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/home.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }
}

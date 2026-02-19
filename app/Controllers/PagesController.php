<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;

final class PagesController
{
  public function about(): void
  {
    $categories = Category::all();
    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/about.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }

  public function contact(): void
  {
    $categories = Category::all();
    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/contact.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }

  public function reviews(): void
  {
    $categories = Category::all();
    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/reviews.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }
}

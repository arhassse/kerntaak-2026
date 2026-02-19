<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Variant;

final class ProductController
{
  public function show(int $id): void
  {
    $categories = Category::all();
    $product = Product::find($id);

    if (!$product) {
      http_response_code(404);
      echo "Product niet gevonden";
      return;
    }

    $variants = Variant::byProductId($id);

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/product.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }
}

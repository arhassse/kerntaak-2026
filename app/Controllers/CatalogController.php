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

    // 🔥 sort fix
    $sort = $_GET['sort'] ?? 'newest';

    switch ($sort) {
      case 'price_low':
        $order = "p.price ASC";
        break;

      case 'price_high':
        $order = "p.price DESC";
        break;

      default:
        $order = "p.created_at DESC";
    }

    // 🔥 juiste functie gebruiken (met sort)
    $products = Product::allSorted((int)$category['id'], $order);

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/category.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }

  public function search(): void
  {
    // 🔥 accepteert zowel ?search= als ?q=
    $query = trim($_GET['search'] ?? $_GET['q'] ?? '');

    if ($query === '') {
      header("Location: " . base_path() . "/");
      exit;
    }

    $products = Product::search($query);
    $categories = Category::all();

    // 🔥 fake category voor view (anders crash)
    $category = [
      'name_nl' => 'Zoekresultaten',
      'name_en' => 'Search results'
    ];

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/category.php';
    require __DIR__ . '/../Views/partials/footer.php';
  }
}
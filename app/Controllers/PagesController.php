<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Models\Review;
$categories = Category::all();
$reviews = Review::all();
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
    $categories = \App\Models\Category::all();
    $reviews = \App\Models\Review::all();

    require __DIR__ . '/../Views/partials/header.php';
    require __DIR__ . '/../Views/pages/reviews.php';
    require __DIR__ . '/../Views/partials/footer.php';
}

public function reviewsSubmit(): void
{
    csrf_check($_POST['csrf'] ?? null);

    $name = trim($_POST['name'] ?? '');
    $rating = (int)($_POST['rating'] ?? 0);
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $message === '' || $rating < 1 || $rating > 5) {
        flash('error', 'Vul alles correct in.');
        header("Location: " . base_path() . "/reviews");
        exit;
    }

    \App\Models\Review::create($name, $rating, $message);

    flash('success', 'Bedankt voor je review!');
    header("Location: " . base_path() . "/reviews");
    exit;
}


}


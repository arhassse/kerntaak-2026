<?php
declare(strict_types=1);

namespace App\Models;

final class Review
{
  public static function all(): array
  {
    $pdo = Database::pdo();
    return $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC")->fetchAll();
  }

  public static function create(string $name, int $rating, string $message): void
  {
    $pdo = Database::pdo();
    $stmt = $pdo->prepare("INSERT INTO reviews (name, rating, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $rating, $message]);
  }
}
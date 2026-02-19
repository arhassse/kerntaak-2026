<?php
declare(strict_types=1);

namespace App\Models;

final class Category
{
  public static function all(): array
  {
    $pdo = Database::pdo();
    return $pdo->query("SELECT id, slug, name_nl, name_en FROM categories ORDER BY id")->fetchAll();
  }

  public static function findBySlug(string $slug): ?array
  {
    $pdo = Database::pdo();
    $stmt = $pdo->prepare("SELECT id, slug, name_nl, name_en FROM categories WHERE slug = :slug LIMIT 1");
    $stmt->execute(['slug' => $slug]);
    $row = $stmt->fetch();
    return $row ?: null;
  }
}

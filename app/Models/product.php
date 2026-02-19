<?php
declare(strict_types=1);

namespace App\Models;

final class Product
{
  public static function latest(int $limit = 8): array
  {
    $pdo = Database::pdo();
    $stmt = $pdo->prepare("
      SELECT p.*, pi.image_path
      FROM products p
      LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.sort_order = 0
      WHERE p.is_active = 1
      ORDER BY p.created_at DESC
      LIMIT :lim
    ");
    $stmt->bindValue('lim', $limit, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public static function byCategoryId(int $categoryId): array
  {
    $pdo = Database::pdo();
    $stmt = $pdo->prepare("
      SELECT p.*, pi.image_path
      FROM products p
      LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.sort_order = 0
      WHERE p.is_active = 1 AND p.category_id = :cid
      ORDER BY p.created_at DESC
    ");
    $stmt->execute(['cid' => $categoryId]);
    return $stmt->fetchAll();
  }

  public static function find(int $id): ?array
  {
    $pdo = Database::pdo();
    $stmt = $pdo->prepare("
      SELECT p.*, pi.image_path
      FROM products p
      LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.sort_order = 0
      WHERE p.id = :id AND p.is_active = 1
      LIMIT 1
    ");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
  }
}

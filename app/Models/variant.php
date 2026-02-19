<?php
declare(strict_types=1);

namespace App\Models;

final class Variant
{
  public static function byProductId(int $productId): array {
    $pdo = Database::pdo();
    $stmt = $pdo->prepare("
      SELECT id, size, color, stock, is_active
      FROM variants
      WHERE product_id = :pid AND is_active = 1
      ORDER BY size, color
    ");
    $stmt->execute(['pid' => $productId]);
    return $stmt->fetchAll();
  }

  public static function findWithProduct(int $variantId): ?array {
    $pdo = Database::pdo();
    $stmt = $pdo->prepare("
      SELECT v.*, p.id AS product_id, p.price, p.is_active AS product_active,
             p.name_nl, p.name_en,
             pi.image_path
      FROM variants v
      JOIN products p ON p.id = v.product_id
      LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.sort_order = 0
      WHERE v.id = :id
      LIMIT 1
    ");
    $stmt->execute(['id' => $variantId]);
    $row = $stmt->fetch();
    return $row ?: null;
  }

  public static function manyWithProduct(array $variantIds): array {
    $variantIds = array_values(array_unique(array_map('intval', $variantIds)));
    if (!$variantIds) return [];

    $pdo = Database::pdo();
    $in = implode(',', array_fill(0, count($variantIds), '?'));
    $stmt = $pdo->prepare("
      SELECT v.*, p.id AS product_id, p.price, p.is_active AS product_active,
             p.name_nl, p.name_en,
             pi.image_path
      FROM variants v
      JOIN products p ON p.id = v.product_id
      LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.sort_order = 0
      WHERE v.id IN ($in)
    ");
    $stmt->execute($variantIds);
    return $stmt->fetchAll();
  }
}

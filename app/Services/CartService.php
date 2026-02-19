<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Variant;

final class CartService
{
  private const DISCOUNT_CODES = [
    'WELCOME10' => 10, // 10%
  ];

  private static function &cart(): array {
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];
    return $_SESSION['cart'];
  }

  public static function add(int $variantId, int $qty): void {
    if ($qty < 1) $qty = 1;

    $variant = Variant::findWithProduct($variantId);
    if (!$variant) throw new \RuntimeException('Variant niet gevonden.');
    if ((int)$variant['is_active'] !== 1 || (int)$variant['product_active'] !== 1) throw new \RuntimeException('Niet beschikbaar.');

    $stock = (int)$variant['stock'];
    if ($stock <= 0) throw new \RuntimeException('Niet op voorraad.');

    $cart = &self::cart();
    $current = (int)($cart[$variantId] ?? 0);
    $newQty = min($current + $qty, $stock);
    $cart[$variantId] = $newQty;
  }

  public static function update(int $variantId, int $qty): void {
    $cart = &self::cart();
    if (!isset($cart[$variantId])) return;

    if ($qty <= 0) { unset($cart[$variantId]); return; }

    $variant = Variant::findWithProduct($variantId);
    if (!$variant) { unset($cart[$variantId]); return; }

    $stock = (int)$variant['stock'];
    $cart[$variantId] = min($qty, max(1, $stock));
    if ($stock <= 0) unset($cart[$variantId]);
  }

  public static function remove(int $variantId): void {
    $cart = &self::cart();
    unset($cart[$variantId]);
  }

  public static function items(): array {
    $cart = self::cart();
    if (!$cart) return [];

    $variantIds = array_map('intval', array_keys($cart));
    $rows = Variant::manyWithProduct($variantIds);

    $items = [];
    foreach ($rows as $r) {
      $vid = (int)$r['id'];
      if (!isset($cart[$vid])) continue;
      $qty = (int)$cart[$vid];
      $price = (float)$r['price'];
      $line = $price * $qty;

      $items[] = [
        'variant_id' => $vid,
        'qty' => $qty,
        'price' => $price,
        'line_total' => $line,
        'product_id' => (int)$r['product_id'],
        'product_name' => $r['name_' . lang()],
        'image_path' => $r['image_path'] ?? null,
        'size' => $r['size'],
        'color' => $r['color'],
        'stock' => (int)$r['stock'],
      ];
    }
    return $items;
  }

  public static function subtotal(): float {
    $sum = 0.0;
    foreach (self::items() as $it) $sum += (float)$it['line_total'];
    return $sum;
  }

  public static function applyDiscountCode(string $code): void
  {
    $code = strtoupper(trim($code));
    if ($code === '') {
      self::clearDiscount();
      return;
    }

    if (!isset(self::DISCOUNT_CODES[$code])) {
      throw new \RuntimeException('Ongeldige kortingscode.');
    }

    $_SESSION['discount'] = [
      'code' => $code,
      'percent' => (int)self::DISCOUNT_CODES[$code],
    ];
  }

  public static function clearDiscount(): void
  {
    unset($_SESSION['discount']);
  }

  public static function discountCode(): ?string
  {
    return $_SESSION['discount']['code'] ?? null;
  }

  public static function discountPercent(): int
  {
    return (int)($_SESSION['discount']['percent'] ?? 0);
  }

  public static function discountAmount(float $subtotal): float
  {
    $p = self::discountPercent();
    if ($p <= 0) return 0.0;
    return round($subtotal * ($p / 100), 2);
  }

  public static function total(): float
  {
    $subtotal = self::subtotal();
    $discount = self::discountAmount($subtotal);
    return max(0.0, round($subtotal - $discount, 2));
  }

  public static function clear(): void {
    $_SESSION['cart'] = [];
  }

  public static function count(): int {
    $c = 0;
    foreach (self::cart() as $qty) $c += (int)$qty;
    return $c;
  }
}

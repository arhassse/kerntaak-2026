<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Database;
use App\Models\Variant;

final class OrderService
{
  public static function place(array $customer): string
  {
    $items = CartService::items();
    if (!$items) {
      throw new \RuntimeException('Winkelwagen is leeg.');
    }

    $required = ['customer_name','email','address','postal_code','city','country'];
    foreach ($required as $k) {
      if (empty(trim((string)($customer[$k] ?? '')))) {
        throw new \RuntimeException("Veld ontbreekt: $k");
      }
    }

    $pdo = Database::pdo();
    $pdo->beginTransaction();

    try {

      // 1️⃣ Voorraad check
      foreach ($items as $it) {
        $v = Variant::findWithProduct((int)$it['variant_id']);
        if (!$v) throw new \RuntimeException('Variant niet gevonden.');
        if ((int)$v['stock'] < (int)$it['qty']) {
          throw new \RuntimeException('Niet genoeg voorraad.');
        }
      }

      $subtotal = CartService::subtotal();
      $total = CartService::total();

      $orderNumber = 'SAARR-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2)));
      $status = 'Paid_demo';

      // 2️⃣ Order eerst opslaan
      $stmt = $pdo->prepare("
        INSERT INTO orders
        (user_id, order_number, status, language, customer_name, email, address, postal_code, city, country, subtotal, total)
        VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
      ");

      $stmt->execute([
        $_SESSION['user']['id'] ?? null,
        $orderNumber,
        $status,
        $_SESSION['lang'] ?? 'nl',
        trim($customer['customer_name']),
        trim($customer['email']),
        trim($customer['address']),
        trim($customer['postal_code']),
        trim($customer['city']),
        trim($customer['country']),
        $subtotal,
        $total,
      ]);

      // 3️⃣ Nu pas orderId ophalen
      $orderId = (int)$pdo->lastInsertId();

      // 4️⃣ Order items opslaan
      $itemStmt = $pdo->prepare("
        INSERT INTO order_items
        (order_id, variant_id, product_snapshot, variant_snapshot, unit_price, quantity, line_total)
        VALUES
        (?, ?, ?, ?, ?, ?, ?)
      ");

      // 5️⃣ Voorraad update statement
      $stockStmt = $pdo->prepare("
        UPDATE variants
        SET stock = stock - ?
        WHERE id = ? AND stock >= ?
      ");

      foreach ($items as $it) {

        $itemStmt->execute([
          $orderId,
          (int)$it['variant_id'],
          $it['product_name'],
          $it['size'] . ' / ' . $it['color'],
          (float)$it['price'],
          (int)$it['qty'],
          (float)$it['line_total'],
        ]);

        $stockStmt->execute([
          (int)$it['qty'],
          (int)$it['variant_id'],
          (int)$it['qty'],
        ]);

        if ($stockStmt->rowCount() !== 1) {
          throw new \RuntimeException('Voorraad conflict, probeer opnieuw.');
        }
      }

      $pdo->commit();
      CartService::clear();
      CartService::clearDiscount();

      return $orderNumber;

    } catch (\Throwable $e) {
      $pdo->rollBack();
      throw $e;
    }
  }
}

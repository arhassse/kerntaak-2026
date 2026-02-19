<?php
declare(strict_types=1);

namespace App\Middleware;

final class Auth
{
  public static function requireLogin(): void
  {
    if (empty($_SESSION['user'])) {
      header("Location: " . base_path() . "/login");
      exit;
    }
  }

  public static function requireAdmin(): void
  {
    self::requireLogin();
    if (($_SESSION['user']['role'] ?? '') !== 'admin') {
      http_response_code(403);
      exit('403 - Admin only');
    }
  }
}

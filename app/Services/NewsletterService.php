<?php
declare(strict_types=1);

namespace App\Services;

final class NewsletterService
{
  private const FILE = __DIR__ . '/../../storage/newsletter_subscribers.txt';

  public static function subscribe(string $email): void
  {
    $email = strtolower(trim($email));

    // Ensure storage folder exists
    $dir = dirname(self::FILE);
    if (!is_dir($dir)) @mkdir($dir, 0777, true);

    // Deduplicate
    $existing = [];
    if (file_exists(self::FILE)) {
      $lines = file(self::FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
      foreach ($lines as $line) $existing[$line] = true;
    }

    if (!isset($existing[$email])) {
      file_put_contents(self::FILE, $email . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
  }
}

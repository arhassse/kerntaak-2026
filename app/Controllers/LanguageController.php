<?php
declare(strict_types=1);

namespace App\Controllers;

final class LanguageController
{
  public function set(string $code): void
  {
    $_SESSION['lang'] = in_array($code, ['nl','en'], true) ? $code : 'nl';

    $back = $_SERVER['HTTP_REFERER'] ?? (base_path() . '/');
    header("Location: " . $back);
    exit;
  }
}

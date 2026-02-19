<?php
declare(strict_types=1);

function e(string $value): string {
  return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function lang(): string {
  $allowed = ['nl','en'];
  $l = $_SESSION['lang'] ?? 'nl';
  return in_array($l, $allowed, true) ? $l : 'nl';
}

function t(string $key): string {
  static $dict = null;
  if ($dict === null) {
    $dict = require __DIR__ . '/lang/' . lang() . '.php';
  }
  return $dict[$key] ?? $key;
}

function field(array $row, string $base): string {
  // base = 'name' -> name_nl/name_en
  $key = $base . '_' . lang();
  return (string)($row[$key] ?? '');
}

function base_path(): string {
  $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
  $dir = rtrim($dir, '/');

  // FIX: spaties in mapnaam moeten %20 zijn
  return str_replace(' ', '%20', $dir);
}

function csrf_token(): string {
  if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf'];
}

function csrf_check(?string $token): void {
  if (!$token || empty($_SESSION['csrf']) || !hash_equals($_SESSION['csrf'], $token)) {
    http_response_code(403);
    exit('403 - CSRF check failed');
  }
}

function flash(string $key, ?string $value = null): ?string {
  if ($value !== null) {
    $_SESSION['_flash'][$key] = $value;
    return null;
  }
  $msg = $_SESSION['_flash'][$key] ?? null;
  unset($_SESSION['_flash'][$key]);
  return $msg;
}

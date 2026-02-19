<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Category;
use App\Services\NewsletterService;

final class NewsletterController
{
  public function subscribe(): void
  {
    csrf_check($_POST['csrf'] ?? null);

    $email = trim((string)($_POST['email'] ?? ''));
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
      flash('error', 'Vul een geldig e-mailadres in.');
      header("Location: " . ($_SERVER['HTTP_REFERER'] ?? (base_path() . '/')));
      exit;
    }

    NewsletterService::subscribe($email);

    // Trigger welcome popup once
    $_SESSION['welcome_discount'] = true;

    flash('success', 'Ingeschreven voor de nieuwsbrief!');
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? (base_path() . '/')));
    exit;
  }
}

<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Database;
use App\Models\Category;

final class AuthController
{
    public function loginForm(): void
    {
        $categories = Category::all();

        require __DIR__ . '/../Views/partials/header.php';
        require __DIR__ . '/../Views/pages/login.php';
        require __DIR__ . '/../Views/partials/footer.php';
    }

    public function login(): void
    {
        csrf_check($_POST['csrf'] ?? null);

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $pdo = Database::pdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        // ✅ FIX: password_hash gebruiken
        if (!$user || !password_verify($password, $user['password_hash'])) {
            flash('error', 'Onjuiste login.');
            header("Location: " . base_path() . "/login");
            exit;
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'] ?? 'user' // handig voor admin later
        ];

        header("Location: " . base_path() . "/");
        exit;
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        header("Location: " . base_path() . "/");
        exit;
    }

    // 👉 Registratie formulier
    public function showRegister(): void
    {
        $categories = Category::all();

        require __DIR__ . '/../Views/partials/header.php';
        require __DIR__ . '/../Views/pages/register.php';
        require __DIR__ . '/../Views/partials/footer.php';
    }

    // 👉 Registratie opslaan
    public function register(): void
    {
        csrf_check($_POST['csrf'] ?? null);

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            flash('error', 'Vul alle velden in.');
            header("Location: " . base_path() . "/register");
            exit;
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $pdo = Database::pdo();

        $stmt = $pdo->prepare("
            INSERT INTO users (email, password_hash, role)
            VALUES (:email, :password, 'user')
        ");

        $stmt->execute([
            'email' => $email,
            'password' => $hash
        ]);

        flash('success', 'Account aangemaakt! Je kunt nu inloggen.');

        header("Location: " . base_path() . "/login");
        exit;
    }
}
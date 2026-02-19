<?php
declare(strict_types=1);

session_start();
require_once __DIR__ . '/../app/bootstrap.php';

use App\Controllers\HomeController;
use App\Controllers\CatalogController;
use App\Controllers\ProductController;
use App\Controllers\LanguageController;
use App\Controllers\CartController;
use App\Controllers\CheckoutController;
use App\Controllers\AuthController;
use App\Controllers\AdminController;
use App\Controllers\PagesController;
use App\Controllers\NewsletterController;

$home = new HomeController();
$catalog = new CatalogController();
$product = new ProductController();
$lang = new LanguageController();
$cart = new CartController();
$checkout = new CheckoutController();
$auth = new AuthController();
$admin = new AdminController();
$pages = new PagesController();
$newsletter = new NewsletterController();

// 1) Pak alleen het pad (zonder querystring)
$uriPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

// 2) Decode %20 enz. (voor spaties e.d.)
$uriPath = rawurldecode($uriPath);

// 3) Haal alles vóór /public eruit, zodat routes schoon zijn
$pos = strpos($uriPath, '/public');
if ($pos !== false) {
  $uriPath = substr($uriPath, $pos + strlen('/public'));
}

// 4) Haal eventueel /index.php er ook af
$uriPath = preg_replace('#^/index\.php#', '', $uriPath);

// 5) Normaliseer naar: /, /category/abaya, /product/1, etc.
$path = '/' . ltrim($uriPath, '/');
if ($path === '//') $path = '/';

// ---------------- ROUTES ----------------

// HOME
if ($path === '/' || $path === '') {
  $home->index();
  exit;
}

// CATALOG
if (preg_match('#^/category/([a-z0-9\-]+)$#i', $path, $m)) {
  $catalog->category($m[1]);
  exit;
}

// PRODUCT
if (preg_match('#^/product/(\d+)$#', $path, $m)) {
  $product->show((int)$m[1]);
  exit;
}

// LANGUAGE
if (preg_match('#^/lang/(nl|en)$#', $path, $m)) {
  $lang->set($m[1]);
  exit;
}

// CART
if ($path === '/cart' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $cart->show();
  exit;
}

if ($path === '/cart/add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $cart->add();
  exit;
}

if ($path === '/cart/update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $cart->update();
  exit;
}

if ($path === '/cart/discount' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $cart->applyDiscount();
  exit;
}

if (preg_match('#^/cart/remove/(\d+)$#', $path, $m)) {
  $cart->remove((int)$m[1]);
  exit;
}

// CHECKOUT
if ($path === '/checkout' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $checkout->form();
  exit;
}

if ($path === '/checkout' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $checkout->submit();
  exit;
}

if (preg_match('#^/success/(.+)$#', $path, $m)) {
  $checkout->success($m[1]);
  exit;
}

// PAGES (about/contact/reviews)
if ($path === '/about' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $pages->about();
  exit;
}

if ($path === '/contact' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $pages->contact();
  exit;
}

if ($path === '/reviews' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $pages->reviews();
  exit;
}

if ($path === '/reviews' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $pages->reviewsSubmit();
  exit;
}

// NEWSLETTER
if ($path === '/newsletter/subscribe' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $newsletter->subscribe();
  exit;
}

// AUTH
if ($path === '/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $auth->loginForm();
  exit;
}

if ($path === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $auth->login();
  exit;
}

if ($path === '/logout') {
  $auth->logout();
  exit;
}

// ADMIN
if ($path === '/admin' && $_SERVER['REQUEST_METHOD'] === 'GET') {
  $admin->dashboard();
  exit;
}

if ($path === '/admin/stock' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  $admin->updateStock();
  exit;
}

// 404
http_response_code(404);
echo "404 - pagina niet gevonden";
<?php
session_start();
define('DATA_FILE', __DIR__ . '/../data.txt');
define('PIC_DIR', __DIR__ . '/../prodpic/');
// ---- Change these ----
define('SHOP_NAME', 'Sri Thirumala Traders');
define('OWNER', 'Karthick T R');
define('PHONE1', '7010129993');
define('PHONE2', '8754072924');
define('ADDRESS', 'Lakshmi Nagar Phase II, Cheran Ma Nagar, Kalapatti Post, Phase II, Balaji Nagar');
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'thirumala@123');

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function load_products() {
    $d = json_decode(@file_get_contents(DATA_FILE), true);
    return $d['products'] ?? [];
}
function save_products($list) {
    file_put_contents(DATA_FILE, json_encode(['products' => array_values($list)], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
}
function categories($list) {
    $c = array_unique(array_column($list, 'category'));
    sort($c);
    return $c;
}
function pic_url($p, $base = '') {
    if (!empty($p['image']) && is_file(PIC_DIR . $p['image'])) return $base . 'prodpic/' . rawurlencode($p['image']);
    return $base . 'assets/placeholder.svg';
}
function money($n) { return '₹' . number_format((float)$n, 2); }
function csrf() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['csrf'];
}
function check_csrf() {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(400); exit('Session expired. Go back and try again.'); }
}
function require_admin() {
    if (empty($_SESSION['admin'])) { header('Location: index.php'); exit; }
}

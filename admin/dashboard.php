<?php
require_once __DIR__ . '/../inc/functions.php';
require_admin();
$msg = ''; $err = '';
$products = load_products();

function save_upload() {
    if (empty($_FILES['image']['name']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) return '';
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK || $_FILES['image']['size'] > 3 * 1024 * 1024) throw new Exception('Image must be under 3 MB.');
    $info = @getimagesize($_FILES['image']['tmp_name']);
    $ext = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'][$info[2] ?? 0] ?? null;
    if (!$ext) throw new Exception('Use a JPG, PNG or WEBP image.');
    $name = bin2hex(random_bytes(8)) . '.' . $ext;
    if (!move_uploaded_file($_FILES['image']['tmp_name'], PIC_DIR . $name)) throw new Exception('Could not save the image. Check prodpic folder permissions.');
    return $name;
}
function drop_pic($name) { if ($name && is_file(PIC_DIR . $name)) unlink(PIC_DIR . $name); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_csrf();
    $act = $_POST['action'] ?? '';
    try {
        if ($act === 'delete') {
            foreach ($products as $i => $p) if ($p['id'] === $_POST['id']) { drop_pic($p['image']); unset($products[$i]); }
            save_products($products); $msg = 'Product deleted.';
        } elseif ($act === 'add' || $act === 'edit') {
            $name = trim($_POST['name'] ?? ''); $cat = trim($_POST['category'] ?? '');
            $price = $_POST['price'] ?? ''; $unit = trim($_POST['unit'] ?? '');
            if ($name === '' || $cat === '' || !is_numeric($price) || $price < 0) throw new Exception('Enter a name, category and a valid price.');
            $new = save_upload();
            $row = ['name' => $name, 'category' => $cat, 'price' => (float)$price, 'unit' => $unit, 'description' => trim($_POST['description'] ?? '')];
            if ($act === 'add') {
                $row = ['id' => 'p' . bin2hex(random_bytes(4))] + $row + ['image' => $new];
                $products[] = $row; $msg = 'Product added.';
            } else {
                foreach ($products as $i => $p) if ($p['id'] === $_POST['id']) {
                    if ($new) { drop_pic($p['image']); $p['image'] = $new; }
                    $products[$i] = $row + $p; $msg = 'Product updated.';
                }
            }
            save_products($products);
        }
    } catch (Exception $ex) { $err = $ex->getMessage(); }
    $products = load_products();
}

$edit = null;
if (!empty($_GET['edit'])) foreach ($products as $p) if ($p['id'] === $_GET['edit']) $edit = $p;
$q = trim($_GET['q'] ?? ''); $fc = $_GET['cat'] ?? '';
$list = array_filter($products, fn($p) =>
    ($fc === '' || $p['category'] === $fc) &&
    ($q === '' || stripos($p['name'] . ' ' . $p['category'] . ' ' . $p['description'], $q) !== false));
$cats = categories($products);
?><!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard | <?= e(SHOP_NAME) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Barlow:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/style.css">
</head>
<body class="admin">
<header class="site-head">
  <a class="brand" href="dashboard.php"><img src="../assets/logo.svg" alt="" width="44" height="44"><span>Dashboard</span></a>
  <nav><a href="../index.php" target="_blank">View website</a><a href="logout.php">Log out</a></nav>
</header>
<main class="wrap">
  <div class="stats">
    <div><b><?= count($products) ?></b> products</div>
    <div><b><?= count($cats) ?></b> categories</div>
  </div>
  <?php if ($msg): ?><div class="ok"><?= e($msg) ?></div><?php endif; ?>
  <?php if ($err): ?><div class="alert"><?= e($err) ?></div><?php endif; ?>

  <form class="panel" method="post" enctype="multipart/form-data" id="form">
    <h2><?= $edit ? 'Edit product' : 'Add a product' ?></h2>
    <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
    <input type="hidden" name="action" value="<?= $edit ? 'edit' : 'add' ?>">
    <?php if ($edit): ?><input type="hidden" name="id" value="<?= e($edit['id']) ?>"><?php endif; ?>
    <div class="grid">
      <label>Product name<input name="name" required value="<?= e($edit['name'] ?? '') ?>"></label>
      <label>Category<input name="category" list="cats" required placeholder="Cement, Concrete, Bricks" value="<?= e($edit['category'] ?? '') ?>"></label>
      <datalist id="cats"><?php foreach ($cats as $c): ?><option value="<?= e($c) ?>"><?php endforeach; ?></datalist>
      <label>Price (₹)<input name="price" type="number" step="0.01" min="0" required value="<?= e($edit['price'] ?? '') ?>"></label>
      <label>Unit<input name="unit" placeholder="per bag, per piece, per m³" value="<?= e($edit['unit'] ?? '') ?>"></label>
      <label class="full">Description<input name="description" value="<?= e($edit['description'] ?? '') ?>"></label>
      <label class="full">Photo <?= $edit ? '(leave empty to keep the current photo)' : '' ?><input name="image" type="file" accept="image/jpeg,image/png,image/webp"></label>
    </div>
    <button class="btn" type="submit"><?= $edit ? 'Save changes' : 'Add product' ?></button>
    <?php if ($edit): ?><a class="btn ghost dark" href="dashboard.php">Cancel</a><?php endif; ?>
  </form>

  <div class="panel">
    <h2>All products</h2>
    <form class="tools" method="get">
      <input type="search" name="q" placeholder="Search products" value="<?= e($q) ?>">
      <select name="cat"><option value="">All categories</option>
        <?php foreach ($cats as $c): ?><option <?= $c === $fc ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?>
      </select>
      <button class="btn small" type="submit">Search</button>
    </form>
    <div class="table-wrap">
    <table class="data">
      <thead><tr><th>Photo</th><th>Product</th><th>Category</th><th>Price</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach ($list as $p): ?>
        <tr>
          <td><img src="<?= e(pic_url($p, '../')) ?>" alt="" width="64" height="48"></td>
          <td><strong><?= e($p['name']) ?></strong></td>
          <td><?= e($p['category']) ?></td>
          <td class="num"><?= money($p['price']) ?> <small><?= e($p['unit']) ?></small></td>
          <td class="actions">
            <a class="btn small ghost dark" href="?edit=<?= e($p['id']) ?>#form">Edit</a>
            <form method="post" onsubmit="return confirm('Delete this product?')">
              <input type="hidden" name="csrf" value="<?= e(csrf()) ?>">
              <input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($p['id']) ?>">
              <button class="btn small danger" type="submit">Delete</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    </div>
    <?php if (!$list): ?><p class="empty">No products found.</p><?php endif; ?>
  </div>
</main>
</body></html>

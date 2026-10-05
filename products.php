<?php
$page = 'products'; $title = 'Products';
require 'inc/header.php';
$products = load_products();
$cats = categories($products);
?>
<section class="wrap">
  <h1 class="page-title">Products</h1>
  <div class="tools">
    <input type="search" id="q" placeholder="Search products" aria-label="Search products">
    <div class="pills" id="pills">
      <button class="on" data-cat="">All</button>
      <?php foreach ($cats as $c): ?><button data-cat="<?= e($c) ?>"><?= e($c) ?></button><?php endforeach; ?>
    </div>
  </div>
  <div class="table-wrap">
  <table class="data" id="tbl">
    <thead><tr><th>Photo</th><th>Product</th><th>Category</th><th>Price</th><th>Unit</th></tr></thead>
    <tbody>
    <?php foreach ($products as $p): ?>
      <tr data-cat="<?= e($p['category']) ?>">
        <td><img src="<?= e(pic_url($p)) ?>" alt="" width="64" height="48" loading="lazy"></td>
        <td><strong><?= e($p['name']) ?></strong><br><small><?= e($p['description']) ?></small></td>
        <td><?= e($p['category']) ?></td>
        <td class="num"><?= money($p['price']) ?></td>
        <td><?= e($p['unit']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
  <p class="empty" id="none" hidden>No products match your search.</p>
</section>
<script>
const q = document.getElementById('q'), rows = [...document.querySelectorAll('#tbl tbody tr')];
let cat = '';
function apply() {
  const t = q.value.trim().toLowerCase(); let shown = 0;
  rows.forEach(r => {
    const ok = (!cat || r.dataset.cat === cat) && r.textContent.toLowerCase().includes(t);
    r.hidden = !ok; if (ok) shown++;
  });
  document.getElementById('none').hidden = shown > 0;
}
q.addEventListener('input', apply);
document.getElementById('pills').addEventListener('click', e => {
  if (e.target.tagName !== 'BUTTON') return;
  document.querySelectorAll('#pills button').forEach(b => b.classList.remove('on'));
  e.target.classList.add('on'); cat = e.target.dataset.cat; apply();
});
</script>
<?php require 'inc/footer.php'; ?>

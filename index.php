<?php
$page = 'home'; $title = 'Home';
require 'inc/header.php';
$products = load_products();
$cats = categories($products);
?>
<section class="hero">
  <div class="hero-in">
    <h1>Cement, concrete and bricks, delivered to your site.</h1>
    <p><?= e(SHOP_NAME) ?> supplies building materials for homes and construction sites in Kalapatti and the nearby areas. Fair prices, honest quantity, on-time delivery.</p>
    <a class="btn" href="products.php">See all products</a>
    <a class="btn ghost" href="tel:<?= e(PHONE1) ?>">Call <?= e(PHONE1) ?></a>
  </div>
</section>

<section class="wrap split">
  <div>
    <h2>Who we are</h2>
    <p>We are a family-run building materials trader. Whether you are laying a foundation or finishing a wall, we help you pick the right material and get it to your site when you need it.</p>
    <p><a href="about.php">Read more about us</a></p>
  </div>
  <div class="video">
    <?php if (is_file(__DIR__ . '/assets/construction.mp4')): ?>
      <video controls preload="metadata" playsinline><source src="assets/construction.mp4" type="video/mp4"></video>
    <?php else: ?>
      <div class="video-empty">Put your friend's construction video at<br><code>assets/construction.mp4</code></div>
    <?php endif; ?>
  </div>
</section>

<section class="wrap">
  <h2>What we sell</h2>
  <?php foreach ($cats as $cat): ?>
    <h3 class="cat-title"><?= e($cat) ?></h3>
    <div class="cards">
      <?php foreach ($products as $p): if ($p['category'] !== $cat) continue; ?>
        <article class="card">
          <img src="<?= e(pic_url($p)) ?>" alt="<?= e($p['name']) ?>" loading="lazy">
          <div class="card-b">
            <h4><?= e($p['name']) ?></h4>
            <p class="price"><?= money($p['price']) ?> <span><?= e($p['unit']) ?></span></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
  <?php if (!$products): ?><p class="empty">Products will be listed here soon.</p><?php endif; ?>
</section>
<?php require 'inc/footer.php'; ?>

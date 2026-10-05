<?php
$page = 'about'; $title = 'About us';
require 'inc/header.php';
?>
<section class="wrap split">
  <div>
    <h1 class="page-title">About us</h1>
    <p><?= e(SHOP_NAME) ?> was started to give builders and home owners one reliable place to buy cement, concrete and bricks. Under proprietor <?= e(OWNER) ?>, we have served small home builders, contractors and site engineers around Kalapatti.</p>
    <p>We keep our promise simple: good quality material, clear prices and delivery on the day we say.</p>
    <ul class="ticks">
      <li>Branded and tested materials</li>
      <li>Clear prices, no hidden charges</li>
      <li>Delivery to your site</li>
      <li>Help choosing the right grade for your work</li>
    </ul>
    <p>Visit us or call <a href="tel:<?= e(PHONE1) ?>"><?= e(PHONE1) ?></a> or <a href="tel:<?= e(PHONE2) ?>"><?= e(PHONE2) ?></a>.</p>
  </div>
  <div class="video">
    <?php if (is_file(__DIR__ . '/assets/trader.gif')): ?>
      <img class="about-img" src="assets/trader.gif" alt="<?= e(SHOP_NAME) ?>">
    <?php else: ?>
      <div class="video-empty">Put your shop GIF at<br><code>assets/trader.gif</code></div>
    <?php endif; ?>
  </div>
</section>
<?php require 'inc/footer.php'; ?>

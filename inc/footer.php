</main>
<footer class="site-foot">
  <div class="foot-grid">
    <div>
      <h3><?= e(SHOP_NAME) ?></h3>
      <p class="tag">Your trusted partner in building your dreams</p>
    </div>
    <div>
      <h4>Proprietor</h4>
      <p><?= e(OWNER) ?></p>
    </div>
    <div>
      <h4>Call us</h4>
      <p><a href="tel:<?= e(PHONE1) ?>"><?= e(PHONE1) ?></a><br><a href="tel:<?= e(PHONE2) ?>"><?= e(PHONE2) ?></a></p>
    </div>
    <div>
      <h4>Location</h4>
      <p><?= e(ADDRESS) ?></p>
    </div>
  </div>
  <p class="copy">© <?= date('Y') ?> <?= e(SHOP_NAME) ?>. <a href="<?= $base ?>admin/">Admin</a></p>
</footer>
</body>
</html>

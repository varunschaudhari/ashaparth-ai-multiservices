<?php defined('APP_ROOT') || exit; ?>
</main>

<footer class="site-footer">
  <div class="container footer-top">
    <div class="footer-brand">
      <a class="brand" href="<?= e(url()) ?>">
        <img src="<?= e(asset('img/logo-mark.svg')) ?>" alt="" width="46" height="46">
        <span class="brand-text">
          <span class="brand-name">Asha<span class="p">Parth</span><span class="ai"> AI</span></span>
          <span class="brand-sub">MULTISERVICES</span>
        </span>
      </a>
      <p><?= e(config('tagline')) ?>. Websites, apps, AI, software, marketing and complete temple digitisation, from Amalner to the world.</p>
      <div class="social">
        <?php foreach (social_links() as $s): ?>
          <a href="<?= e($s['href']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['label']) ?>"><?= icon($s['icon']) ?></a>
        <?php endforeach; ?>
        <a href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><?= icon('whatsapp') ?></a>
      </div>
    </div>

    <div>
      <h4>Services</h4>
      <ul class="footer-links">
        <?php foreach (services() as $slug => $s): ?>
          <li><a href="<?= e(url('services/' . $slug)) ?>"><?= e($s['title']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div>
      <h4>Company</h4>
      <ul class="footer-links">
        <li><a href="<?= e(url('about')) ?>">About Us</a></li>
        <li><a href="<?= e(url('temple-solutions')) ?>">Temple Solutions</a></li>
        <li><a href="<?= e(url('devasthan-live')) ?>">Devasthan Live</a></li>
        <li><a href="<?= e(url('portfolio')) ?>">Portfolio</a></li>
        <li><a href="<?= e(url('blog')) ?>">Blog</a></li>
        <li><a href="<?= e(url('careers')) ?>">Careers</a></li>
        <li><a href="<?= e(url('get-a-quote')) ?>">Get a Quote</a></li>
        <li><a href="<?= e(url('contact')) ?>">Contact</a></li>
      </ul>
    </div>

    <div>
      <h4>Get in Touch</h4>
      <ul class="footer-contact">
        <li><?= icon('geo-alt-fill') ?><a href="<?= e(map_link_url()) ?>" target="_blank" rel="noopener"><?= e(full_address()) ?></a></li>
        <li><?= icon('telephone-fill') ?><a href="<?= e(tel_url()) ?>"><?= e(config('phone')) ?></a></li>
        <li><?= icon('whatsapp') ?><a href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener">Chat on WhatsApp</a></li>
        <li><?= icon('envelope-fill') ?><a href="<?= e(mailto_url()) ?>"><?= e(config('email')) ?></a></li>
        <li><?= icon('clock-fill') ?><span><?= e(config('hours')) ?></span></li>
      </ul>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container">
      <p class="mb-0">© <?= date('Y') ?> <?= e(config('legal_name')) ?>. All rights reserved.<?php if (config('gst_number')): ?> · GSTIN: <?= e(config('gst_number')) ?><?php endif; ?></p>
      <nav aria-label="Legal">
        <a href="<?= e(url('privacy-policy')) ?>">Privacy Policy</a>
        <a href="<?= e(url('terms-and-conditions')) ?>">Terms &amp; Conditions</a>
        <a href="<?= e(url('sitemap.xml')) ?>">Sitemap</a>
      </nav>
    </div>
  </div>
</footer>

<a class="wa-float" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener" aria-label="Chat with us on WhatsApp">
  <?= icon('whatsapp') ?><span class="wa-tip">Chat with us</span>
</a>
<button class="to-top" type="button" aria-label="Back to top"><?= icon('arrow-up') ?></button>

<script src="<?= e(asset('js/main.js')) ?>" defer></script>
</body>
</html>

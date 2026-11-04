<?php defined('APP_ROOT') || exit; ?>
<section class="status-page">
  <div class="container">
    <div class="big-404">404</div>
    <h1>Page not found</h1>
    <p>Sorry, the page you are looking for doesn’t exist or may have moved. Try one of these instead:</p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="<?= e(url()) ?>"><?= icon('house') ?> Home</a>
      <a class="btn btn-outline" href="<?= e(url('services')) ?>">Our Services</a>
      <a class="btn btn-outline" href="<?= e(url('temple-solutions')) ?>">Temple Solutions</a>
      <a class="btn btn-outline" href="<?= e(url('contact')) ?>">Contact Us</a>
    </div>
  </div>
</section>

<?php
/** Call-to-action band. Vars (optional): $title, $text, $primary [label, path], $variant */
defined('APP_ROOT') || exit;
$title   = $title ?? 'Ready to grow your business digitally?';
$text    = $text ?? 'Tell us what you need. We’ll reply within 24 working hours with ideas, a timeline and a clear quote.';
$primary = $primary ?? ['Get a Free Quote', 'get-a-quote'];
?>
<section class="section-sm">
  <div class="container">
    <div class="cta-band reveal">
      <div class="cta-inner">
        <div>
          <h2><?= e($title) ?></h2>
          <p><?= e($text) ?></p>
        </div>
        <div class="cta-actions">
          <a class="btn btn-light btn-lg" href="<?= e(url($primary[1])) ?>"><?= icon('send') ?> <?= e($primary[0]) ?></a>
          <a class="btn btn-whatsapp btn-lg" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener"><?= icon('whatsapp') ?> WhatsApp Us</a>
        </div>
      </div>
    </div>
  </div>
</section>

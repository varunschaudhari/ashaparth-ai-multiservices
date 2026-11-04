<?php
defined('APP_ROOT') || exit;
$messages = [
    'contact' => ['Thank you for your message!', 'We have received your enquiry and will get back to you within 24 working hours. A confirmation has been sent to your email.'],
    'quote'   => ['Your quote request is on its way!', 'Thank you for sharing your project details. Our team will review them and contact you within 24 working hours with ideas and a clear quote.'],
    'career'  => ['Application received!', 'Thank you for your interest in joining AshaParth AI. We will review your profile and contact you if there is a suitable opportunity.'],
    'temple'  => ['Temple registration received!', 'Thank you for joining the digital temple movement. Our team will call you within 24 working hours to discuss the next steps for your temple.'],
];
$type = is_string($_GET['type'] ?? null) && isset($messages[$_GET['type']]) ? $_GET['type'] : 'contact';
[$title, $text] = $messages[$type];
?>
<section class="status-page">
  <div class="container">
    <div class="status-icon success"><?= icon('check-lg') ?></div>
    <h1><?= e($title) ?></h1>
    <p><?= e($text) ?></p>
    <p style="font-size:.98rem">Need to talk sooner? Call <a href="<?= e(tel_url()) ?>"><strong><?= e(config('phone')) ?></strong></a> or message us on WhatsApp.</p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="<?= e(url()) ?>"><?= icon('house') ?> Back to Home</a>
      <a class="btn btn-whatsapp" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener"><?= icon('whatsapp') ?> WhatsApp Us</a>
      <a class="btn btn-outline" href="<?= e(url($type === 'temple' ? 'temple-solutions' : 'portfolio')) ?>"><?= $type === 'temple' ? 'Temple Solutions' : 'See Our Work' ?> <?= icon('arrow-right') ?></a>
    </div>
  </div>
</section>

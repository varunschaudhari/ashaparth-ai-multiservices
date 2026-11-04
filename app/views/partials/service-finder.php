<?php
/** Plain-language chooser: visitors pick what they want, not a technical service name. */
defined('APP_ROOT') || exit;

$goals = [
    ['window-stack', 'I need a website for my business', url('services/website-development'), false],
    ['person-vcard', 'I want a resume website for my job search', url('services/resume-website'), false],
    ['phone', 'I have an idea for a mobile app', url('services/mobile-app-development'), false],
    ['graph-up-arrow', 'I want more customers from Google', url('services/seo'), false],
    ['megaphone', 'I want to grow on Instagram and Facebook', url('services/social-media-marketing'), false],
    ['bullseye', 'I want enquiries quickly through ads', url('services/paid-ads'), false],
    ['palette', 'I need a logo, poster or visiting card', url('services/graphic-design-branding'), false],
    ['robot', 'I want to automate replies and routine work', url('services/ai-automation'), false],
    ['boxes', 'I need software for my office or shop', url('services/custom-software'), false],
    ['bank', 'I manage a temple or trust', url('temple-solutions'), false],
    ['clipboard-check', 'I want a price for my project', url('get-a-quote'), false],
    ['whatsapp', 'I am not sure what I need', whatsapp_url('Hello AshaParth AI, I am not sure which service I need. Can you help me?'), true],
];
?>
<section class="section-sm">
  <div class="container">
    <div class="section-head center" style="margin-bottom:32px">
      <span class="eyebrow">Find the right service</span>
      <h2>What do you want to do?</h2>
      <p>Choose the option closest to what you need.</p>
    </div>
    <div class="finder-grid">
      <?php foreach ($goals as [$ic, $label, $href, $external]): ?>
        <a class="finder-link" href="<?= e($href) ?>"<?= $external ? ' target="_blank" rel="noopener"' : '' ?>>
          <span class="icon-box sm"><?= icon($ic) ?></span>
          <span class="finder-text"><?= e($label) ?></span>
          <?= icon('arrow-right') ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php
defined('APP_ROOT') || exit;
partial('page-hero', [
    'title'   => 'Contact Us',
    'text'    => 'Have a question or a project in mind? Call, WhatsApp, email or visit us. We reply within 24 working hours.',
    'crumbs'  => [['Contact', 'contact']],
    'eyebrow' => 'Get in touch',
    'icon'    => 'chat-dots',
]);
?>

<section class="section">
  <div class="container split split-top">
    <div class="contact-cards reveal">
      <div class="card contact-card">
        <div class="icon-box sm"><?= icon('telephone-fill') ?></div>
        <div><h3>Call us</h3><a href="<?= e(tel_url()) ?>"><?= e(config('phone')) ?></a><p><?= e(config('hours')) ?></p></div>
      </div>
      <div class="card contact-card">
        <div class="icon-box sm" style="background:#e8f8ee;color:#15803d"><?= icon('whatsapp') ?></div>
        <div><h3>WhatsApp</h3><a href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener">Chat with us on WhatsApp</a><p>Quick replies during working hours</p></div>
      </div>
      <div class="card contact-card">
        <div class="icon-box sm maroon"><?= icon('envelope-fill') ?></div>
        <div><h3>Email</h3><a href="<?= e(mailto_url()) ?>"><?= e(config('email')) ?></a><p>For proposals, documents and detailed queries</p></div>
      </div>
      <div class="card contact-card">
        <div class="icon-box sm gold"><?= icon('geo-alt-fill') ?></div>
        <div><h3>Visit our office</h3><p><?= e(full_address(true)) ?></p><a href="<?= e(map_link_url()) ?>" target="_blank" rel="noopener">Get directions <?= icon('arrow-up-right') ?></a></div>
      </div>
      <?php if (social_links()): ?>
      <div class="card contact-card">
        <div class="icon-box sm"><?= icon('share-fill') ?></div>
        <div>
          <h3>Follow us</h3>
          <div class="chips" style="margin-top:8px">
            <?php foreach (social_links() as $s): ?>
              <a class="chip" href="<?= e($s['href']) ?>" target="_blank" rel="noopener"><?= icon($s['icon']) ?> <?= e($s['label']) ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>

    <div class="form-card reveal reveal-d2" id="enquiry">
      <h2>Send us a message</h2>
      <p class="form-intro">Planning a bigger project? Use our <a href="<?= e(url('get-a-quote')) ?>">detailed quote form</a> instead.</p>
      <?php partial('form-alert'); ?>
      <form method="post" action="<?= e(url('contact')) ?>#enquiry" data-enhance>
        <?= form_guard_fields() ?>
        <div class="form-grid">
          <?= input_field('name', 'Your name', ['required' => true, 'autocomplete' => 'name']) ?>
          <?= input_field('phone', 'Phone / WhatsApp', ['type' => 'tel', 'required' => true, 'autocomplete' => 'tel', 'placeholder' => '+91', 'maxlength' => 20]) ?>
          <?= input_field('email', 'Email', ['type' => 'email', 'required' => true, 'autocomplete' => 'email', 'full' => true]) ?>
          <?= select_field('subject', 'What can we help you with?', contact_subjects(), ['required' => true, 'full' => true]) ?>
          <?= textarea_field('message', 'Message', ['required' => true, 'rows' => 5, 'placeholder' => 'Tell us a little about what you need…']) ?>
        </div>
        <div class="form-footer">
          <p class="form-privacy"><?= icon('shield-lock-fill') ?> We never sell your details. See our <a href="<?= e(url('privacy-policy')) ?>">privacy policy</a>.</p>
          <button class="btn btn-primary btn-lg" type="submit"><?= icon('send') ?> Send Message</button>
        </div>
      </form>
    </div>
  </div>
</section>

<section class="section-sm" style="padding-top:0">
  <div class="container">
    <div class="map-embed reveal">
      <iframe src="<?= e(map_embed_url()) ?>" title="Map showing <?= e(config('name')) ?>, <?= e(full_address()) ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </div>
  </div>
</section>

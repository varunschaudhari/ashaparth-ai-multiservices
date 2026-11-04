<?php
defined('APP_ROOT') || exit;

// Pre-select a service when linked as /get-a-quote?service=Website%20Development
$preset = [];
if (!empty($_GET['service']) && is_string($_GET['service']) && in_array($_GET['service'], quote_services(), true)) {
    $preset = [$_GET['service']];
}

partial('page-hero', [
    'title'   => 'Get a Free Quote',
    'text'    => 'Tell us about your project. We will study your requirements and reply within 24 working hours with ideas, a timeline and a clear, no-obligation quote.',
    'crumbs'  => [['Get a Quote', 'get-a-quote']],
    'eyebrow' => 'Start your project',
    'icon'    => 'clipboard-check',
]);
?>

<section class="section">
  <div class="container split split-top split-wide">
    <div class="form-card reveal" id="quote-form">
      <?php partial('form-alert'); ?>
      <form method="post" action="<?= e(url('get-a-quote')) ?>#quote-form" enctype="multipart/form-data" data-enhance>
        <?= form_guard_fields() ?>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= (int) config('forms.max_upload_mb', 5) * 1048576 ?>">
        <div class="form-grid">
          <div class="form-section-title">About you</div>
          <?= input_field('name', 'Your name', ['required' => true, 'autocomplete' => 'name']) ?>
          <?= input_field('company', 'Company / organisation', ['hint' => '(optional)', 'autocomplete' => 'organization']) ?>
          <?= input_field('email', 'Email', ['type' => 'email', 'required' => true, 'autocomplete' => 'email']) ?>
          <?= input_field('phone', 'Phone / WhatsApp', ['type' => 'tel', 'required' => true, 'autocomplete' => 'tel', 'placeholder' => '+91 or your country code', 'maxlength' => 20]) ?>
          <?= input_field('country', 'Country / city', ['required' => true, 'full' => true, 'placeholder' => 'e.g. Pune, India or Dubai, UAE']) ?>

          <div class="form-section-title">Your project</div>
          <?= checkbox_group('services', 'Which services do you need?', quote_services(), ['required' => true, 'checked' => $preset]) ?>
          <?= select_field('budget', 'Estimated budget', budget_options(), ['required' => true, 'placeholder' => 'Select a range (INR or USD)…']) ?>
          <?= select_field('timeline', 'When do you want to start?', timeline_options(), ['required' => true]) ?>
          <?= textarea_field('details', 'Project details', ['required' => true, 'rows' => 6, 'maxlength' => 5000, 'placeholder' => 'Describe your business, goals, features you need, websites you like, and anything else that helps us understand the project.']) ?>
          <?= file_field('attachment', 'Attach a brief or reference file', '.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png', 'PDF, Word, Excel, PowerPoint, JPG or PNG') ?>

          <div class="form-section-title">A little more</div>
          <?= radio_group('contact_method', 'Preferred way to contact you', contact_methods(), ['default' => 'WhatsApp']) ?>
          <?= select_field('referral', 'How did you hear about us?', referral_sources(), ['hint' => '(optional)']) ?>
        </div>
        <div class="form-footer">
          <p class="form-privacy"><?= icon('shield-lock-fill') ?> Your project details are kept confidential. See our <a href="<?= e(url('privacy-policy')) ?>">privacy policy</a>.</p>
          <button class="btn btn-primary btn-lg" type="submit"><?= icon('send') ?> Request Free Quote</button>
        </div>
      </form>
    </div>

    <aside class="reveal reveal-d2 sticky-aside">
      <div class="card">
        <h3><?= icon('stars') ?> What happens next?</h3>
        <ol style="padding-left:1.1em;margin:0;display:grid;gap:10px;font-size:.95rem">
          <li>We review your requirements, usually the same day.</li>
          <li>We call or message you to clarify details.</li>
          <li>You receive a written proposal with scope, timeline and cost.</li>
          <li>Once approved, we start, with regular updates.</li>
        </ol>
      </div>
      <div class="card" style="background:var(--bg-soft)">
        <h3>Prefer to talk?</h3>
        <p style="font-size:.95rem">Call or WhatsApp us, <?= e(config('hours_short')) ?>.</p>
        <div style="display:grid;gap:10px">
          <a class="btn btn-primary btn-block" href="<?= e(tel_url()) ?>"><?= icon('telephone') ?> <?= e(config('phone')) ?></a>
          <a class="btn btn-whatsapp btn-block" href="<?= e(whatsapp_url()) ?>" target="_blank" rel="noopener"><?= icon('whatsapp') ?> WhatsApp Us</a>
        </div>
      </div>
      <div class="card">
        <h3 style="font-size:1rem"><?= icon('globe2') ?> Clients outside India</h3>
        <p class="mb-0" style="font-size:.93rem">We work with international clients remotely, with quotes in USD and communication over email, WhatsApp or video calls.</p>
      </div>
    </aside>
  </div>
</section>

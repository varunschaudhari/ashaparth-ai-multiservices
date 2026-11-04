<?php
defined('APP_ROOT') || exit;
$delays = ['', 'reveal-d1', 'reveal-d2', 'reveal-d3'];

partial('page-hero', [
    'title'   => 'Maharashtra Devasthan Live',
    'text'    => 'Connecting all temples of Maharashtra digitally. Live darshan, temple information and online services that bring devotees closer to their temples, wherever they are.',
    'crumbs'  => [['Temples', 'temple-solutions'], ['Devasthan Live', 'devasthan-live']],
    'eyebrow' => 'An initiative by AshaParth AI Multiservices',
    'image'   => 'img/temple-mark.svg',
    'variant' => 'temple',
    'actions' => '<a class="btn btn-primary" href="#register">' . icon('pencil-square') . ' Register Your Temple</a>'
               . '<a class="btn btn-outline" href="' . e(tel_url()) . '">' . icon('telephone') . ' ' . e(config('phone')) . '</a>',
]);

$subtitles = [
    'Our Vision'           => 'A digital home for every temple',
    'Our Services'         => 'What the platform offers temples',
    'Benefits for Temples' => 'Why temples are joining',
    'Key Features'         => 'Built for devotees and trustees',
];

$blocks = [
    'Our Vision' => [
        ['broadcast', 'Live Darshan', 'Daily darshan from every temple, available to devotees anywhere.'],
        ['grid', 'Online Services', 'Donations, pooja bookings and seva requests online.'],
        ['info-circle', 'Temple Information', 'History, timings, festivals and directions in one place.'],
        ['globe-americas', 'Global Devotee Reach', 'Devotees across India and abroad connected to their temples.'],
    ],
    'Our Services' => [
        ['camera-video', '24x7 Live Streaming', 'HD live darshan, daily aarti and festival coverage.'],
        ['share', 'Social Media Integration', 'YouTube, Facebook and Instagram, connected and managed.'],
        ['heart', 'Online Donations', 'Secure, transparent giving with instant digital receipts.'],
        ['megaphone', 'Event Promotions', 'Festivals and utsavs promoted to a wider audience.'],
    ],
    'Benefits for Temples' => [
        ['people', 'Increase Devotee Reach', 'Stay connected with devotees who cannot visit often.'],
        ['eye', 'Enhance Visibility', 'Your temple discovered by new devotees online.'],
        ['graph-up-arrow', 'Boost Donations', 'Make it easy for devotees anywhere to contribute.'],
        ['calendar-event', 'Promote Events', 'More participation in festivals and special poojas.'],
    ],
    'Key Features' => [
        ['phone', 'Mobile App Access', 'Devotees follow their favourite temples from their phones.'],
        ['search', 'Easy Search by District', 'Find temples across all districts of Maharashtra.'],
        ['bell', 'Real-time Notifications', 'Alerts for live aarti, festivals and announcements.'],
        ['shield-check', 'Secure & Reliable', 'Trusted platforms, secure payments and dependable streaming.'],
    ],
];
?>

<!-- ── Invitation ────────────────────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="invite reveal">
      <div class="ornament"><?= icon('flower1') ?></div>
      <h2>An invitation to Temple Trustees &amp; Committees</h2>
      <p class="lead">Maharashtra is home to thousands of temples, each with its own devotees, traditions and festivals. Maharashtra Devasthan Live brings these temples online so that devotees everywhere can take darshan, stay informed and offer seva. We invite every temple trust and committee to join this digital temple movement.</p>
    </div>
  </div>
</section>

<?php $i = 0; foreach ($blocks as $heading => $items): ?>
<section class="section-sm<?= $i++ % 2 === 0 ? ' section-soft' : '' ?>">
  <div class="container">
    <div class="section-head center" style="margin-bottom:36px">
      <span class="eyebrow"><?= e($heading) ?></span>
      <h2 class="mb-0"><?= e($subtitles[$heading]) ?></h2>
    </div>
    <div class="vision-grid">
      <?php foreach ($items as $k => [$ic, $t, $d]): ?>
        <div class="card vision-item card-hover reveal <?= $delays[$k] ?>">
          <div class="icon-box<?= $k % 2 ? ' maroon' : ' gold' ?>"><?= icon($ic) ?></div>
          <h3><?= e($t) ?></h3>
          <p><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<!-- ── How to join + form ───────────────────────────────────────────── -->
<section class="section" id="register">
  <div class="container split split-top">
    <div class="reveal">
      <span class="eyebrow">Join in 3 simple steps</span>
      <h2>Register your temple</h2>
      <p class="lead">Fill in the form and our team will contact you within 24 working hours.</p>
      <div style="display:grid;gap:22px;margin:30px 0">
        <?php foreach ([
            ['pencil-square', '1. Register', 'Share your temple’s details and the services you are interested in.'],
            ['telephone', '2. Consultation & visit', 'We call you, understand your needs and plan a site visit.'],
            ['broadcast', '3. Go live', 'We set everything up and connect your temple with devotees worldwide.'],
        ] as [$ic, $t, $d]): ?>
          <div class="feature">
            <div class="icon-box sm gold"><?= icon($ic) ?></div>
            <div><h3><?= e($t) ?></h3><p><?= e($d) ?></p></div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="card" style="background:var(--gold-50);border-color:#efdcb3">
        <h3 style="margin-bottom:6px">Prefer to talk?</h3>
        <p style="margin-bottom:14px">Call or WhatsApp us directly. We are happy to explain everything.</p>
        <div class="cta-actions">
          <a class="btn btn-primary btn-sm" href="<?= e(tel_url()) ?>"><?= icon('telephone') ?> <?= e(config('phone')) ?></a>
          <a class="btn btn-whatsapp btn-sm" href="<?= e(whatsapp_url('Namaste, I would like to register our temple with Maharashtra Devasthan Live.')) ?>" target="_blank" rel="noopener"><?= icon('whatsapp') ?> WhatsApp</a>
        </div>
      </div>
    </div>

    <div class="form-card reveal reveal-d2">
      <h2>Temple registration</h2>
      <p class="form-intro">Fields marked <span style="color:var(--danger)">*</span> are required.</p>
      <?php partial('form-alert'); ?>
      <form method="post" action="<?= e(url('devasthan-live')) ?>#register" data-enhance>
        <?= form_guard_fields() ?>
        <div class="form-grid">
          <div class="form-section-title">Temple details</div>
          <?= input_field('temple_name', 'Temple name', ['required' => true, 'full' => true, 'placeholder' => 'e.g. Shri Ganesh Mandir']) ?>
          <?= input_field('deity', 'Main deity', ['placeholder' => 'e.g. Shri Ganesh']) ?>
          <?= input_field('village_city', 'Village / city', ['required' => true]) ?>
          <?= input_field('taluka', 'Taluka') ?>
          <?= select_field('district', 'District', maharashtra_districts(), ['required' => true, 'placeholder' => 'Select district…']) ?>

          <div class="form-section-title">Contact person</div>
          <?= input_field('contact_name', 'Your name', ['required' => true, 'autocomplete' => 'name']) ?>
          <?= select_field('designation', 'Designation', temple_designations(), ['required' => true]) ?>
          <?= input_field('phone', 'Mobile number', ['type' => 'tel', 'required' => true, 'autocomplete' => 'tel', 'placeholder' => '+91', 'maxlength' => 20]) ?>
          <?= input_field('email', 'Email', ['type' => 'email', 'autocomplete' => 'email', 'hint' => '(optional)']) ?>

          <div class="form-section-title">Requirements</div>
          <?= checkbox_group('services', 'Services you are interested in', temple_services(), ['required' => true, 'checked' => ['24x7 Live Darshan']]) ?>
          <?= input_field('existing_url', 'Existing YouTube / Facebook page', ['type' => 'url', 'full' => true, 'hint' => '(optional)', 'placeholder' => 'https://', 'maxlength' => 255]) ?>
          <?= textarea_field('message', 'Anything else you would like to tell us?', ['rows' => 4, 'hint' => '(optional)']) ?>
        </div>
        <div class="form-footer">
          <p class="form-privacy"><?= icon('shield-lock-fill') ?> Your details are used only to contact you about this request. See our <a href="<?= e(url('privacy-policy')) ?>">privacy policy</a>.</p>
          <button class="btn btn-primary btn-lg" type="submit"><?= icon('send') ?> Register Temple</button>
        </div>
      </form>
    </div>
  </div>
</section>

<?php partial('cta', [
    'title'   => 'Take your temple global. Go digital today!',
    'text'    => 'Explore our complete range of temple digital solutions, from live darshan to management software.',
    'primary' => ['Temple Solutions', 'temple-solutions'],
]); ?>

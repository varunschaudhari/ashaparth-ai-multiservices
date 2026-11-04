<?php
defined('APP_ROOT') || exit;
$delays    = ['', 'reveal-d1', 'reveal-d2', 'reveal-d3'];
$portfolio = data('portfolio');
$templeWork = array_filter($portfolio, fn ($p) => !$p['is_sample'] && strpos($p['client'], 'Mangal') !== false);

partial('page-hero', [
    'title'   => 'Temple Websites, Apps & Live Darshan Services',
    'text'    => 'An all-in-one digital solution for temples and trusts: 24x7 live darshan, HD camera setup, temple websites and apps, online donations, pooja booking and social media.',
    'crumbs'  => [['Temple Solutions', 'temple-solutions']],
    'eyebrow' => 'Go digital: connect your temple to the world',
    'image'   => 'img/temple-mark.svg',
    'variant' => 'temple',
    'actions' => '<a class="btn btn-primary" href="' . e(url('devasthan-live')) . '#register">' . icon('bank') . ' Register Your Temple</a>'
               . '<a class="btn btn-whatsapp" href="' . e(whatsapp_url('Namaste, I would like to know about live darshan and digital services for our temple.')) . '" target="_blank" rel="noopener">' . icon('whatsapp') . ' WhatsApp Us</a>',
]);

$services = [
    ['broadcast', '24x7 Live Darshan', 'Continuous HD live streaming of the deity on YouTube, your website and app, so devotees can take darshan any time.'],
    ['camera-reels', 'Aarti & Festival Live', 'Daily aarti, abhishek, festivals, yatras and special events streamed live with professional quality.'],
    ['camera-video', 'HD Camera Setup', 'Professional cameras, mounts, streaming hardware and internet setup, installed respectfully with the trust’s approval.'],
    ['globe2', 'Temple Website', 'History, deity information, timings, events, gallery, live darshan, donations and contact, all in one place.'],
    ['phone', 'Temple Mobile App', 'Live darshan, event notifications, aarti timings and donations, right on devotees’ phones.'],
    ['heart', 'Online Donations', 'Secure UPI, card and net-banking donations through trusted payment gateways, with instant digital receipts.'],
    ['calendar-check', 'Pooja & Abhishek Booking', 'Devotees book poojas, abhisheks and sevas online, choosing date, batch and hall, and pay securely.'],
    ['boxes', 'Temple Management Software', 'Stock, purchases, donations, bookings, assets, staff and WhatsApp messages managed from one app.'],
    ['share', 'Social Media Management', 'Regular posts, reels and live updates on YouTube, Facebook and Instagram to grow your devotee community.'],
    ['megaphone', 'Event Promotion', 'Festival and event campaigns with posters, videos and targeted promotion to reach devotees far and wide.'],
    ['hdd-network', 'Hosting & Maintenance', 'Reliable hosting, domain, backups, security updates and stream monitoring, so everything keeps running smoothly.'],
];
?>

<!-- ── Why go digital ────────────────────────────────────────────────── -->
<section class="section">
  <div class="container split">
    <div class="reveal">
      <span class="eyebrow">Why go digital?</span>
      <h2>Devotees are everywhere. Your temple can be too.</h2>
      <p class="lead">Many devotees now live in other cities and countries, yet remain deeply connected to their temple. Going digital lets your temple stay part of their daily lives, and helps the temple grow.</p>
      <ul class="check-list">
        <li>Reach devotees worldwide</li>
        <li>Provide live darshan anytime, from anywhere</li>
        <li>Promote temple activities, festivals and events</li>
        <li>Make donations and seva bookings simple and transparent</li>
      </ul>
    </div>
    <div class="grid grid-2 reveal reveal-d2">
      <?php foreach ([
          ['people', 'Increase Devotee Reach', 'Connect with devotees across India and abroad.'],
          ['eye', 'Enhance Visibility', 'Make your temple famous on social media and Google.'],
          ['heart', 'Boost Donations', 'Easy, secure online giving from anywhere.'],
          ['calendar-event', 'Promote Events', 'Festivals and utsavs reach thousands more people.'],
      ] as $k => [$ic, $t, $d]): ?>
        <div class="card feature-card">
          <div class="icon-box<?= $k % 3 ? ' maroon' : ' gold' ?>"><?= icon($ic) ?></div>
          <h3><?= e($t) ?></h3>
          <p><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Services ──────────────────────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">We provide</span>
      <h2>Everything your temple needs to go digital</h2>
      <p>Choose individual services or the complete package. We handle setup, management and support.</p>
    </div>
    <div class="grid grid-3">
      <?php foreach ($services as $k => [$ic, $t, $d]): ?>
        <div class="card feature-card card-hover reveal <?= $delays[$k % 3] ?>">
          <div class="icon-box<?= $k % 2 ? ' maroon' : '' ?>"><?= icon($ic) ?></div>
          <h3><?= e($t) ?></h3>
          <p><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
        <div class="card feature-card reveal" style="background:var(--maroon);border-color:var(--maroon)">
          <div class="icon-box" style="background:rgba(255,255,255,.14);color:var(--gold-light)"><?= icon('chat-heart') ?></div>
          <h3 style="color:#fff">Not sure where to start?</h3>
          <p style="color:rgba(255,255,255,.85);margin-bottom:16px">Tell us about your temple and we will recommend the right package.</p>
          <a class="btn btn-light btn-sm" href="<?= e(url('devasthan-live')) ?>#register">Talk to us <?= icon('arrow-right') ?></a>
        </div>
    </div>
  </div>
</section>

<!-- ── Live darshan focus ───────────────────────────────────────────── -->
<section class="section">
  <div class="container split">
    <div class="media-panel reveal">
      <h3><?= icon('broadcast') ?> 24x7 Live Temple Darshan Service</h3>
      <p>We take care of everything from camera installation to streaming, so the temple simply goes live.</p>
      <a class="btn btn-light btn-sm" href="<?= e(url('live-darshan-service')) ?>">Live darshan service details <?= icon('arrow-right') ?></a>
      <div class="mini-stats">
        <div><b>Daily Aarti</b><span>Live every day</span></div>
        <div><b>Festivals</b><span>Special live coverage</span></div>
        <div><b>HD Cameras</b><span>Professional setup</span></div>
        <div><b>Mobile App</b><span>Darshan on the go</span></div>
      </div>
    </div>
    <div class="reveal reveal-d2">
      <span class="eyebrow">How it works</span>
      <h2>From site visit to live in a few simple steps</h2>
      <div style="display:grid;gap:22px;margin-top:26px">
        <?php foreach ([
            ['geo-alt', 'Site visit & survey', 'We visit the temple, meet the trustees and plan camera positions, internet and power.'],
            ['tools', 'Installation & setup', 'Cameras, streaming equipment and the temple’s YouTube channel are set up and tested.'],
            ['broadcast', 'Go live', 'Darshan streams live on YouTube, the temple website and app, on schedule or 24x7.'],
            ['graph-up-arrow', 'Manage & grow', 'We monitor streams, manage social media and promote festivals to grow your audience.'],
        ] as [$ic, $t, $d]): ?>
          <div class="feature">
            <div class="icon-box sm"><?= icon($ic) ?></div>
            <div><h3><?= e($t) ?></h3><p><?= e($d) ?></p></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ── Our temple work ──────────────────────────────────────────────── -->
<?php if ($templeWork): ?>
<section class="section section-soft">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Our work</span>
      <h2>Trusted by Shri Mangal Grah Mandir, Amalner</h2>
      <p>Website, live darshan, social media and a complete management app for one of Maharashtra’s best-known temples.</p>
    </div>
    <div class="grid grid-3">
      <?php $k = 0; foreach ($templeWork as $slug => $p): partial('project-card', ['slug' => $slug, 'p' => $p, 'delay' => $delays[$k++ % 3]]); endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── FAQ ───────────────────────────────────────────────────────────── -->
<section class="section">
  <div class="container container-narrow">
    <div class="section-head center">
      <span class="eyebrow">FAQ</span>
      <h2>Questions from temple trustees</h2>
    </div>
    <?php partial('faq', ['items' => [
        ['Will live streaming disturb the temple’s rituals?', 'No. Cameras are placed discreetly and respectfully, at positions approved by the trustees and priests, and we never interfere with rituals or devotees.'],
        ['What internet connection does the temple need?', 'A stable broadband connection is ideal; a reliable 4G/5G router can also work. We check connectivity during the site visit and recommend the best option.'],
        ['Who owns the YouTube channel and receives the donations?', 'The temple does. The channel is created in the temple’s name, and online donations go directly to the temple trust’s bank account through the payment gateway.'],
        ['Can the temple website and app be in Marathi?', 'Yes. Temple websites and apps can be built in Marathi, Hindi and English so every devotee is comfortable.'],
        ['Do you work with temples outside Jalgaon district?', 'Yes. We work with temples across Maharashtra and beyond. Register your temple and our team will contact you.'],
        ['Can we start with just live darshan?', 'Absolutely. Many temples start with live darshan and add a website, donations or an app later.'],
    ]]); ?>
  </div>
</section>

<?php partial('cta', [
    'title'   => 'Join the Digital Temple Movement',
    'text'    => 'Register your temple with Maharashtra Devasthan Live and our team will contact you to plan the next steps.',
    'primary' => ['Register Your Temple', 'devasthan-live#register'],
]); ?>

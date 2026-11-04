<?php
defined('APP_ROOT') || exit;
$delays = ['', 'reveal-d1', 'reveal-d2', 'reveal-d3'];
partial('page-hero', [
    'title'   => 'About AshaParth AI Multiservices',
    'text'    => 'A digital agency from Amalner, Jalgaon, helping businesses and temples use technology to reach more people, work smarter and grow.',
    'crumbs'  => [['About Us', 'about']],
    'eyebrow' => 'Who we are',
    'icon'    => 'people',
]);
?>

<!-- ── Story ─────────────────────────────────────────────────────────── -->
<section class="section">
  <div class="container split">
    <div class="reveal">
      <span class="eyebrow">Our story</span>
      <h2>Technology with a personal touch</h2>
      <p class="lead">AshaParth AI Multiservices was founded by Ashish Chaudhari, Vishakha Chaudhari and Priya Chaudhari with a simple belief: every business and every temple, whatever its size or location, deserves technology that truly works for it.</p>
      <p>From our base in Amalner, Jalgaon district, we saw how many local businesses, institutions and temples were missing out on the opportunities of the digital world, not because they did not want to grow, but because they lacked a trusted partner who could explain things simply and deliver reliably.</p>
      <p>Today we offer a complete range of services: websites, resume websites, mobile apps, AI and automation, custom software, SEO, social media, paid advertising and branding. Through our temple solutions and the <a href="<?= e(url('devasthan-live')) ?>">Maharashtra Devasthan Live</a> initiative, we also help temples connect with devotees around the world through live darshan, websites, apps and online donations.</p>
    </div>
    <div class="media-panel reveal reveal-d2">
      <h3>What “multiservices” means for you</h3>
      <p>Instead of managing separate vendors for your website, app, marketing and design, you get one accountable team that understands your entire digital presence.</p>
      <ul class="check-list" style="margin-top:20px">
        <li style="color:#fff">One point of contact for every project</li>
        <li style="color:#fff">Consistent branding across web, app and social</li>
        <li style="color:#fff">Faster delivery, simpler billing</li>
        <li style="color:#fff">Long-term support as you grow</li>
      </ul>
    </div>
  </div>
</section>

<!-- ── Mission / Vision / Values ─────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container">
    <div class="grid grid-3">
      <div class="card reveal">
        <div class="icon-box"><?= icon('bullseye') ?></div>
        <h3>Our Mission</h3>
        <p class="mb-0">To make modern technology simple, affordable and effective for businesses, institutions and temples, so they can serve more people and grow with confidence.</p>
      </div>
      <div class="card reveal reveal-d1">
        <div class="icon-box maroon"><?= icon('eye') ?></div>
        <h3>Our Vision</h3>
        <p class="mb-0">To be the most trusted digital partner from Maharashtra, known for honest advice, quality work and for connecting every temple of Maharashtra digitally.</p>
      </div>
      <div class="card reveal reveal-d2">
        <div class="icon-box gold"><?= icon('gem') ?></div>
        <h3>Our Values</h3>
        <ul class="check-list gold mb-0">
          <li>Honesty &amp; transparency</li>
          <li>Quality in every detail</li>
          <li>Respect for culture &amp; tradition</li>
          <li>Long-term relationships</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ── Founders ──────────────────────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Leadership</span>
      <h2>Meet our founders</h2>
      <p>The people behind AshaParth AI, personally involved in every client relationship.</p>
    </div>
    <div class="grid grid-3">
      <?php foreach (config('founders', []) as $k => $f): ?>
        <article class="card team-card reveal <?= $delays[$k % 4] ?>">
          <div class="team-photo">
            <?php if (!empty($f['photo']) && is_file(APP_ROOT . '/' . $f['photo'])): ?>
              <img src="<?= e(url($f['photo'])) ?>" alt="<?= e($f['name']) ?>" width="132" height="132">
            <?php else: ?>
              <span class="avatar" aria-hidden="true"><?= e(initials($f['name'])) ?></span>
            <?php endif; ?>
          </div>
          <h3><?= e($f['name']) ?></h3>
          <span class="team-role"><?= e($f['role']) ?></span>
          <p><?= e($f['bio'] !== '' ? $f['bio'] : 'Founder of AshaParth AI Multiservices, committed to helping businesses and temples grow with technology.') ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Why choose us ─────────────────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Why choose us</span>
      <h2>What makes us different</h2>
    </div>
    <div class="grid grid-3">
      <?php foreach ([
          ['person-check', 'Founder-led service', 'You speak directly with decision-makers, not a chain of account managers.'],
          ['translate', 'Local understanding', 'We understand Maharashtra’s businesses and temples, and communicate in the language you prefer.'],
          ['cpu', 'AI-first thinking', 'We look for smart ways to automate and save you time in every project.'],
          ['cash-coin', 'Fair, clear pricing', 'Written quotes, defined deliverables and no hidden costs.'],
          ['shield-check', 'Reliable delivery', 'Realistic timelines, regular updates and quality checks before launch.'],
          ['headset', 'Ongoing support', 'Maintenance, updates and help whenever you need it after launch.'],
      ] as $k => [$ic, $t, $d]): ?>
        <div class="card feature-card card-hover reveal <?= $delays[$k % 3] ?>">
          <div class="icon-box<?= $k % 2 ? ' maroon' : '' ?>"><?= icon($ic) ?></div>
          <h3><?= e($t) ?></h3>
          <p><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php partial('cta', ['title' => 'Let’s build something great together', 'text' => 'Whether you are a business, an institution or a temple trust, we’d love to hear about your plans.']); ?>

<?php
defined('APP_ROOT') || exit;
$portfolio = data('portfolio');
$featured  = array_slice(array_filter($portfolio, fn ($p) => !$p['is_sample']), 0, 3, true);
$posts     = array_slice(data('blog'), 0, 3, true);
$delays    = ['', 'reveal-d1', 'reveal-d2', 'reveal-d3'];
?>

<!-- ── Hero ─────────────────────────────────────────────────────────── -->
<section class="hero">
  <div class="container split">
    <div>
      <div class="hero-badge"><span>NEW</span> Maharashtra Devasthan Live: temples going digital</div>
      <h1>Website, app &amp; AI company in Jalgaon that helps you <span class="hl">grow</span></h1>
      <p class="hero-text">From websites and mobile apps to AI automation, custom software and digital marketing, <?= e(config('name')) ?> is your complete technology partner. Based in Amalner, Jalgaon district, and working with clients across Maharashtra, India and worldwide.</p>
      <div class="hero-actions">
        <a class="btn btn-primary btn-lg" href="<?= e(url('get-a-quote')) ?>"><?= icon('send') ?> Get a Free Quote</a>
        <a class="btn btn-outline btn-lg" href="<?= e(url('services')) ?>">Explore Services <?= icon('arrow-right') ?></a>
      </div>
      <ul class="hero-trust">
        <li><?= icon('check-circle-fill') ?> Free consultation</li>
        <li><?= icon('check-circle-fill') ?> Transparent pricing</li>
        <li><?= icon('check-circle-fill') ?> Support after launch</li>
      </ul>
    </div>

    <div class="hero-visual" aria-hidden="true">
      <div class="mock-window">
        <div class="mock-bar"><i></i><i></i><i></i><span class="mock-url">yourbusiness.com</span></div>
        <div class="mock-body">
          <div class="mock-hero"><b>Your business, online &amp; growing</b><div class="mock-line"></div><div class="mock-line w60"></div></div>
          <div class="mock-grid">
            <div class="mock-tile"><?= icon('window-stack') ?><span></span><span></span></div>
            <div class="mock-tile"><?= icon('robot') ?><span></span><span></span></div>
            <div class="mock-tile"><?= icon('graph-up-arrow') ?><span></span><span></span></div>
          </div>
          <div class="mock-chart"><i style="height:35%"></i><i style="height:50%"></i><i style="height:42%"></i><i style="height:64%"></i><i style="height:58%"></i><i style="height:78%"></i><i style="height:70%"></i><i style="height:92%"></i></div>
        </div>
      </div>
      <div class="float-card fc-1"><?= icon('whatsapp') ?><div>New enquiry<small>via WhatsApp</small></div></div>
      <div class="float-card fc-2"><?= icon('stars') ?><div>AI Assistant<small>Replying 24x7</small></div></div>
      <div class="float-card fc-3"><?= icon('broadcast') ?><div>Live Darshan<small>Streaming now</small></div></div>
    </div>
  </div>
</section>

<!-- ── Services ──────────────────────────────────────────────────────── -->
<section class="section section-soft" id="services">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">What we do</span>
      <h2>Everything you need to build and grow, under one roof</h2>
      <p>Technology to build your business and marketing to grow it, delivered by one accountable team.</p>
    </div>
    <div class="grid grid-4">
      <?php $i = 0; foreach (services() as $slug => $s): ?>
        <article class="card card-hover service-card reveal <?= $delays[$i++ % 4] ?>">
          <span class="tag-pill"><?= $s['category'] === 'build' ? 'Build' : 'Grow' ?></span>
          <div class="icon-box<?= $s['category'] === 'grow' ? ' maroon' : '' ?>"><?= icon($s['icon']) ?></div>
          <h3><a href="<?= e(url('services/' . $slug)) ?>"><?= e($s['title']) ?></a></h3>
          <p><?= e($s['short']) ?></p>
          <span class="link-arrow">Learn more <?= icon('arrow-right') ?></span>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Temple vertical ──────────────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="temple-band reveal">
      <div class="split">
        <div>
          <div class="temple-logo">
            <img src="<?= e(asset('img/temple-mark.svg')) ?>" alt="">
            <span><strong>Maharashtra Devasthan Live</strong><small>Connecting all temples of Maharashtra digitally</small></span>
          </div>
          <h2>Take your temple global. Go digital today.</h2>
          <p>We help temple trusts and committees reach devotees worldwide with 24x7 live darshan, temple websites and apps, online donations and social media, all set up and managed by one team.</p>
          <div class="hero-actions mb-0">
            <a class="btn btn-primary" href="<?= e(url('devasthan-live')) ?>"><?= icon('bank') ?> Register Your Temple</a>
            <a class="btn btn-outline" href="<?= e(url('temple-solutions')) ?>">Temple Solutions <?= icon('arrow-right') ?></a>
          </div>
        </div>
        <div class="temple-services">
          <?php foreach ([
              ['broadcast', '24x7 Live Darshan', 'live-darshan-service'],
              ['camera-video', 'HD Camera Setup'],
              ['globe2', 'Temple Websites'],
              ['phone', 'Temple Mobile Apps'],
              ['heart', 'Online Donations'],
              ['calendar-event', 'Event Promotion'],
              ['share', 'Social Media Management'],
              ['boxes', 'Temple Management Software'],
          ] as $tile): [$ic, $label] = $tile; ?>
            <?php if (isset($tile[2])): ?>
              <a class="temple-service" href="<?= e(url($tile[2])) ?>"><?= icon($ic) ?> <?= e($label) ?></a>
            <?php else: ?>
              <div class="temple-service"><?= icon($ic) ?> <?= e($label) ?></div>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── Why choose us ─────────────────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container split">
    <div>
      <span class="eyebrow">Why AshaParth AI</span>
      <h2>A technology partner who understands your business</h2>
      <p class="lead">We combine modern technology with a practical, personal approach. You work directly with the founders and a team that cares about your results.</p>
      <div class="grid grid-2" style="margin-top:32px">
        <?php foreach ([
            ['person-check', 'Personal attention', 'Direct access to the founders and one point of contact for your project.'],
            ['lightning-charge', 'Modern technology', 'AI, cloud and mobile-first development, built to current standards.'],
            ['cash-coin', 'Transparent pricing', 'Clear, written quotes with no hidden charges.'],
            ['headset', 'Support after launch', 'We stay with you for updates, fixes and growth.'],
        ] as $k => [$ic, $t, $d]): ?>
          <div class="feature reveal <?= $delays[$k] ?>">
            <div class="icon-box sm maroon"><?= icon($ic) ?></div>
            <div><h3><?= e($t) ?></h3><p><?= e($d) ?></p></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="media-panel reveal reveal-d2">
      <h3>From Amalner to the world</h3>
      <p>We started with a simple belief: every business and every temple, whatever its size or location, deserves technology that truly works for it. Today we help businesses and temples build, automate and grow, and we work with clients anywhere in India and abroad.</p>
      <div class="mini-stats">
        <div><b>8+</b><span>Digital services</span></div>
        <div><b>24x7</b><span>Live darshan streaming</span></div>
        <div><b>India + Global</b><span>Remote-friendly delivery</span></div>
        <div><b>1 team</b><span>Build, launch &amp; grow</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ── Stats ─────────────────────────────────────────────────────────── -->
<section class="stats-band" aria-label="Our numbers">
  <div class="container stats-grid">
    <?php foreach (config('stats', []) as $st): ?>
      <div class="stat reveal"><b><?= e($st['value']) ?></b><span><?= e($st['label']) ?></span></div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ── Process ───────────────────────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">How we work</span>
      <h2>A simple, proven process</h2>
      <p>Clear steps, regular updates and no surprises, from the first call to launch and beyond.</p>
    </div>
    <div class="process">
      <?php foreach ([
          ['Discover', 'We listen to your goals, audience and challenges, then suggest the right solution.'],
          ['Plan & Design', 'You get a clear proposal, timeline and designs to review before we build.'],
          ['Build & Test', 'We develop, test on all devices and share progress regularly.'],
          ['Launch & Grow', 'We go live, train your team and keep improving with support and marketing.'],
      ] as $k => [$t, $d]): ?>
        <div class="step reveal <?= $delays[$k] ?>"><div class="step-num"></div><h3><?= e($t) ?></h3><p><?= e($d) ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Portfolio ─────────────────────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Our work</span>
      <h2>Recent projects</h2>
      <p>A look at what we have built and launched for our clients.</p>
    </div>
    <div class="grid grid-3">
      <?php $k = 0; foreach ($featured as $slug => $p): partial('project-card', ['slug' => $slug, 'p' => $p, 'delay' => $delays[$k++]]); endforeach; ?>
    </div>
    <div class="text-center" style="margin-top:44px">
      <a class="btn btn-outline" href="<?= e(url('portfolio')) ?>">View full portfolio <?= icon('arrow-right') ?></a>
    </div>
  </div>
</section>

<!-- ── Technologies ──────────────────────────────────────────────────── -->
<section class="section-sm">
  <div class="container text-center">
    <span class="eyebrow">Technologies &amp; platforms</span>
    <h2 style="margin-bottom:28px">Built with tools trusted worldwide</h2>
    <div class="chips" style="justify-content:center">
      <?php foreach (config('technologies', []) as $t): ?>
        <span class="chip"><?= icon('check2') ?> <?= e($t) ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Testimonials ──────────────────────────────────────────────────── -->
<?php if (config('show_testimonials')): ?>
<section class="section section-soft">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Client stories</span>
      <h2>What our clients say</h2>
    </div>
    <div class="grid grid-3">
      <?php foreach (data('testimonials') as $k => $t): ?>
        <figure class="card testimonial reveal <?= $delays[$k % 4] ?>">
          <?php if (!empty($t['sample'])): ?><span class="badge badge-sample testimonial-flag">Sample</span><?php endif; ?>
          <?= icon('quote') ?>
          <div class="stars" aria-hidden="true">★★★★★</div>
          <blockquote><?= e($t['quote']) ?></blockquote>
          <figcaption class="testimonial-author">
            <span class="avatar"><?= e(initials($t['name'])) ?></span>
            <span><strong><?= e($t['name']) ?></strong><small><?= e($t['role']) ?></small></span>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ── Blog ──────────────────────────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Insights</span>
      <h2>From our blog</h2>
      <p>Practical tips on websites, AI, marketing and temple digitisation.</p>
    </div>
    <div class="grid grid-3">
      <?php $k = 0; foreach ($posts as $slug => $post): partial('post-card', ['slug' => $slug, 'post' => $post, 'delay' => $delays[$k++]]); endforeach; ?>
    </div>
  </div>
</section>

<?php partial('cta'); ?>

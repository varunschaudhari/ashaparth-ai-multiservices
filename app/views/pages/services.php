<?php
defined('APP_ROOT') || exit;
$delays = ['', 'reveal-d1', 'reveal-d2', 'reveal-d3'];
partial('page-hero', [
    'title'   => 'Our Services',
    'text'    => 'Technology to build your business and marketing to grow it, delivered by one accountable team.',
    'crumbs'  => [['Services', 'services']],
    'eyebrow' => 'What we do',
    'icon'    => 'grid-1x2',
    'actions' => '<a class="btn btn-primary" href="' . e(url('get-a-quote')) . '">' . icon('send') . ' Get a Free Quote</a>',
]);

$groups = [
    'build' => ['Build', 'Technology services', 'Websites, apps, AI and software that form the foundation of your digital business.'],
    'grow'  => ['Grow', 'Marketing & creative services', 'Reach the right audience, build your brand and generate consistent leads.'],
];
?>

<?php foreach ($groups as $cat => [$eyebrow, $title, $text]): ?>
<section class="section<?= $cat === 'grow' ? ' section-soft' : '' ?>">
  <div class="container">
    <div class="section-head left">
      <span class="eyebrow"><?= e($eyebrow) ?></span>
      <h2><?= e($title) ?></h2>
      <p><?= e($text) ?></p>
    </div>
    <div class="grid grid-2">
      <?php $k = 0; foreach (services($cat) as $slug => $s): ?>
        <article class="card card-hover service-card reveal <?= $delays[$k++ % 2] ?>">
          <div class="feature">
            <div class="icon-box<?= $cat === 'grow' ? ' maroon' : '' ?>" style="margin:0"><?= icon($s['icon']) ?></div>
            <div>
              <h3><a href="<?= e(url('services/' . $slug)) ?>"><?= e($s['title']) ?></a></h3>
              <p><?= e($s['short']) ?></p>
              <ul class="check-list two-col" style="font-size:.9rem">
                <?php foreach (array_slice($s['offerings'], 0, 4) as $o): ?><li><?= e($o) ?></li><?php endforeach; ?>
              </ul>
              <span class="link-arrow">Explore <?= e($s['title']) ?> <?= icon('arrow-right') ?></span>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<!-- ── Temple vertical ──────────────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="temple-band reveal">
      <div class="split">
        <div>
          <div class="temple-logo">
            <img src="<?= e(asset('img/temple-mark.svg')) ?>" alt="">
            <span><strong>Industry focus: Temples &amp; Trusts</strong><small>All-in-one temple digital solution</small></span>
          </div>
          <h2>Temple Digital Solutions</h2>
          <p>Live darshan, HD camera setup, temple websites and apps, online donations, pooja booking, management software and social media, tailored for temples and religious trusts.</p>
          <div class="hero-actions mb-0">
            <a class="btn btn-primary" href="<?= e(url('temple-solutions')) ?>">Explore Temple Solutions <?= icon('arrow-right') ?></a>
          </div>
        </div>
        <ul class="check-list gold two-col mb-0">
          <?php foreach (temple_services() as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<?php partial('cta'); ?>

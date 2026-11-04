<?php
defined('APP_ROOT') || exit;
/** @var array $service  @var string $slug */
$s      = $service;
$delays = ['', 'reveal-d1', 'reveal-d2', 'reveal-d3'];
$others = array_filter(services(), fn ($k) => $k !== $slug, ARRAY_FILTER_USE_KEY);
uasort($others, fn ($a, $b) => ($b['category'] === $s['category']) <=> ($a['category'] === $s['category']));
$related = !empty($s['related_post']) ? (data('blog')[$s['related_post']] ?? null) : null;

partial('page-hero', [
    'title'   => $s['h1'] ?? $s['title'],
    'text'    => $s['headline'],
    'crumbs'  => [['Services', 'services'], [$s['title'], 'services/' . $slug]],
    'eyebrow' => $s['category'] === 'build' ? 'Technology service' : 'Marketing & creative service',
    'icon'    => $s['icon'],
    'actions' => '<a class="btn btn-primary" href="' . e(url('get-a-quote?service=' . rawurlencode($s['title']))) . '">' . icon('send') . ' Get a Free Quote</a>'
               . '<a class="btn btn-whatsapp" href="' . e(whatsapp_url('Hello AshaParth AI, I am interested in ' . $s['title'] . '.')) . '" target="_blank" rel="noopener">' . icon('whatsapp') . ' Discuss on WhatsApp</a>',
]);
?>

<!-- ── Intro + offerings ─────────────────────────────────────────────── -->
<section class="section">
  <div class="container split split-top">
    <div class="reveal">
      <span class="eyebrow">Overview</span>
      <h2><?= e($s['headline']) ?></h2>
      <p class="lead"><?= e($s['intro']) ?></p>
      <h3 style="margin-top:28px"><?= e($s['title']) ?> in Jalgaon and Amalner</h3>
      <p><?= e($s['local']) ?></p>
      <?php if ($related): ?>
        <p class="mb-0">Related reading: <a href="<?= e(url('blog/' . $s['related_post'])) ?>"><strong><?= e($related['title']) ?></strong></a></p>
      <?php endif; ?>
    </div>
    <div class="card reveal reveal-d2" style="background:var(--bg-soft)">
      <h3><?= icon('list-check') ?> What we offer</h3>
      <ul class="check-list mb-0"><?php foreach ($s['offerings'] as $o): ?><li><?= e($o) ?></li><?php endforeach; ?></ul>
    </div>
  </div>
</section>

<!-- ── Features ──────────────────────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Key features</span>
      <h2>What’s included</h2>
    </div>
    <div class="grid grid-3">
      <?php foreach ($s['features'] as $k => [$ic, $t, $d]): ?>
        <div class="card feature-card card-hover reveal <?= $delays[$k % 3] ?>">
          <div class="icon-box<?= $k % 2 ? ' maroon' : '' ?>"><?= icon($ic) ?></div>
          <h3><?= e($t) ?></h3>
          <p><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Process ───────────────────────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Our process</span>
      <h2>How we deliver <?= e(strtolower($s['title']) === 'seo' ? 'SEO' : $s['title']) ?></h2>
    </div>
    <div class="process">
      <?php foreach ($s['process'] as $k => [$t, $d]): ?>
        <div class="step reveal <?= $delays[$k] ?>"><div class="step-num"></div><h3><?= e($t) ?></h3><p><?= e($d) ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── Tools ─────────────────────────────────────────────────────────── -->
<section class="section-sm section-soft">
  <div class="container text-center">
    <span class="eyebrow">Tools &amp; technologies</span>
    <div class="chips" style="justify-content:center;margin-top:10px">
      <?php foreach ($s['tools'] as $t): ?><span class="chip"><?= icon('check2') ?> <?= e($t) ?></span><?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ── FAQ ───────────────────────────────────────────────────────────── -->
<section class="section">
  <div class="container container-narrow">
    <div class="section-head center">
      <span class="eyebrow">FAQ</span>
      <h2>Frequently asked questions</h2>
    </div>
    <?php partial('faq', ['items' => $s['faqs']]); ?>
  </div>
</section>

<?php partial('cta', [
    'title' => 'Let’s talk about your ' . (strtolower($s['title']) === 'seo' ? 'SEO' : strtolower($s['title'])) . ' project',
    'text'  => 'Share your requirements and get a free consultation and quote within 24 working hours.',
]); ?>

<!-- ── Other services ────────────────────────────────────────────────── -->
<section class="section section-soft">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Explore more</span>
      <h2>Other services</h2>
    </div>
    <div class="grid grid-4">
      <?php $k = 0; foreach (array_slice($others, 0, 4, true) as $oslug => $o): ?>
        <article class="card card-hover service-card reveal <?= $delays[$k++] ?>">
          <div class="icon-box<?= $o['category'] === 'grow' ? ' maroon' : '' ?>"><?= icon($o['icon']) ?></div>
          <h3><a href="<?= e(url('services/' . $oslug)) ?>"><?= e($o['title']) ?></a></h3>
          <p><?= e($o['short']) ?></p>
          <span class="link-arrow">Learn more <?= icon('arrow-right') ?></span>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

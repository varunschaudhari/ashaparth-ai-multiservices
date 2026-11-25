<?php
defined('APP_ROOT') || exit;
/** @var array $project  @var string $slug */
$p        = $project;
$isTemple = $p['category'] === 'Temple Solutions';
$hasImage = !empty($p['image']) && is_file(APP_ROOT . '/assets/' . $p['image']);
$draft    = has_placeholder($p);
$others   = array_filter(data('portfolio'), fn ($x, $k) => $k !== $slug && !$x['is_sample'], ARRAY_FILTER_USE_BOTH);

// Service pages this project used, so readers can go straight to them.
$allServices    = services();
$linkedServices = [];
foreach ($p['service_slugs'] ?? [] as $serviceSlug) {
    if (isset($allServices[$serviceSlug])) {
        $linkedServices[$serviceSlug] = $allServices[$serviceSlug];
    }
}

partial('page-hero', [
    'title'   => $p['title'],
    'text'    => $p['summary'],
    'crumbs'  => [['Portfolio', 'portfolio'], [$p['title'], 'portfolio/' . $slug]],
    'eyebrow' => $p['category'],
    'icon'    => $p['icon'],
    'variant' => $isTemple ? 'temple' : '',
]);
?>
<section class="section">
  <div class="container case-layout">
    <div>
      <?php if ($p['is_sample']): ?>
        <div class="sample-note"><?= icon('info-circle-fill') ?><div><strong>This is a sample case study.</strong> It shows the layout for a project page and will be replaced with a real project.</div></div>
      <?php elseif ($draft): ?>
        <div class="sample-note"><?= icon('pencil-square') ?><div><strong>Draft case study.</strong> Highlighted <mark class="ph">[PLACEHOLDER]</mark> items still need real project details.</div></div>
      <?php endif; ?>

      <div class="case-shot reveal">
        <div class="mock-bar"><i></i><i></i><i></i><span class="mock-url"><?= e($p['url_label'] ?: 'project preview') ?></span></div>
        <?php if ($hasImage): ?>
          <img src="<?= e(asset($p['image'])) ?>" alt="<?= e($p['title']) ?> screenshot" width="1200" height="750">
        <?php else: ?>
          <div class="cover-illustration<?= $p['is_sample'] ? ' sample' : ($isTemple ? ' temple' : '') ?>"><?= icon($p['icon']) ?></div>
        <?php endif; ?>
      </div>

      <div class="case-block reveal">
        <span class="eyebrow">The challenge</span>
        <p class="lead"><?= ph($p['challenge']) ?></p>
      </div>
      <div class="case-block reveal">
        <span class="eyebrow">Our solution</span>
        <p class="lead"><?= ph($p['solution']) ?></p>
      </div>
      <div class="case-block reveal">
        <h2>Key features delivered</h2>
        <ul class="check-list two-col"><?php foreach ($p['features'] as $f): ?><li><?= ph($f) ?></li><?php endforeach; ?></ul>
      </div>
      <div class="case-block reveal mb-0">
        <h2>The impact</h2>
        <ul class="check-list gold"><?php foreach ($p['results'] as $r): ?><li><?= ph($r) ?></li><?php endforeach; ?></ul>
      </div>
    </div>

    <aside class="case-aside">
      <div class="card">
        <ul class="info-list">
          <li><span>Client</span><strong><?= ph($p['client']) ?></strong></li>
          <li><span>Location</span><strong><?= ph($p['location']) ?></strong></li>
          <?php foreach ($p['client_facts'] ?? [] as [$label, $value]): ?>
            <li><span><?= e($label) ?></span><strong><?= ph($value) ?></strong></li>
          <?php endforeach; ?>
          <li><span>Category</span><strong><?= e($p['category']) ?></strong></li>
          <?php if (!empty($p['year'])): ?>
            <li><span>Year</span><strong><?= ph($p['year']) ?></strong></li>
          <?php endif; ?>
          <li><span>Services</span><strong><?= ph(implode(', ', $p['services'])) ?></strong></li>
          <?php if (!empty($p['url'])): ?>
            <li><span><?= e($p['link_label'] ?? 'Live link') ?></span><a href="<?= e($p['url']) ?>" target="_blank" rel="noopener"><?= e($p['url_label']) ?> <?= icon('box-arrow-up-right') ?></a></li>
          <?php endif; ?>
        </ul>
      </div>
      <?php if ($linkedServices): ?>
        <div class="card">
          <h3 style="font-size:1rem">Related services</h3>
          <div class="related-links">
            <?php foreach ($linkedServices as $serviceSlug => $svc): ?>
              <a class="related-link" href="<?= e(url('services/' . $serviceSlug)) ?>"><?= icon($svc['icon']) ?> <?= e($svc['title']) ?></a>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>
      <div class="card">
        <h3 style="font-size:1rem">Technologies</h3>
        <div class="chips"><?php foreach ($p['tech'] as $t): ?><span class="chip"><?= ph($t) ?></span><?php endforeach; ?></div>
      </div>
      <div class="card" style="background:var(--maroon);border-color:var(--maroon);color:#fff">
        <h3 style="color:#fff;font-size:1.1rem">Want something similar?</h3>
        <p style="color:rgba(255,255,255,.85);font-size:.93rem">Tell us about your project and get a free quote.</p>
        <a class="btn btn-light btn-block" href="<?= e(url('get-a-quote')) ?>"><?= icon('send') ?> Get a Quote</a>
      </div>
    </aside>
  </div>
</section>

<?php if ($others): ?>
<section class="section section-soft">
  <div class="container">
    <div class="section-head center"><span class="eyebrow">More work</span><h2>Other projects</h2></div>
    <div class="grid grid-3">
      <?php foreach (array_slice($others, 0, 3, true) as $oslug => $op): partial('project-card', ['slug' => $oslug, 'p' => $op, 'delay' => '']); endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

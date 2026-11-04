<?php
defined('APP_ROOT') || exit;
/** @var array $project  @var string $slug */
$p        = $project;
$isTemple = $p['category'] === 'Temple Solutions';
$hasImage = !empty($p['image']) && is_file(APP_ROOT . '/assets/' . $p['image']);
$others   = array_filter(data('portfolio'), fn ($x, $k) => $k !== $slug && !$x['is_sample'], ARRAY_FILTER_USE_BOTH);

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
        <p class="lead"><?= e($p['challenge']) ?></p>
      </div>
      <div class="case-block reveal">
        <span class="eyebrow">Our solution</span>
        <p class="lead"><?= e($p['solution']) ?></p>
      </div>
      <div class="case-block reveal">
        <h2>Key features delivered</h2>
        <ul class="check-list two-col"><?php foreach ($p['features'] as $f): ?><li><?= e($f) ?></li><?php endforeach; ?></ul>
      </div>
      <div class="case-block reveal mb-0">
        <h2>The impact</h2>
        <ul class="check-list gold"><?php foreach ($p['results'] as $r): ?><li><?= e($r) ?></li><?php endforeach; ?></ul>
      </div>
    </div>

    <aside class="case-aside">
      <div class="card">
        <ul class="info-list">
          <li><span>Client</span><strong><?= e($p['client']) ?></strong></li>
          <li><span>Location</span><strong><?= e($p['location']) ?></strong></li>
          <li><span>Category</span><strong><?= e($p['category']) ?></strong></li>
          <li><span>Services</span><strong><?= e(implode(', ', $p['services'])) ?></strong></li>
          <?php if (!empty($p['url'])): ?>
            <li><span>Live link</span><a href="<?= e($p['url']) ?>" target="_blank" rel="noopener"><?= e($p['url_label']) ?> <?= icon('box-arrow-up-right') ?></a></li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="card">
        <h3 style="font-size:1rem">Technologies</h3>
        <div class="chips"><?php foreach ($p['tech'] as $t): ?><span class="chip"><?= e($t) ?></span><?php endforeach; ?></div>
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
      <?php $k = 0; foreach (array_slice($others, 0, 3, true) as $oslug => $op): partial('project-card', ['slug' => $oslug, 'p' => $op, 'delay' => '']); endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

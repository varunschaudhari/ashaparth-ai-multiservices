<?php
/** Portfolio card. Vars: $slug, $p, $delay (optional reveal delay class) */
defined('APP_ROOT') || exit;
$isTemple = $p['category'] === 'Temple Solutions';
?>
<article class="card card-hover project-card reveal <?= e($delay ?? '') ?>" data-category="<?= e($p['category']) ?>">
  <div class="project-cover">
    <?php if (!empty($p['image']) && is_file(APP_ROOT . '/assets/' . $p['image'])): ?>
      <img src="<?= e(asset($p['image'])) ?>" alt="<?= e($p['title']) ?> screenshot" loading="lazy" width="800" height="500">
    <?php else: ?>
      <div class="cover-illustration<?= $p['is_sample'] ? ' sample' : ($isTemple ? ' temple' : '') ?>"><?= icon($p['icon']) ?></div>
    <?php endif; ?>
  </div>
  <div class="project-body">
    <div class="project-meta">
      <span class="badge<?= $isTemple ? '' : ' badge-maroon' ?>"><?= e($p['category']) ?></span>
      <?php if ($p['is_sample']): ?><span class="badge badge-sample">Sample</span><?php elseif (!empty($p['url'])): ?><span class="badge badge-live"><?= icon('circle-fill') ?> Live</span><?php endif; ?>
    </div>
    <h3><a href="<?= e(url('portfolio/' . $slug)) ?>"><?= e($p['title']) ?></a></h3>
    <div class="project-client"><?= icon('geo-alt') ?> <?= e($p['client']) ?>, <?= e($p['location']) ?></div>
    <p><?= e($p['summary']) ?></p>
    <span class="link-arrow">View case study <?= icon('arrow-right') ?></span>
  </div>
</article>

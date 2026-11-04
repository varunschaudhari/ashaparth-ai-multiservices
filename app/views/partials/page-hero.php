<?php
/**
 * Inner page hero.
 * Vars: $title, $text, $crumbs = [[label, path], ...], $eyebrow, $icon (bi name), $image (asset path),
 *       $variant ('' | 'temple'), $actions (raw HTML, already escaped)
 */
defined('APP_ROOT') || exit;
$crumbs  = $crumbs ?? [];
$variant = $variant ?? '';
?>
<section class="page-hero <?= e($variant) ?>">
  <div class="container page-hero-inner">
    <div>
      <nav aria-label="Breadcrumb">
        <ol class="breadcrumb">
          <li><a href="<?= e(url()) ?>">Home</a></li>
          <?php foreach ($crumbs as $i => [$label, $path]): ?>
            <?php if ($i === count($crumbs) - 1): ?>
              <li aria-current="page"><?= e($label) ?></li>
            <?php else: ?>
              <li><a href="<?= e(url($path)) ?>"><?= e($label) ?></a></li>
            <?php endif; ?>
          <?php endforeach; ?>
        </ol>
      </nav>
      <?php if (!empty($eyebrow)): ?><span class="eyebrow"><?= e($eyebrow) ?></span><?php endif; ?>
      <h1><?= e($title) ?></h1>
      <?php if (!empty($text)): ?><p><?= e($text) ?></p><?php endif; ?>
      <?php if (!empty($actions)): ?><div class="hero-actions"><?= $actions ?></div><?php endif; ?>
    </div>
    <?php if (!empty($image)): ?>
      <div class="page-hero-icon"><img src="<?= e(asset($image)) ?>" alt=""></div>
    <?php elseif (!empty($icon)): ?>
      <div class="page-hero-icon"><?= icon($icon) ?></div>
    <?php endif; ?>
  </div>
</section>

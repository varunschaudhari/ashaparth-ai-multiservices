<?php
/** Blog post card. Vars: $slug, $post, $delay */
defined('APP_ROOT') || exit;
?>
<article class="card card-hover post-card reveal <?= e($delay ?? '') ?>">
  <div class="post-cover"><?= icon($post['icon']) ?></div>
  <div class="post-body">
    <div class="post-meta">
      <span><?= icon('tag') ?> <?= e($post['category']) ?></span>
      <span><?= icon('calendar3') ?> <time datetime="<?= e($post['date']) ?>"><?= e(format_date($post['date'])) ?></time></span>
    </div>
    <h3><a href="<?= e(url('blog/' . $slug)) ?>"><?= e($post['title']) ?></a></h3>
    <p><?= e($post['excerpt']) ?></p>
    <span class="link-arrow">Read article <?= icon('arrow-right') ?></span>
  </div>
</article>

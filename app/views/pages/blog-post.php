<?php
defined('APP_ROOT') || exit;
/** @var array $post  @var string $slug */
$shareUrl = absolute_url('blog/' . $slug);
$others   = array_slice(array_filter(data('blog'), fn ($k) => $k !== $slug, ARRAY_FILTER_USE_KEY), 0, 3, true);
// Root-relative links in post bodies must respect a sub-folder install.
$body = str_replace('href="/', 'href="' . base_path() . '/', $post['body']);
?>
<section class="page-hero">
  <div class="container">
    <div class="article-header">
      <nav aria-label="Breadcrumb">
        <ol class="breadcrumb" style="justify-content:center">
          <li><a href="<?= e(url()) ?>">Home</a></li>
          <li><a href="<?= e(url('blog')) ?>">Blog</a></li>
          <li aria-current="page"><?= e($post['category']) ?></li>
        </ol>
      </nav>
      <h1><?= e($post['title']) ?></h1>
      <p style="margin:0 auto"><?= e($post['excerpt']) ?></p>
      <div class="post-meta">
        <span><?= icon('person') ?> Team AshaParth AI</span>
        <span><?= icon('calendar3') ?> <time datetime="<?= e($post['date']) ?>"><?= e(format_date($post['date'])) ?></time></span>
        <span><?= icon('clock') ?> <?= (int) $post['read_min'] ?> min read</span>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container container-narrow">
    <article class="prose">
      <?= $body /* trusted HTML authored in app/data/blog.php */ ?>
    </article>

    <div class="article-share">
      Share:
      <a class="share-btn" href="https://wa.me/?text=<?= e(rawurlencode($post['title'] . ' ' . $shareUrl)) ?>" target="_blank" rel="noopener" aria-label="Share on WhatsApp"><?= icon('whatsapp') ?></a>
      <a class="share-btn" href="https://www.facebook.com/sharer/sharer.php?u=<?= e(rawurlencode($shareUrl)) ?>" target="_blank" rel="noopener" aria-label="Share on Facebook"><?= icon('facebook') ?></a>
      <a class="share-btn" href="https://www.linkedin.com/sharing/share-offsite/?url=<?= e(rawurlencode($shareUrl)) ?>" target="_blank" rel="noopener" aria-label="Share on LinkedIn"><?= icon('linkedin') ?></a>
      <a class="share-btn" href="https://twitter.com/intent/tweet?url=<?= e(rawurlencode($shareUrl)) ?>&amp;text=<?= e(rawurlencode($post['title'])) ?>" target="_blank" rel="noopener" aria-label="Share on X"><?= icon('twitter-x') ?></a>
    </div>
  </div>
</section>

<?php partial('cta', ['title' => 'Need help putting this into practice?', 'text' => 'Talk to our team for a free consultation tailored to your business or temple.']); ?>

<?php if ($others): ?>
<section class="section section-soft">
  <div class="container">
    <div class="section-head center"><span class="eyebrow">Keep reading</span><h2>More articles</h2></div>
    <div class="grid grid-3">
      <?php foreach ($others as $oslug => $op): partial('post-card', ['slug' => $oslug, 'post' => $op, 'delay' => '']); endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
defined('APP_ROOT') || exit;
$delays = ['', 'reveal-d1', 'reveal-d2'];
partial('page-hero', [
    'title'   => 'Blog',
    'text'    => 'Practical insights on websites, apps, AI, digital marketing and temple digitisation from the AshaParth AI team.',
    'crumbs'  => [['Blog', 'blog']],
    'eyebrow' => 'Insights',
    'icon'    => 'journal-richtext',
]);
?>
<section class="section">
  <div class="container">
    <div class="grid grid-3">
      <?php $k = 0; foreach (data('blog') as $slug => $post): partial('post-card', ['slug' => $slug, 'post' => $post, 'delay' => $delays[$k++ % 3]]); endforeach; ?>
    </div>
  </div>
</section>
<?php partial('cta'); ?>

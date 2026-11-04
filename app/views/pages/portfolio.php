<?php
defined('APP_ROOT') || exit;
$delays     = ['', 'reveal-d1', 'reveal-d2'];
$projects   = data('portfolio');
$categories = array_values(array_unique(array_column($projects, 'category')));

partial('page-hero', [
    'title'   => 'Portfolio & Case Studies',
    'text'    => 'A selection of websites, apps, software and digital campaigns we have delivered.',
    'crumbs'  => [['Portfolio', 'portfolio']],
    'eyebrow' => 'Our work',
    'icon'    => 'collection',
]);
?>
<section class="section">
  <div class="container">
    <div class="filters" role="toolbar" aria-label="Filter projects">
      <button class="filter-btn active" type="button" data-filter="all" aria-pressed="true">All</button>
      <?php foreach ($categories as $c): ?>
        <button class="filter-btn" type="button" data-filter="<?= e($c) ?>" aria-pressed="false"><?= e($c) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="grid grid-3">
      <?php $k = 0; foreach ($projects as $slug => $p): partial('project-card', ['slug' => $slug, 'p' => $p, 'delay' => $delays[$k++ % 3]]); endforeach; ?>
    </div>
  </div>
</section>

<?php partial('cta', ['title' => 'Have a project in mind?', 'text' => 'Let’s make your business the next success story in our portfolio.']); ?>

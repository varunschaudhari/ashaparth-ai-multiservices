<?php
/** Dynamic XML sitemap: /sitemap.xml */
defined('APP_ROOT') || exit;

$today = date('Y-m-d');
$urls  = [
    ['', '1.0', 'weekly'],
    ['about', '0.8', 'monthly'],
    ['services', '0.9', 'monthly'],
    ['temple-solutions', '0.9', 'monthly'],
    ['devasthan-live', '0.9', 'monthly'],
    ['portfolio', '0.8', 'monthly'],
    ['blog', '0.7', 'weekly'],
    ['careers', '0.6', 'monthly'],
    ['contact', '0.8', 'yearly'],
    ['get-a-quote', '0.8', 'yearly'],
    ['privacy-policy', '0.3', 'yearly'],
    ['terms-and-conditions', '0.3', 'yearly'],
];
foreach (array_keys(services()) as $slug) {
    $urls[] = ['services/' . $slug, '0.8', 'monthly'];
}
foreach (data('portfolio') as $slug => $p) {
    if (!$p['is_sample']) {
        $urls[] = ['portfolio/' . $slug, '0.6', 'yearly'];
    }
}
foreach (data('blog') as $slug => $post) {
    $urls[] = ['blog/' . $slug, '0.6', 'yearly', $post['date']];
}

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u) {
    echo '  <url><loc>' . e(absolute_url($u[0])) . '</loc><lastmod>' . e($u[3] ?? $today) . '</lastmod>'
        . '<changefreq>' . $u[2] . '</changefreq><priority>' . $u[1] . '</priority></url>' . "\n";
}
echo '</urlset>' . "\n";

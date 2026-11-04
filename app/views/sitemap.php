<?php
/** Dynamic XML sitemap: /sitemap.xml. Sample portfolio entries are left out. */
defined('APP_ROOT') || exit;

$urls = [
    [''], ['about'], ['services'], ['temple-solutions'], ['live-darshan-service'], ['devasthan-live'],
    ['portfolio'], ['blog'], ['careers'], ['contact'], ['get-a-quote'], ['privacy-policy'], ['terms-and-conditions'],
];
foreach (array_keys(services()) as $slug) {
    $urls[] = ['services/' . $slug];
}
foreach (data('portfolio') as $slug => $p) {
    if (!$p['is_sample']) {
        $urls[] = ['portfolio/' . $slug];
    }
}
foreach (data('blog') as $slug => $post) {
    $urls[] = ['blog/' . $slug, $post['date']]; // only real dates, so Google can trust lastmod
}

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $u) {
    $lastmod = isset($u[1]) ? '<lastmod>' . e($u[1]) . '</lastmod>' : '';
    echo '  <url><loc>' . e(absolute_url($u[0])) . '</loc>' . $lastmod . '</url>' . "\n";
}
echo '</urlset>' . "\n";

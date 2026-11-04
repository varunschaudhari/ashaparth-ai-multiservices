<?php
defined('APP_ROOT') || exit;

$siteName  = config('name');
$pageTitle = $meta['title'] !== '' ? $meta['title'] . ' | ' . config('short_name') : config('home_title');
$canonical = absolute_url($meta['canonical']);
$ogImage   = absolute_url('assets/' . ltrim($meta['og_image'], '/'));
$a         = config('address');

$orgSchema = [
    '@context'    => 'https://schema.org',
    '@type'       => 'ProfessionalService',
    'name'        => $siteName,
    'description' => config('description'),
    'url'         => absolute_url(),
    'logo'        => absolute_url('assets/img/logo-mark.svg'),
    'image'       => absolute_url('assets/img/og-image.png'),
    'telephone'   => config('phone_e164'),
    'email'       => config('email'),
    'address'     => [
        '@type'           => 'PostalAddress',
        'streetAddress'   => $a['line1'],
        'addressLocality' => $a['city'],
        'addressRegion'   => $a['state'],
        'postalCode'      => $a['pincode'],
        'addressCountry'  => 'IN',
    ],
    'openingHoursSpecification' => [[
        '@type'     => 'OpeningHoursSpecification',
        'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        'opens'     => '10:00',
        'closes'    => '19:00',
    ]],
    'areaServed'  => ['Jalgaon district', 'Maharashtra', 'India', 'Worldwide'],
    'hasMap'      => map_link_url(),
    'founder'     => array_map(fn ($f) => ['@type' => 'Person', 'name' => $f['name']], config('founders', [])),
];
$sameAs = array_values(array_filter(array_column(social_links(), 'href'), fn ($h) => $h !== '#'));
if ($sameAs) {
    $orgSchema['sameAs'] = $sameAs;
}
$schemas = array_merge([$orgSchema], $meta['schema']);

$templeNav = [
    ['temple-solutions', 'Temple Solutions', 'Live darshan, websites, apps & donations', 'bank'],
    ['live-darshan-service', 'Live Darshan Service', 'HD streaming for your temple', 'camera-video'],
    ['devasthan-live', 'Maharashtra Devasthan Live', 'Connecting all temples of Maharashtra', 'broadcast'],
];
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>document.documentElement.classList.add('js');</script>
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e($meta['description']) ?>">
<?php if ($meta['noindex']): ?><meta name="robots" content="noindex, follow">
<?php endif; ?>
<link rel="canonical" href="<?= e($canonical) ?>">
<meta name="theme-color" content="#7a1d2b">

<meta property="og:type" content="website">
<meta property="og:site_name" content="<?= e($siteName) ?>">
<meta property="og:title" content="<?= e($pageTitle) ?>">
<meta property="og:description" content="<?= e($meta['description']) ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:image" content="<?= e($ogImage) ?>">
<meta property="og:locale" content="en_IN">
<meta name="twitter:card" content="summary_large_image">

<link rel="icon" href="<?= e(asset('img/favicon.svg')) ?>" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?= e(asset('img/apple-touch-icon.png')) ?>">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
<link rel="preload" as="style" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"></noscript>
<link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">

<?php foreach ($schemas as $schema): ?>
<script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
<?php endforeach; ?>
</head>
<body class="<?= e($meta['body_class']) ?>">
<a class="skip-link" href="#main">Skip to content</a>

<div class="topbar">
  <div class="container">
    <div class="topbar-info">
      <a href="<?= e(tel_url()) ?>"><?= icon('telephone-fill') ?> <?= e(config('phone')) ?></a>
      <a href="<?= e(mailto_url()) ?>" class="hide-sm"><?= icon('envelope-fill') ?> <?= e(config('email')) ?></a>
      <span class="hide-sm"><?= icon('clock-fill') ?> <?= e(config('hours_short')) ?></span>
    </div>
    <div class="topbar-social">
      <?php foreach (social_links() as $s): ?>
        <a href="<?= e($s['href']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['label']) ?>"><?= icon($s['icon']) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="<?= e(url()) ?>" aria-label="<?= e($siteName) ?> home">
      <img src="<?= e(asset('img/logo-mark.svg')) ?>" alt="" width="46" height="46">
      <span class="brand-text">
        <span class="brand-name">Asha<span class="p">Parth</span><span class="ai"> AI</span></span>
        <span class="brand-sub">MULTISERVICES</span>
      </span>
    </a>

    <nav class="main-nav" aria-label="Main">
      <ul class="nav-list">
        <li class="nav-item"><a class="nav-link<?= is_active('') ? ' active' : '' ?>" href="<?= e(url()) ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link<?= is_active('about') ? ' active' : '' ?>" href="<?= e(url('about')) ?>">About</a></li>

        <li class="nav-item has-dropdown">
          <button class="nav-link<?= is_active('services') ? ' active' : '' ?>" type="button" aria-expanded="false" aria-haspopup="true">Services <?= icon('chevron-down') ?></button>
          <div class="dropdown dropdown-mega">
            <div class="dropdown-title">Build</div>
            <div class="dropdown-title">Grow</div>
            <?php
            $build = array_values(array_map(null, array_keys(services('build')), services('build')));
            $grow  = array_values(array_map(null, array_keys(services('grow')), services('grow')));
            for ($i = 0, $n = max(count($build), count($grow)); $i < $n; $i++):
                foreach ([$build[$i] ?? null, $grow[$i] ?? null] as $pair):
                    if (!$pair) { echo '<span></span>'; continue; }
                    [$slug, $s] = $pair; ?>
              <a href="<?= e(url('services/' . $slug)) ?>"><?= icon($s['icon']) ?><span><strong><?= e($s['title']) ?></strong><small><?= e(mb_strimwidth($s['short'], 0, 58, '…')) ?></small></span></a>
            <?php endforeach; endfor; ?>
            <div class="dropdown-footer"><a href="<?= e(url('services')) ?>">View all services <?= icon('arrow-right') ?></a></div>
          </div>
        </li>

        <li class="nav-item has-dropdown">
          <button class="nav-link<?= (is_active('temple-solutions') || is_active('live-darshan-service') || is_active('devasthan-live')) ? ' active' : '' ?>" type="button" aria-expanded="false" aria-haspopup="true">Temples <?= icon('chevron-down') ?></button>
          <div class="dropdown">
            <?php foreach ($templeNav as [$slug, $title, $sub, $ic]): ?>
              <a href="<?= e(url($slug)) ?>"><?= icon($ic) ?><span><strong><?= e($title) ?></strong><small><?= e($sub) ?></small></span></a>
            <?php endforeach; ?>
          </div>
        </li>

        <li class="nav-item"><a class="nav-link<?= is_active('portfolio') ? ' active' : '' ?>" href="<?= e(url('portfolio')) ?>">Portfolio</a></li>
        <li class="nav-item"><a class="nav-link<?= is_active('blog') ? ' active' : '' ?>" href="<?= e(url('blog')) ?>">Blog</a></li>
        <li class="nav-item"><a class="nav-link<?= is_active('careers') ? ' active' : '' ?>" href="<?= e(url('careers')) ?>">Careers</a></li>
        <li class="nav-item"><a class="nav-link<?= is_active('contact') ? ' active' : '' ?>" href="<?= e(url('contact')) ?>">Contact</a></li>
      </ul>
      <a class="btn btn-primary nav-cta" href="<?= e(url('get-a-quote')) ?>"><?= icon('send') ?> Get a Quote</a>
    </nav>

    <button class="nav-toggle" type="button" aria-label="Open menu" aria-expanded="false"><?= icon('list') ?></button>
  </div>
</header>

<main id="main">

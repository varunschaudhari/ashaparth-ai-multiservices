<?php
/**
 * Front controller: every request that is not a real file in /assets is
 * routed here by .htaccess (Apache/LiteSpeed) or by `php -S` locally:
 *
 *   php -S localhost:8000 index.php
 */

// Local dev server: serve static assets directly, block everything else.
if (PHP_SAPI === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = realpath(__DIR__ . $path);
    if ($file && is_file($file) && strpos($file, realpath(__DIR__ . '/assets')) === 0) {
        return false;
    }
}

require __DIR__ . '/app/bootstrap.php';

enforce_canonical_host();

$path   = current_path();
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// ── Static routes ───────────────────────────────────────────────────────
// path => [view, meta, POST handler]
$routes = [
    ''                     => ['home', ['title' => '', 'description' => config('description')]],
    'about'                => ['about', ['title' => 'About Our Digital Agency in Amalner, Jalgaon', 'description' => 'Meet the founders of AshaParth AI Multiservices, a digital agency from Amalner, Jalgaon helping businesses and temples grow with technology.']],
    'services'             => ['services', ['title' => 'Digital Services in Jalgaon & Maharashtra', 'description' => 'Website development, mobile apps, AI & automation, custom software, SEO, social media marketing, paid ads and graphic design, all under one roof.']],
    'temple-solutions'     => ['temple-solutions', ['title' => 'Temple Websites, Apps & Live Darshan Services', 'description' => 'Complete digital solutions for temples: 24x7 live darshan, HD camera setup, temple websites, mobile apps, online donations, pooja booking and social media.']],
    'live-darshan-service' => ['live-darshan-service', ['title' => 'Temple Live Darshan Service in Maharashtra', 'description' => 'HD live darshan for temples across Maharashtra: camera setup, 24x7 or aarti-time streaming on YouTube and your website, with full support.', 'schema' => [[
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        'name'        => 'Temple Live Darshan Service',
        'serviceType' => 'Live streaming for temples',
        'description' => 'HD live darshan setup and streaming for temples across Maharashtra.',
        'provider'    => ['@type' => 'Organization', 'name' => config('name'), 'url' => absolute_url()],
        'areaServed'  => 'Maharashtra',
    ]]]],
    'devasthan-live'       => ['devasthan-live', ['title' => 'Maharashtra Devasthan Live: Register Temple', 'description' => 'Maharashtra Devasthan Live connects temples across Maharashtra with live darshan, temple information and devotees worldwide. Register your temple.'], 'handle_temple_form'],
    'portfolio'            => ['portfolio', ['title' => 'Portfolio & Case Studies', 'description' => 'Selected projects by AshaParth AI Multiservices: temple websites, temple management software, live darshan, business websites and apps.']],
    'blog'                 => ['blog', ['title' => 'Blog: Digital Growth Insights', 'description' => 'Practical articles on websites, AI, SEO, social media and temple digitisation from the AshaParth AI team.']],
    'careers'              => ['careers', ['title' => 'Careers', 'description' => 'Work with AshaParth AI Multiservices. Send us your resume for developer, designer, marketing and live-streaming roles.'], 'handle_career_form'],
    'contact'              => ['contact', ['title' => 'Contact Us: Amalner, Jalgaon', 'description' => 'Contact AshaParth AI Multiservices, Vivekanand Tower, Amalner, Jalgaon. Call or WhatsApp +91 99239 33355.'], 'handle_contact_form'],
    'get-a-quote'          => ['quote', ['title' => 'Get a Free Quote', 'description' => 'Tell us about your project and get a free, no-obligation quote for websites, apps, AI, software, marketing or temple solutions.'], 'handle_quote_form'],
    'privacy-policy'       => ['privacy', ['title' => 'Privacy Policy', 'description' => 'How AshaParth AI Multiservices collects, uses and protects information submitted through this website.']],
    'terms-and-conditions' => ['terms', ['title' => 'Terms & Conditions', 'description' => 'Terms and conditions for using the AshaParth AI Multiservices website and services.']],
    'thank-you'            => ['thank-you', ['title' => 'Thank You', 'noindex' => true]],
];

if ($path === 'sitemap.xml') {
    require APP_DIR . '/views/sitemap.php';
    exit;
}

if ($path === 'robots.txt') {
    header('Content-Type: text/plain; charset=utf-8');
    echo "User-agent: *\nDisallow:\n\nSitemap: " . absolute_url('sitemap.xml') . "\n";
    exit;
}

if (isset($routes[$path])) {
    [$view, $meta, $handler] = $routes[$path] + [2 => null];
    if ($method === 'POST') {
        if (!$handler) {
            http_response_code(405);
            header('Allow: GET');
            exit('Method not allowed');
        }
        $handler(); // redirects on success; on failure falls through to re-render with errors
    }
    render($view, [], $meta, http_response_code() ?: 200);
    exit;
}

// ── Dynamic routes ──────────────────────────────────────────────────────
if (preg_match('~^services/([a-z0-9-]+)$~', $path, $m)) {
    $service = data('services')[$m[1]] ?? null;
    if (!$service) {
        not_found();
    }
    render('service', ['service' => $service, 'slug' => $m[1]], [
        'title'       => $service['seo_title'] ?? $service['title'],
        'description' => $service['meta_description'],
        'schema'      => [[
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            'name'        => $service['title'],
            'description' => $service['meta_description'],
            'provider'    => ['@type' => 'Organization', 'name' => config('name'), 'url' => absolute_url()],
            'areaServed'  => ['India', 'Worldwide'],
        ]],
    ]);
    exit;
}

if (preg_match('~^portfolio/([a-z0-9-]+)$~', $path, $m)) {
    $project = data('portfolio')[$m[1]] ?? null;
    if (!$project) {
        not_found();
    }
    render('portfolio-detail', ['project' => $project, 'slug' => $m[1]], [
        'title'       => $project['seo_title'] ?? $project['title'] . ' – Case Study',
        'description' => $project['meta_description'] ?? $project['summary'],
        'noindex'     => $project['is_sample'],
        'og_image'    => $project['image'] ?? 'img/og-image.png',
    ]);
    exit;
}

if (preg_match('~^blog/([a-z0-9-]+)$~', $path, $m)) {
    $post = data('blog')[$m[1]] ?? null;
    if (!$post) {
        not_found();
    }
    render('blog-post', ['post' => $post, 'slug' => $m[1]], [
        'title'       => $post['seo_title'] ?? $post['title'],
        'description' => $post['excerpt'],
        'schema'      => [[
            '@context'      => 'https://schema.org',
            '@type'         => 'BlogPosting',
            'headline'      => $post['title'],
            'description'   => $post['excerpt'],
            'datePublished' => $post['date'],
            'image'         => absolute_url('assets/img/og-image.png'),
            'author'        => ['@type' => 'Organization', 'name' => config('name')],
            'publisher'     => ['@type' => 'Organization', 'name' => config('name')],
            'mainEntityOfPage' => absolute_url('blog/' . $m[1]),
        ]],
    ]);
    exit;
}

not_found();

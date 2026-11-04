<?php
/**
 * Small global helper functions used by routes and views.
 */

defined('APP_ROOT') || exit;

// ── Config & output ─────────────────────────────────────────────────────

/** Read a config value using dot notation, e.g. config('address.city'). */
function config(string $key, $default = null)
{
    $value = $GLOBALS['__config'];
    foreach (explode('.', $key) as $part) {
        if (!is_array($value) || !array_key_exists($part, $value)) {
            return $default;
        }
        $value = $value[$part];
    }
    return $value;
}

/** Escape for HTML output. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Bootstrap Icons <i> tag. */
function icon(string $name, string $class = ''): string
{
    return '<i class="bi bi-' . e($name) . ($class ? ' ' . e($class) : '') . '" aria-hidden="true"></i>';
}

// ── URLs ────────────────────────────────────────────────────────────────

function is_https(): bool
{
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
        || (($_SERVER['SERVER_PORT'] ?? '') == 443);
}

/** URL path prefix when the site lives in a sub-folder ('' at domain root). */
function base_path(): string
{
    static $base = null;
    if ($base === null) {
        $dir  = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/'));
        $base = rtrim($dir, '/.');
    }
    return $base;
}

/** Site-relative URL, e.g. url('services/seo') → /services/seo */
function url(string $path = ''): string
{
    $path = ltrim($path, '/');
    return base_path() . '/' . $path;
}

/** Versioned asset URL so browsers pick up changes after deploys. */
function asset(string $path): string
{
    $path = ltrim($path, '/');
    $file = APP_ROOT . '/assets/' . $path;
    $ver  = is_file($file) ? '?v=' . filemtime($file) : '';
    return url('assets/' . $path) . $ver;
}

/**
 * Redirect to the address in config('site_url') so Google sees one version of
 * each page (https only, www or non-www). Does nothing until site_url is set.
 */
function enforce_canonical_host(): void
{
    $want = parse_url((string) config('site_url', ''));
    if (empty($want['host']) || PHP_SAPI === 'cli-server') {
        return;
    }
    if (!in_array($_SERVER['REQUEST_METHOD'] ?? 'GET', ['GET', 'HEAD'], true)) {
        return; // never redirect a form submission
    }
    $wantHost = strtolower($want['host'] . (isset($want['port']) ? ':' . $want['port'] : ''));
    $wantScheme = $want['scheme'] ?? 'https';
    if (strtolower($_SERVER['HTTP_HOST'] ?? '') === $wantHost && (is_https() ? 'https' : 'http') === $wantScheme) {
        return;
    }
    header('Location: ' . $wantScheme . '://' . $wantHost . ($_SERVER['REQUEST_URI'] ?? '/'), true, 301);
    exit;
}

/** scheme://host with no trailing slash. */
function site_origin(): string
{
    $configured = rtrim((string) config('site_url', ''), '/');
    if ($configured !== '') {
        // strip any path; base_path() supplies it
        $parts = parse_url($configured);
        return ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? '') . (isset($parts['port']) ? ':' . $parts['port'] : '');
    }
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $host = preg_replace('/[^A-Za-z0-9.\-:\[\]]/', '', $host); // never trust Host blindly
    return (is_https() ? 'https' : 'http') . '://' . $host;
}

function absolute_url(string $path = ''): string
{
    return site_origin() . url($path);
}

/** Request path relative to the site root, without slashes: '' | 'services/seo' */
function current_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $path = rawurldecode($path);
    $base = base_path();
    if ($base !== '' && strpos($path, $base) === 0) {
        $path = substr($path, strlen($base));
    }
    $path = trim($path, '/');
    if ($path === 'index.php') {
        $path = '';
    }
    return $path;
}

/** True when the current page is $path or below it (for nav highlighting). */
function is_active(string $path): bool
{
    $current = current_path();
    $path    = trim($path, '/');
    if ($path === '') {
        return $current === '';
    }
    return $current === $path || strpos($current, $path . '/') === 0;
}

function redirect(string $path, int $status = 303): void
{
    header('Location: ' . url($path), true, $status);
    exit;
}

function tel_url(): string
{
    return 'tel:' . config('phone_e164');
}

function whatsapp_url(?string $text = null): string
{
    return 'https://wa.me/' . config('whatsapp') . '?text=' . rawurlencode($text ?? (string) config('whatsapp_text'));
}

function mailto_url(): string
{
    return 'mailto:' . config('email');
}

function map_embed_url(): string
{
    return 'https://maps.google.com/maps?q=' . rawurlencode((string) config('map_query')) . '&t=&z=15&ie=UTF8&iwloc=&output=embed';
}

function map_link_url(): string
{
    return 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode((string) config('map_query'));
}

function full_address(bool $withCountry = false): string
{
    $a     = config('address');
    $parts = [$a['line1'], $a['city'], 'Dist. ' . $a['district'], $a['state'] . ' ' . $a['pincode']];
    if ($withCountry) {
        $parts[] = $a['country'];
    }
    return implode(', ', $parts);
}

/** Social links that have a value (empty strings are hidden). */
function social_links(): array
{
    $icons = ['youtube' => 'youtube', 'facebook' => 'facebook', 'instagram' => 'instagram', 'linkedin' => 'linkedin', 'x' => 'twitter-x'];
    $labels = ['youtube' => 'YouTube', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'x' => 'X'];
    $out   = [];
    foreach ((array) config('social', []) as $network => $href) {
        if ($href !== '' && $href !== null) {
            $out[] = ['network' => $network, 'label' => $labels[$network] ?? ucfirst($network), 'href' => $href, 'icon' => $icons[$network] ?? 'link-45deg'];
        }
    }
    return $out;
}

// ── Views ───────────────────────────────────────────────────────────────

/**
 * Render a page view inside the site layout.
 *
 * $meta keys: title, description, canonical (path), og_image, schema (array), body_class
 */
function render(string $view, array $data = [], array $meta = [], int $status = 200): void
{
    http_response_code($status);
    $file = APP_DIR . '/views/pages/' . $view . '.php';
    if (!is_file($file)) {
        throw new RuntimeException("View not found: $view");
    }

    extract($data, EXTR_SKIP);
    ob_start();
    include $file;
    $content = ob_get_clean();

    $meta = array_merge([
        'title'       => '',
        'description' => config('description'),
        'canonical'   => current_path(),
        'og_image'    => 'img/og-image.png',
        'schema'      => [],
        'body_class'  => '',
        'noindex'     => false,
    ], $meta);

    include APP_DIR . '/views/layout/header.php';
    echo $content;
    include APP_DIR . '/views/layout/footer.php';
}

/** Include a partial from app/views/partials with its own variables. */
function partial(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    include APP_DIR . '/views/partials/' . $name . '.php';
}

function not_found(): void
{
    render('404', [], ['title' => 'Page Not Found', 'noindex' => true], 404);
    exit;
}

/** BreadcrumbList structured data. $crumbs = [[label, path], ...] without Home. */
function breadcrumb_schema(array $crumbs): string
{
    if (!$crumbs) {
        return '';
    }
    $list = [];
    foreach (array_merge([['Home', '']], $crumbs) as $i => [$label, $path]) {
        $list[] = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $label, 'item' => absolute_url($path)];
    }
    $schema = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $list];
    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) . '</script>';
}

// ── Data ────────────────────────────────────────────────────────────────

/** Load a data file from app/data (cached per request). */
function data(string $name): array
{
    static $cache = [];
    if (!isset($cache[$name])) {
        $cache[$name] = require APP_DIR . '/data/' . $name . '.php';
    }
    return $cache[$name];
}

function services(?string $category = null): array
{
    $all = data('services');
    if ($category === null) {
        return $all;
    }
    return array_filter($all, fn ($s) => $s['category'] === $category);
}

function format_date(string $ymd): string
{
    $ts = strtotime($ymd);
    return $ts ? date('j F Y', $ts) : $ymd;
}

// ── Forms: CSRF, old input, errors ─────────────────────────────────────

function csrf_token(): string
{
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

/** Hidden fields every form needs: CSRF token, honeypot and time-trap. */
function form_guard_fields(): string
{
    $issued = time();
    $sig    = hash_hmac('sha256', (string) $issued, csrf_token());
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">'
        . '<input type="hidden" name="_ts" value="' . $issued . '.' . $sig . '">'
        . '<div class="hp-field" aria-hidden="true"><label>Leave this field empty<input type="text" name="website_url" tabindex="-1" autocomplete="off"></label></div>';
}

function old(string $field, $default = '')
{
    return $GLOBALS['__form_old'][$field] ?? $default;
}

function old_has(string $field, string $value): bool
{
    $v = $GLOBALS['__form_old'][$field] ?? [];
    return is_array($v) ? in_array($value, $v, true) : $v === $value;
}

function field_error(string $field): string
{
    $msg = $GLOBALS['__form_errors'][$field] ?? '';
    return $msg ? '<p class="field-error" id="err-' . e($field) . '">' . e($msg) . '</p>' : '';
}

function has_error(string $field): bool
{
    return !empty($GLOBALS['__form_errors'][$field]);
}

/** Attributes for an input: invalid state and describedby for errors. */
function field_attrs(string $field): string
{
    return has_error($field) ? ' aria-invalid="true" aria-describedby="err-' . e($field) . '"' : '';
}

// ── Misc ────────────────────────────────────────────────────────────────

function client_ip(): string
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

function app_log(string $channel, string $message): void
{
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
    @file_put_contents(STORAGE_DIR . '/logs/' . preg_replace('/[^a-z0-9_-]/', '', $channel) . '.log', $line, FILE_APPEND | LOCK_EX);
}

function initials(string $name): string
{
    $words = preg_split('/\s+/', trim($name));
    $out   = '';
    foreach (array_slice($words, 0, 2) as $w) {
        $out .= mb_strtoupper(mb_substr($w, 0, 1));
    }
    return $out;
}

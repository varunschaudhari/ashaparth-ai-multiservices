<?php
/**
 * Builds a static review copy of the site into dist/ for GitHub Pages.
 *
 *   C:\xampp\php\php.exe tools\build-static.php [base-path] [origin]
 *
 * GitHub Pages cannot run PHP, so this crawls the site through PHP's built-in
 * server and saves each page as plain HTML. In the copy:
 *   - every page carries a "review copy" banner and a noindex tag
 *   - form submit buttons are switched off (nothing could process them)
 *   - session tokens are removed from the saved HTML
 *
 * Only pages and /assets are written. app/, storage/ and database/ are never
 * copied. The build stops if a page is broken or shows a PHP error.
 */

if (PHP_SAPI !== 'cli') {
    exit("Run this from the command line.\n");
}

$root   = dirname(__DIR__);
$base   = rtrim($argv[1] ?? '/ashaparth-ai-multiservices', '/');
$origin = rtrim($argv[2] ?? 'https://varunschaudhari.github.io', '/');
$dist   = $root . '/dist';
$port   = 8099;
$local  = "http://127.0.0.1:$port";

// ── Helpers ─────────────────────────────────────────────────────────────

function remove_tree(string $dir): void
{
    if (!is_dir($dir)) {
        return;
    }
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($items as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }
    rmdir($dir);
}

function copy_tree(string $from, string $to): int
{
    $count = 0;
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($from, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($items as $item) {
        $target = $to . '/' . substr($item->getPathname(), strlen($from) + 1);
        if ($item->isDir()) {
            is_dir($target) || mkdir($target, 0755, true);
        } else {
            is_dir(dirname($target)) || mkdir(dirname($target), 0755, true);
            copy($item->getPathname(), $target);
            $count++;
        }
    }
    return $count;
}

/** @return array{0: int, 1: string} [status, body] */
function fetch(string $url): array
{
    $context = stream_context_create(['http' => ['ignore_errors' => true, 'follow_location' => 0, 'timeout' => 20]]);
    $stream  = @fopen($url, 'r', false, $context);
    if (!$stream) {
        return [0, ''];
    }
    $headers = stream_get_meta_data($stream)['wrapper_data'] ?? [];
    $body    = (string) stream_get_contents($stream);
    fclose($stream);

    $status = 0;
    foreach ($headers as $line) {
        if (preg_match('~^HTTP/\S+\s+(\d{3})~', (string) $line, $m)) {
            $status = (int) $m[1];
        }
    }
    return [$status, $body];
}

function write_page(string $dist, string $path, string $html): void
{
    $file = trim($path, '/') === '' ? 'index.html' : trim($path, '/') . '/index.html';
    if (preg_match('~\.(xml|html)$~', $path)) {
        $file = trim($path, '/');
    }
    $target = $dist . '/' . $file;
    is_dir(dirname($target)) || mkdir(dirname($target), 0755, true);
    file_put_contents($target, $html);
}

/** Point URLs at the published location. */
function rewrite_urls(string $text, string $local, string $base, string $origin): string
{
    $text = str_replace($local, $origin . $base, $text);
    $text = str_replace(rawurlencode($local), rawurlencode($origin . $base), $text);
    return preg_replace('~\b(href|src|action)="/(?!/)~', '$1="' . $base . '/', $text);
}

/** Turn a rendered page into its review-copy version. */
function to_review_copy(string $html): string
{
    // Keep it out of search results (replaces any existing robots tag).
    $html = preg_replace('~<meta name="robots"[^>]*>\s*~', '', $html);
    $html = str_replace('<meta charset="utf-8">', '<meta charset="utf-8">' . "\n" . '<meta name="robots" content="noindex, nofollow">', $html);

    // Session tokens and the honeypot have no purpose in a static file.
    $html = preg_replace('~<input type="hidden" name="(_token|_ts|MAX_FILE_SIZE)"[^>]*>~', '', $html);
    $html = preg_replace('~<div class="hp-field".*?</div>~s', '', $html);

    // Forms: keep the layout, make it clear they do not submit here.
    $notice = '<div class="alert review-note" role="note"><i class="bi bi-info-circle-fill" aria-hidden="true"></i>'
        . '<div>Review copy: this form is switched off here and nothing will be sent. It works on the live website.</div></div>';
    $html = preg_replace('~<form\b[^>]*>~', $notice . '<form onsubmit="return false">', $html);
    $html = preg_replace('~(<button\b[^>]*?)type="submit"([^>]*>)~', '$1type="button" disabled$2', $html);

    // Banner on every page.
    $style = '<style>'
        . '.review-bar{background:#1a1f2b;color:#f6c77c;font-size:.85rem;font-weight:600;text-align:center;padding:9px 16px;line-height:1.4}'
        . '.review-note{background:#fffbeb;border:1px solid #fde68a;color:#78350f}'
        . '</style>';
    $bar = '<div class="review-bar" role="status">Review copy. Forms are switched off on this version.</div>';
    $html = str_replace('</head>', $style . "\n</head>", $html);
    return preg_replace('~(<body\b[^>]*>)~', '$1' . "\n" . $bar, $html, 1);
}

// ── Start a private server ──────────────────────────────────────────────

$null   = PHP_OS_FAMILY === 'Windows' ? 'NUL' : '/dev/null';
$server = proc_open(
    [PHP_BINARY, '-S', "127.0.0.1:$port", 'index.php'],
    [0 => ['pipe', 'r'], 1 => ['file', $null, 'w'], 2 => ['file', $null, 'w']],
    $pipes,
    $root
);
if (!is_resource($server)) {
    exit("Could not start the PHP server.\n");
}
$stop = function () use ($server) {
    proc_terminate($server);
};

$ready = false;
for ($i = 0; $i < 40 && !$ready; $i++) {
    usleep(150000);
    [$status] = fetch("$local/robots.txt");
    $ready = $status === 200;
}
if (!$ready) {
    $stop();
    exit("The PHP server did not start on port $port.\n");
}

// ── Crawl ───────────────────────────────────────────────────────────────

remove_tree($dist);
mkdir($dist, 0755, true);

$queue    = ['/', '/sitemap.xml'];
$seen     = [];
$problems = [];

while ($queue) {
    $path = array_shift($queue);
    if (isset($seen[$path])) {
        continue;
    }
    $seen[$path] = true;

    [$status, $body] = fetch($local . $path);
    if ($status !== 200) {
        $problems[] = "$status  $path";
        continue;
    }
    if (preg_match('~<b>(Warning|Notice|Fatal error|Deprecated)</b>|Stack trace~', $body)) {
        $problems[] = "PHP error on $path";
    }

    if (substr($path, -4) === '.xml') {
        write_page($dist, $path, rewrite_urls($body, $local, $base, $origin));
        continue;
    }

    preg_match_all('~\b(?:href|src)="(/(?!/)[^"#?]*)~', $body, $links);
    foreach (array_unique($links[1]) as $link) {
        $decoded = rawurldecode($link);
        if (strpos($decoded, '/assets/') === 0) {
            if (!is_file($root . $decoded)) {
                $problems[] = "missing asset $decoded (linked from $path)";
            }
        } elseif (!isset($seen[$decoded])) {
            $queue[] = $decoded;
        }
    }

    write_page($dist, $path, to_review_copy(rewrite_urls($body, $local, $base, $origin)));
}

// GitHub Pages serves /404.html for unknown URLs.
[$status, $body] = fetch("$local/this-page-does-not-exist");
if ($status === 404) {
    $body = preg_replace('~<link rel="canonical"[^>]*>\s*|<meta property="og:url"[^>]*>\s*~', '', $body);
    write_page($dist, '/404.html', to_review_copy(rewrite_urls($body, $local, $base, $origin)));
} else {
    $problems[] = "404 page returned $status";
}

$stop();

// ── Finish ──────────────────────────────────────────────────────────────

$assets = copy_tree($root . '/assets', $dist . '/assets');
file_put_contents($dist . '/.nojekyll', '');

$pages = count($seen);
echo "Crawled $pages URLs, copied $assets asset files into dist/\n";

if ($problems) {
    echo "\nBUILD FAILED, fix these first:\n  " . implode("\n  ", $problems) . "\n";
    exit(1);
}
echo "OK. Published location: $origin$base/\n";

<?php
/**
 * Loads configuration, configures errors/sessions and pulls in helpers.
 * Included once by index.php.
 */

define('APP_ROOT', dirname(__DIR__));
define('APP_DIR', __DIR__);
define('STORAGE_DIR', APP_ROOT . '/storage');

date_default_timezone_set('Asia/Kolkata');
mb_internal_encoding('UTF-8');

// ── Configuration ───────────────────────────────────────────────────────
$siteConfig  = require APP_DIR . '/config.php';
$localConfig = is_file(APP_DIR . '/config.local.php') ? require APP_DIR . '/config.local.php' : [];
$GLOBALS['__config'] = array_replace_recursive(
    ['env' => 'production', 'db' => [], 'mail' => ['driver' => 'log']],
    $siteConfig,
    is_array($localConfig) ? $localConfig : []
);
unset($siteConfig, $localConfig);

// ── Errors ──────────────────────────────────────────────────────────────
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('error_log', STORAGE_DIR . '/logs/php-error.log');
ini_set('display_errors', $GLOBALS['__config']['env'] === 'development' ? '1' : '0');

// ── Helpers & services ──────────────────────────────────────────────────
require APP_DIR . '/helpers.php';
require APP_DIR . '/fields.php';
require APP_DIR . '/db.php';
require APP_DIR . '/mailer.php';
require APP_DIR . '/forms.php';

// ── Session (CSRF tokens, rate-limit fallback) ─────────────────────────
if (session_status() !== PHP_SESSION_ACTIVE && PHP_SAPI !== 'cli') {
    session_name('apsid');
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => base_path() === '' ? '/' : base_path() . '/',
        'secure'   => is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// ── Security headers ────────────────────────────────────────────────────
if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}

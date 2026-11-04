<?php
/**
 * Creates ashaparth-upload.zip with only the files the live website needs.
 *
 *   C:\xampp\php\php.exe tools\package-deploy.php
 *
 * Upload the zip to public_html in cPanel and extract it there. It leaves out
 * your local settings (app/config.local.php), test uploads and logs, git data,
 * the review build and these tools. Because config.local.php is never included,
 * extracting a newer package does not touch the settings on the server.
 */

if (PHP_SAPI !== 'cli') {
    exit("Run this from the command line.\n");
}

$root = dirname(__DIR__);
$out  = $root . '/ashaparth-upload.zip';
@unlink($out);

$zip = new ZipArchive();
if ($zip->open($out, ZipArchive::CREATE) !== true) {
    exit("Could not create the zip file.\n");
}

$exclude = fn (string $path): bool =>
    $path === 'app/config.local.php'
    || preg_match('~^storage/logs/.+\.log$~', $path)
    || (strpos($path, 'storage/uploads/') === 0 && basename($path) !== '.gitkeep');

$count = 0;
foreach (['.htaccess', 'index.php'] as $file) {
    $zip->addFile("$root/$file", $file);
    $count++;
}
foreach (['app', 'assets', 'database', 'storage'] as $dir) {
    $items = new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$root/$dir", FilesystemIterator::SKIP_DOTS));
    foreach ($items as $item) {
        // Forward slashes matter: cPanel misreads zip paths containing backslashes.
        $path = str_replace('\\', '/', substr($item->getPathname(), strlen($root) + 1));
        if ($item->isFile() && !$exclude($path)) {
            $zip->addFile($item->getPathname(), $path);
            $count++;
        }
    }
}
$zip->close();

printf("Created ashaparth-upload.zip: %d files, %.1f KB\n", $count, filesize($out) / 1024);

<?php
/**
 * Copy this file to app/config.local.php and fill in real values.
 * config.local.php is git-ignored, so passwords never get committed.
 */

defined('APP_ROOT') || exit;

return [
    // 'production' hides PHP errors from visitors; 'development' shows them.
    'env' => 'production',

    // ── MySQL database ── (create it in cPanel > MySQL Databases on AquaHost)
    'db' => [
        'host'     => 'localhost',
        'port'     => 3306,
        'name'     => 'ashaparth_site',
        'user'     => 'ashaparth_user',
        'password' => 'CHANGE_ME',
    ],

    // ── Email ───────────────────────────────────────────────────────────
    // driver: 'smtp' (recommended), 'mail' (PHP mail()), or 'log' (writes
    // emails to storage/logs/mail.log; use for local testing only).
    'mail' => [
        'driver' => 'smtp',

        // Where enquiry notifications are delivered
        'notify_to' => 'ashishchaudhari05@gmail.com',

        // Option A: Gmail. Turn on 2-Step Verification for the Google account,
        // then create an App Password at https://myaccount.google.com/apppasswords
        'host'       => 'smtp.gmail.com',
        'port'       => 587,
        'encryption' => 'tls',          // 'tls' for 587, 'ssl' for 465, 'none' only for a trusted local relay
        'username'   => 'ashishchaudhari05@gmail.com',
        'password'   => 'xxxx xxxx xxxx xxxx', // 16-character Gmail App Password

        // Option B: a mailbox on your own domain at AquaHost, e.g.
        // 'host' => 'mail.yourdomain.com', 'port' => 465, 'encryption' => 'ssl',
        // 'username' => 'info@yourdomain.com', 'password' => '...'

        'from_email' => 'ashishchaudhari05@gmail.com', // must match username for Gmail
        'from_name'  => 'AshaParth AI Multiservices',
    ],
];

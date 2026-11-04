<?php
/**
 * Site-wide settings: business details, contact info, social links, stats.
 *
 * Secrets (database password, SMTP password) do NOT go here. Put them in
 * app/config.local.php (copy app/config.local.example.php).
 *
 * Anything marked TODO is a placeholder to replace with real information.
 */

defined('APP_ROOT') || exit;

return [
    // ── Business identity ───────────────────────────────────────────────
    'name'         => 'AshaParth AI Multiservices',
    'short_name'   => 'AshaParth AI',
    'legal_name'   => 'AshaParth AI Multiservices',
    'legal_type'   => 'Proprietorship',
    'tagline'      => 'Smart Digital Solutions That Grow Your Business',
    'home_title'   => 'Website & App Development Company in Jalgaon | AshaParth AI',
    'description'  => 'Digital agency in Amalner, Jalgaon: websites, mobile apps, AI automation, software, SEO, social media and temple live darshan. Get a free quote.',
    'founded_year' => 'XXXX', // TODO: year the business started
    'gst_number'   => '',     // Leave empty to hide. Example: '27ABCDE1234F1Z5'

    // Full public URL without trailing slash, e.g. 'https://www.yourdomain.com'.
    // Leave empty to auto-detect from the current request.
    // Once set, every visitor is redirected to this exact address, which gives
    // Google one version of each page. Activate SSL first if it starts with https.
    'site_url' => '',

    // ── Contact ─────────────────────────────────────────────────────────
    'phone'         => '+91 99239 33355',
    'phone_e164'    => '+919923933355',   // used for tel: links
    'whatsapp'      => '919923933355',    // country code + number, digits only
    'whatsapp_text' => 'Hello AshaParth AI, I would like to know more about your services.',
    'email'         => 'ashishchaudhari05@gmail.com', // shown on the website
    'hours'         => 'Mon–Sat, 10:00 AM – 7:00 PM (IST)',
    'hours_short'   => 'Mon–Sat 10 AM – 7 PM',

    'address' => [
        'line1'    => 'Vivekanand Tower',
        'city'     => 'Amalner',
        'district' => 'Jalgaon',
        'state'    => 'Maharashtra',
        'pincode'  => '425401',
        'country'  => 'India',
    ],
    // Google Maps search used for the embedded map and "Get directions" link
    'map_query' => 'Vivekanand Tower, Amalner, Jalgaon, Maharashtra 425401',

    // ── Social media ── TODO: replace '#' with real profile URLs ───────
    // Set a value to '' to hide that icon everywhere.
    'social' => [
        'youtube'   => '#',
        'facebook'  => '#',
        'instagram' => '#',
        'linkedin'  => '#',
    ],

    // ── Founders ── (shown on About page) ───────────────────────────────
    // TODO: add a photo path (e.g. 'assets/img/team/ashish.jpg') and a real bio for each.
    'founders' => [
        [
            'name'  => 'Ashish Chaudhari',
            'role'  => 'Founder',
            'photo' => '',
            'bio'   => '', // TODO: 1–2 line bio (leave empty to show a generic line)
        ],
        [
            'name'  => 'Vishakha Chaudhari',
            'role'  => 'Founder',
            'photo' => '',
            'bio'   => '', // TODO: 1–2 line bio (leave empty to show a generic line)
        ],
        [
            'name'  => 'Priya Chaudhari',
            'role'  => 'Founder',
            'photo' => '',
            'bio'   => '', // TODO: 1–2 line bio (leave empty to show a generic line)
        ],
    ],

    // ── Home page stats ── TODO: replace XX with real numbers ──────────
    'stats' => [
        ['value' => 'XX+', 'label' => 'Projects Delivered'],
        ['value' => 'XX+', 'label' => 'Happy Clients'],
        ['value' => 'XX+', 'label' => 'Temples Connected'],
        ['value' => 'XX+', 'label' => 'Years of Experience'],
    ],

    // ── Technologies we work with ── TODO: edit to match your real stack ─
    'technologies' => [
        'PHP', 'Laravel', 'WordPress', 'React', 'Node.js', 'Flutter',
        'Android', 'Python', 'OpenAI / LLMs', 'MySQL', 'Firebase', 'Razorpay',
        'YouTube Live', 'WhatsApp Business API', 'Google Ads', 'Meta Ads', 'Figma', 'Canva',
    ],

    // Show the testimonials section (currently sample entries in app/data/testimonials.php)
    'show_testimonials' => true,

    // ── Forms ───────────────────────────────────────────────────────────
    'forms' => [
        'rate_limit_max'     => 5,       // max submissions per form...
        'rate_limit_window'  => 1800,    // ...per IP within this many seconds (30 min)
        'min_fill_seconds'   => 3,       // submissions faster than this are treated as bots
        'max_upload_mb'      => 5,
    ],
];

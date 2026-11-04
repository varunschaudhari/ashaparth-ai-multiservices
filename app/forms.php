<?php
/**
 * Form option lists, validation, spam protection, uploads and the four
 * form handlers: contact, quote, careers, temple registration.
 *
 * Flow for every form:
 *   guard (CSRF, honeypot, time-trap, rate limit) → validate → upload
 *   → save to MySQL → email owner → auto-reply customer → redirect to /thank-you
 */

defined('APP_ROOT') || exit;

// ── Option lists (used by both forms and validation) ───────────────────

function contact_subjects(): array
{
    $list = array_map(fn ($s) => $s['title'], services());
    return array_merge(array_values($list), ['Temple Solutions / Live Darshan', 'Maharashtra Devasthan Live', 'Partnership', 'Other']);
}

function quote_services(): array
{
    $list = array_map(fn ($s) => $s['title'], services());
    return array_merge(array_values($list), ['Temple Digital Solutions']);
}

function budget_options(): array
{
    return [
        'INR (₹)' => [
            'Under ₹25,000',
            '₹25,000 – ₹75,000',
            '₹75,000 – ₹2,00,000',
            '₹2,00,000 – ₹5,00,000',
            'Above ₹5,00,000',
        ],
        'USD ($)' => [
            'Under $1,000',
            '$1,000 – $3,000',
            '$3,000 – $10,000',
            '$10,000 – $25,000',
            'Above $25,000',
        ],
        'Other' => ['Not sure yet'],
    ];
}

function budget_values(): array
{
    return array_merge(...array_values(budget_options()));
}

function timeline_options(): array
{
    return ['As soon as possible (within 2 weeks)', 'Within 1 month', '1 – 3 months', '3+ months', 'Flexible / not decided'];
}

function contact_methods(): array
{
    return ['WhatsApp', 'Phone call', 'Email'];
}

function referral_sources(): array
{
    return ['Google search', 'Instagram', 'Facebook', 'YouTube', 'LinkedIn', 'Friend / referral', 'Poster / visiting card', 'Other'];
}

function career_positions(): array
{
    return [
        'Web Developer (PHP / Laravel)',
        'Front-end Developer (React)',
        'Mobile App Developer',
        'AI / Automation Engineer',
        'UI/UX & Graphic Designer',
        'SEO / Digital Marketing Executive',
        'Social Media Manager',
        'Video Editor / Live Streaming Operator',
        'Sales & Business Development',
        'Internship',
        'Other',
    ];
}

function experience_options(): array
{
    return ['Fresher', 'Less than 1 year', '1 – 3 years', '3 – 5 years', '5+ years'];
}

function maharashtra_districts(): array
{
    return [
        'Ahilyanagar (Ahmednagar)', 'Akola', 'Amravati', 'Beed', 'Bhandara', 'Buldhana', 'Chandrapur',
        'Chhatrapati Sambhajinagar (Aurangabad)', 'Dharashiv (Osmanabad)', 'Dhule', 'Gadchiroli', 'Gondia',
        'Hingoli', 'Jalgaon', 'Jalna', 'Kolhapur', 'Latur', 'Mumbai City', 'Mumbai Suburban', 'Nagpur',
        'Nanded', 'Nandurbar', 'Nashik', 'Palghar', 'Parbhani', 'Pune', 'Raigad', 'Ratnagiri', 'Sangli',
        'Satara', 'Sindhudurg', 'Solapur', 'Thane', 'Wardha', 'Washim', 'Yavatmal', 'Outside Maharashtra',
    ];
}

function temple_designations(): array
{
    return ['Trustee', 'Chairman / President', 'Secretary', 'Treasurer', 'Committee Member', 'Pujari / Priest', 'Temple Manager', 'Devotee / Volunteer', 'Other'];
}

function temple_services(): array
{
    return [
        '24x7 Live Darshan',
        'Aarti & Festival Live Streaming',
        'HD Camera Setup',
        'Temple Website',
        'Mobile App',
        'Online Donations',
        'Pooja / Abhishek Booking',
        'Temple Management Software',
        'Social Media Management',
        'Event Promotion',
    ];
}

// ── Sanitising & validation ────────────────────────────────────────────

function clean_text($value, int $max = 255): string
{
    if (is_array($value)) {
        return '';
    }
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', (string) $value) ?? '';
    $value = trim(preg_replace('/\s+/u', ' ', $value) ?? '');
    return mb_substr($value, 0, $max);
}

function clean_multiline($value, int $max = 5000): string
{
    if (is_array($value)) {
        return '';
    }
    $value = str_replace(["\r\n", "\r"], "\n", (string) $value);
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value) ?? '';
    $value = preg_replace("/\n{3,}/", "\n\n", trim($value)) ?? '';
    return mb_substr($value, 0, $max);
}

/**
 * Validate $input against $rules.
 *
 * Rule keys per field: label, required, type (text|multiline|email|phone|url|select|checkboxes),
 * max, min, options (for select/checkboxes).
 *
 * @return array{0: array, 1: array} [clean values, errors]
 */
function validate(array $input, array $rules): array
{
    $clean  = [];
    $errors = [];

    foreach ($rules as $field => $r) {
        $label = $r['label'];
        $type  = $r['type'] ?? 'text';
        $max   = $r['max'] ?? ($type === 'multiline' ? 5000 : 255);
        $raw   = $input[$field] ?? null;

        if ($type === 'checkboxes') {
            $vals  = is_array($raw) ? array_values(array_filter(array_map(fn ($v) => clean_text($v), $raw))) : [];
            $vals  = array_values(array_intersect($vals, $r['options']));
            $clean[$field] = $vals;
            if (!empty($r['required']) && !$vals) {
                $errors[$field] = 'Please select at least one option.';
            }
            continue;
        }

        $value = $type === 'multiline' ? clean_multiline($raw, $max) : clean_text($raw, $max);
        $clean[$field] = $value;

        if ($value === '') {
            if (!empty($r['required'])) {
                $errors[$field] = $label . ' is required.';
            }
            continue;
        }

        if (isset($r['min']) && mb_strlen($value) < $r['min']) {
            $errors[$field] = $label . ' must be at least ' . $r['min'] . ' characters.';
            continue;
        }

        switch ($type) {
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field] = 'Please enter a valid email address.';
                }
                break;
            case 'phone':
                $digits = preg_replace('/\D/', '', $value);
                if (!preg_match('/^[+0-9 ()\-]{7,20}$/', $value) || strlen($digits) < 7 || strlen($digits) > 15) {
                    $errors[$field] = 'Please enter a valid phone number (with country code if outside India).';
                }
                break;
            case 'url':
                if (!preg_match('~^https?://~i', $value)) {
                    $value = 'https://' . $value;
                    $clean[$field] = $value;
                }
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    $errors[$field] = 'Please enter a valid link.';
                }
                break;
            case 'select':
                if (!in_array($value, $r['options'], true)) {
                    $errors[$field] = 'Please choose a valid option for ' . strtolower($label) . '.';
                }
                break;
        }
    }

    return [$clean, $errors];
}

// ── Spam protection ────────────────────────────────────────────────────

/** Record form state so the page can redisplay values and errors. */
function form_fail(array $old, array $errors): void
{
    $GLOBALS['__form_old']    = $old;
    $GLOBALS['__form_errors'] = $errors;
    http_response_code(422);
}

function form_error_message(): string
{
    return $GLOBALS['__form_errors']['_form'] ?? '';
}

function form_has_errors(): bool
{
    return !empty($GLOBALS['__form_errors']);
}

/**
 * Run CSRF, honeypot, time-trap and rate-limit checks.
 * Returns true if the submission may proceed. Bots are silently sent to
 * the thank-you page so they get no signal.
 */
function form_guard(string $form): bool
{
    $token = $_POST['_token'] ?? '';
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        form_fail($_POST, ['_form' => 'Your session expired. Please check your details and submit the form again.']);
        return false;
    }

    // Honeypot: real visitors never see or fill this field.
    if (!empty($_POST['website_url'])) {
        app_log('spam', "$form honeypot from " . client_ip());
        redirect('thank-you?type=' . $form);
    }

    // Time-trap: the form must have been open for a few seconds.
    [$issued, $sig] = array_pad(explode('.', (string) ($_POST['_ts'] ?? ''), 2), 2, '');
    $validSig = ctype_digit($issued) && hash_equals(hash_hmac('sha256', $issued, csrf_token()), $sig);
    if (!$validSig || (time() - (int) $issued) < (int) config('forms.min_fill_seconds', 3)) {
        app_log('spam', "$form time-trap from " . client_ip());
        redirect('thank-you?type=' . $form);
    }

    if (rate_limited($form)) {
        form_fail($_POST, ['_form' => 'You have sent several requests in a short time. Please try again in a little while, or reach us directly on WhatsApp or phone.']);
        return false;
    }

    return true;
}

function rate_limited(string $form): bool
{
    $max    = (int) config('forms.rate_limit_max', 5);
    $window = (int) config('forms.rate_limit_window', 1800);
    $since  = time() - $window;

    if ($pdo = db()) {
        try {
            if (random_int(1, 20) === 1) {
                $pdo->prepare('DELETE FROM rate_limits WHERE created_at < ?')->execute([date('Y-m-d H:i:s', time() - 86400)]);
            }
            $stmt = $pdo->prepare('SELECT COUNT(*) FROM rate_limits WHERE ip = ? AND form = ? AND created_at >= ?');
            $stmt->execute([client_ip(), $form, date('Y-m-d H:i:s', $since)]);
            return (int) $stmt->fetchColumn() >= $max;
        } catch (PDOException $ex) {
            app_log('db', 'Rate limit check failed: ' . $ex->getMessage());
        }
    }

    // Fallback when the database is unavailable: per-session counter.
    $hits = array_filter($_SESSION['_rate'][$form] ?? [], fn ($t) => $t >= $since);
    $_SESSION['_rate'][$form] = $hits;
    return count($hits) >= $max;
}

function rate_hit(string $form): void
{
    $_SESSION['_rate'][$form][] = time();
    if ($pdo = db()) {
        try {
            $pdo->prepare('INSERT INTO rate_limits (ip, form, created_at) VALUES (?, ?, ?)')
                ->execute([client_ip(), $form, date('Y-m-d H:i:s')]);
        } catch (PDOException $ex) {
            app_log('db', 'Rate limit insert failed: ' . $ex->getMessage());
        }
    }
}

// ── Uploads ────────────────────────────────────────────────────────────

function upload_mime_map(): array
{
    $ole  = ['application/msword', 'application/vnd.ms-office', 'application/CDFV2', 'application/x-ole-storage', 'application/octet-stream'];
    $ooxml = ['application/zip', 'application/octet-stream'];
    return [
        'pdf'  => ['application/pdf'],
        'doc'  => $ole,
        'docx' => array_merge(['application/vnd.openxmlformats-officedocument.wordprocessingml.document'], $ooxml),
        'xls'  => array_merge(['application/vnd.ms-excel'], $ole),
        'xlsx' => array_merge(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'], $ooxml),
        'ppt'  => array_merge(['application/vnd.ms-powerpoint'], $ole),
        'pptx' => array_merge(['application/vnd.openxmlformats-officedocument.presentationml.presentation'], $ooxml),
        'jpg'  => ['image/jpeg'],
        'jpeg' => ['image/jpeg'],
        'png'  => ['image/png'],
    ];
}

/**
 * Validate and store an uploaded file outside public access.
 *
 * @return array{path: ?string, name: ?string, error: ?string}
 */
function handle_upload(string $field, array $allowedExt, bool $required, string $subdir): array
{
    $none = ['path' => null, 'name' => null, 'error' => null];
    $file = $_FILES[$field] ?? null;

    if (!$file || !is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return $required ? ['error' => 'Please attach a file.'] + $none : $none;
    }
    if (is_array($file['error'])) {
        return ['error' => 'Please attach a single file.'] + $none;
    }

    $maxMb = (int) config('forms.max_upload_mb', 5);
    if (in_array($file['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true) || $file['size'] > $maxMb * 1024 * 1024) {
        return ['error' => "The file is too large. Maximum size is {$maxMb} MB."] + $none;
    }
    if ($file['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($file['tmp_name'])) {
        return ['error' => 'The file could not be uploaded. Please try again.'] + $none;
    }

    $original = basename((string) $file['name']);
    $ext      = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    $map      = upload_mime_map();
    if (!in_array($ext, $allowedExt, true) || !isset($map[$ext])) {
        return ['error' => 'Allowed file types: ' . strtoupper(implode(', ', $allowedExt)) . '.'] + $none;
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']) ?: '';
    if (!in_array($mime, $map[$ext], true)) {
        return ['error' => 'This file does not look like a valid ' . strtoupper($ext) . ' file.'] + $none;
    }

    $dir = STORAGE_DIR . '/uploads/' . $subdir . '/' . date('Y-m');
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        app_log('upload', "Could not create $dir");
        return ['error' => 'The file could not be saved. Please email it to us instead.'] + $none;
    }

    $stored = $dir . '/' . date('Ymd-His') . '-' . bin2hex(random_bytes(6)) . '.' . $ext;
    if (!move_uploaded_file($file['tmp_name'], $stored)) {
        app_log('upload', "move_uploaded_file failed for $stored");
        return ['error' => 'The file could not be saved. Please email it to us instead.'] + $none;
    }

    $safeName = preg_replace('/[^A-Za-z0-9._ -]/', '_', $original) ?: ('attachment.' . $ext);
    return ['path' => $stored, 'name' => mb_substr($safeName, 0, 150), 'error' => null];
}

/** Path stored in the DB, relative to the project root. */
function relative_storage_path(?string $abs): ?string
{
    return $abs ? ltrim(str_replace([APP_ROOT, '\\'], ['', '/'], $abs), '/') : null;
}

/** Save + email. Returns false only if BOTH the DB save and the owner email failed. */
function deliver_submission(string $table, array $row, string $subject, string $heading, array $emailFields, string $email, string $name, array $attachments = []): bool
{
    $row['ip_address'] = client_ip();
    $row['user_agent'] = mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 255);
    $row['created_at'] = date('Y-m-d H:i:s');

    $id = db_insert($table, $row);
    if ($id) {
        $subject .= ' #' . $id;
    }
    $mailed = notify_owner($subject, $heading, $emailFields, $email, $name, $attachments);

    if (!$id && !$mailed) {
        app_log('forms', "Delivery failed for $table: " . json_encode($row, JSON_UNESCAPED_UNICODE));
        return false;
    }
    return true;
}

function delivery_failed_message(): string
{
    return 'Sorry, we could not send your message right now. Please call or WhatsApp us on ' . config('phone') . ', or email ' . config('email') . '.';
}

// ── Handlers ───────────────────────────────────────────────────────────

function handle_contact_form(): void
{
    if (!form_guard('contact')) {
        return;
    }

    [$d, $errors] = validate($_POST, [
        'name'    => ['label' => 'Your name', 'required' => true, 'max' => 100, 'min' => 2],
        'email'   => ['label' => 'Email', 'required' => true, 'type' => 'email', 'max' => 150],
        'phone'   => ['label' => 'Phone', 'required' => true, 'type' => 'phone', 'max' => 20],
        'subject' => ['label' => 'Subject', 'required' => true, 'type' => 'select', 'options' => contact_subjects()],
        'message' => ['label' => 'Message', 'required' => true, 'type' => 'multiline', 'max' => 3000, 'min' => 10],
    ]);
    if ($errors) {
        form_fail($d, $errors);
        return;
    }

    rate_hit('contact');
    $ok = deliver_submission(
        'contact_enquiries',
        ['name' => $d['name'], 'email' => $d['email'], 'phone' => $d['phone'], 'subject' => $d['subject'], 'message' => $d['message']],
        'New enquiry: ' . $d['subject'] . ' – ' . $d['name'],
        'Contact Enquiry',
        ['Name' => $d['name'], 'Email' => $d['email'], 'Phone' => $d['phone'], 'Subject' => $d['subject'], 'Message' => $d['message']],
        $d['email'],
        $d['name']
    );
    if (!$ok) {
        form_fail($d, ['_form' => delivery_failed_message()]);
        return;
    }

    send_auto_reply($d['email'], $d['name'], 'We received your enquiry – AshaParth AI Multiservices', 'enquiry');
    redirect('thank-you?type=contact');
}

function handle_quote_form(): void
{
    if (!form_guard('quote')) {
        return;
    }

    [$d, $errors] = validate($_POST, [
        'name'           => ['label' => 'Your name', 'required' => true, 'max' => 100, 'min' => 2],
        'email'          => ['label' => 'Email', 'required' => true, 'type' => 'email', 'max' => 150],
        'phone'          => ['label' => 'Phone / WhatsApp', 'required' => true, 'type' => 'phone', 'max' => 20],
        'company'        => ['label' => 'Company / organisation', 'max' => 150],
        'country'        => ['label' => 'Country / city', 'required' => true, 'max' => 100],
        'services'       => ['label' => 'Services', 'required' => true, 'type' => 'checkboxes', 'options' => quote_services()],
        'budget'         => ['label' => 'Budget', 'required' => true, 'type' => 'select', 'options' => budget_values()],
        'timeline'       => ['label' => 'Timeline', 'required' => true, 'type' => 'select', 'options' => timeline_options()],
        'details'        => ['label' => 'Project details', 'required' => true, 'type' => 'multiline', 'max' => 5000, 'min' => 20],
        'contact_method' => ['label' => 'Preferred contact method', 'type' => 'select', 'options' => contact_methods()],
        'referral'       => ['label' => 'How you heard about us', 'type' => 'select', 'options' => referral_sources()],
    ]);

    $upload = ['path' => null, 'name' => null, 'error' => null];
    if (!$errors) {
        $upload = handle_upload('attachment', ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png'], false, 'quotes');
        if ($upload['error']) {
            $errors['attachment'] = $upload['error'];
        }
    }
    if ($errors) {
        form_fail($d, $errors);
        return;
    }

    rate_hit('quote');
    $services = implode(', ', $d['services']);
    $ok = deliver_submission(
        'quote_requests',
        [
            'name' => $d['name'], 'email' => $d['email'], 'phone' => $d['phone'], 'company' => $d['company'],
            'country' => $d['country'], 'services' => $services, 'budget' => $d['budget'], 'timeline' => $d['timeline'],
            'details' => $d['details'], 'contact_method' => $d['contact_method'], 'referral' => $d['referral'],
            'attachment_path' => relative_storage_path($upload['path']), 'attachment_name' => $upload['name'],
        ],
        'Quote request: ' . $services . ' – ' . $d['name'],
        'Quote Request',
        [
            'Name' => $d['name'], 'Email' => $d['email'], 'Phone / WhatsApp' => $d['phone'], 'Company' => $d['company'],
            'Country / City' => $d['country'], 'Services' => $services, 'Budget' => $d['budget'], 'Timeline' => $d['timeline'],
            'Preferred contact' => $d['contact_method'], 'Heard about us via' => $d['referral'], 'Project details' => $d['details'],
            'Attachment' => $upload['name'] ? $upload['name'] . ' (attached)' : '',
        ],
        $d['email'],
        $d['name'],
        $upload['path'] ? [[$upload['path'], $upload['name']]] : []
    );
    if (!$ok) {
        form_fail($d, ['_form' => delivery_failed_message()]);
        return;
    }

    send_auto_reply($d['email'], $d['name'], 'We received your quote request – AshaParth AI Multiservices', 'quote request');
    redirect('thank-you?type=quote');
}

function handle_career_form(): void
{
    if (!form_guard('career')) {
        return;
    }

    [$d, $errors] = validate($_POST, [
        'name'          => ['label' => 'Full name', 'required' => true, 'max' => 100, 'min' => 2],
        'email'         => ['label' => 'Email', 'required' => true, 'type' => 'email', 'max' => 150],
        'phone'         => ['label' => 'Phone', 'required' => true, 'type' => 'phone', 'max' => 20],
        'city'          => ['label' => 'Current city', 'required' => true, 'max' => 100],
        'position'      => ['label' => 'Position', 'required' => true, 'type' => 'select', 'options' => career_positions()],
        'experience'    => ['label' => 'Experience', 'required' => true, 'type' => 'select', 'options' => experience_options()],
        'portfolio_url' => ['label' => 'Portfolio / LinkedIn', 'type' => 'url', 'max' => 255],
        'cover_note'    => ['label' => 'About you', 'type' => 'multiline', 'max' => 3000],
    ]);

    $upload = ['path' => null, 'name' => null, 'error' => null];
    if (!$errors) {
        $upload = handle_upload('resume', ['pdf', 'doc', 'docx'], true, 'resumes');
        if ($upload['error']) {
            $errors['resume'] = $upload['error'];
        }
    }
    if ($errors) {
        form_fail($d, $errors);
        return;
    }

    rate_hit('career');
    $ok = deliver_submission(
        'career_applications',
        [
            'name' => $d['name'], 'email' => $d['email'], 'phone' => $d['phone'], 'city' => $d['city'],
            'position' => $d['position'], 'experience' => $d['experience'], 'portfolio_url' => $d['portfolio_url'],
            'cover_note' => $d['cover_note'], 'resume_path' => relative_storage_path($upload['path']), 'resume_name' => $upload['name'],
        ],
        'Job application: ' . $d['position'] . ' – ' . $d['name'],
        'Career Application',
        [
            'Name' => $d['name'], 'Email' => $d['email'], 'Phone' => $d['phone'], 'City' => $d['city'],
            'Position' => $d['position'], 'Experience' => $d['experience'], 'Portfolio / LinkedIn' => $d['portfolio_url'],
            'About the applicant' => $d['cover_note'], 'Resume' => $upload['name'] . ' (attached)',
        ],
        $d['email'],
        $d['name'],
        [[$upload['path'], $upload['name']]]
    );
    if (!$ok) {
        form_fail($d, ['_form' => delivery_failed_message()]);
        return;
    }

    send_auto_reply($d['email'], $d['name'], 'Application received – AshaParth AI Multiservices', 'job application');
    redirect('thank-you?type=career');
}

function handle_temple_form(): void
{
    if (!form_guard('temple')) {
        return;
    }

    [$d, $errors] = validate($_POST, [
        'temple_name'  => ['label' => 'Temple name', 'required' => true, 'max' => 150, 'min' => 3],
        'deity'        => ['label' => 'Main deity', 'max' => 100],
        'village_city' => ['label' => 'Village / city', 'required' => true, 'max' => 100],
        'taluka'       => ['label' => 'Taluka', 'max' => 100],
        'district'     => ['label' => 'District', 'required' => true, 'type' => 'select', 'options' => maharashtra_districts()],
        'contact_name' => ['label' => 'Your name', 'required' => true, 'max' => 100, 'min' => 2],
        'designation'  => ['label' => 'Designation', 'required' => true, 'type' => 'select', 'options' => temple_designations()],
        'phone'        => ['label' => 'Mobile number', 'required' => true, 'type' => 'phone', 'max' => 20],
        'email'        => ['label' => 'Email', 'type' => 'email', 'max' => 150],
        'services'     => ['label' => 'Services', 'required' => true, 'type' => 'checkboxes', 'options' => temple_services()],
        'existing_url' => ['label' => 'Existing YouTube / Facebook page', 'type' => 'url', 'max' => 255],
        'message'      => ['label' => 'Message', 'type' => 'multiline', 'max' => 3000],
    ]);
    if ($errors) {
        form_fail($d, $errors);
        return;
    }

    rate_hit('temple');
    $services = implode(', ', $d['services']);
    $ok = deliver_submission(
        'temple_registrations',
        [
            'temple_name' => $d['temple_name'], 'deity' => $d['deity'], 'village_city' => $d['village_city'],
            'taluka' => $d['taluka'], 'district' => $d['district'], 'contact_name' => $d['contact_name'],
            'designation' => $d['designation'], 'phone' => $d['phone'], 'email' => $d['email'],
            'services' => $services, 'existing_url' => $d['existing_url'], 'message' => $d['message'],
        ],
        'Temple registration: ' . $d['temple_name'] . ', ' . $d['district'],
        'Devasthan Live – Temple Registration',
        [
            'Temple' => $d['temple_name'], 'Main deity' => $d['deity'], 'Village / City' => $d['village_city'],
            'Taluka' => $d['taluka'], 'District' => $d['district'], 'Contact person' => $d['contact_name'],
            'Designation' => $d['designation'], 'Mobile' => $d['phone'], 'Email' => $d['email'],
            'Services wanted' => $services, 'Existing page' => $d['existing_url'], 'Message' => $d['message'],
        ],
        $d['email'] ?: (string) config('mail.notify_to', config('email')),
        $d['contact_name']
    );
    if (!$ok) {
        form_fail($d, ['_form' => delivery_failed_message()]);
        return;
    }

    if ($d['email']) {
        send_auto_reply($d['email'], $d['contact_name'], 'Temple registration received – Maharashtra Devasthan Live', 'temple registration');
    }
    redirect('thank-you?type=temple');
}

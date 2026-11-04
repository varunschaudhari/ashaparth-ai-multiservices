<?php
/**
 * Email sending via PHPMailer (bundled in app/lib/PHPMailer) and the
 * HTML templates for owner notifications and customer auto-replies.
 */

defined('APP_ROOT') || exit;

require_once APP_DIR . '/lib/PHPMailer/Exception.php';
require_once APP_DIR . '/lib/PHPMailer/PHPMailer.php';
require_once APP_DIR . '/lib/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;

/**
 * Send an email. Returns true on success.
 *
 * $opts: to, to_name, subject, html, text, reply_to, reply_to_name, attachments (array of [path, name])
 */
function send_mail(array $opts): bool
{
    $cfg    = config('mail', []);
    $driver = $cfg['driver'] ?? 'log';

    if ($driver === 'log') {
        $entry = str_repeat('=', 70) . PHP_EOL
            . 'Date: ' . date('r') . PHP_EOL
            . 'To: ' . $opts['to'] . PHP_EOL
            . 'Reply-To: ' . ($opts['reply_to'] ?? '-') . PHP_EOL
            . 'Subject: ' . $opts['subject'] . PHP_EOL
            . 'Attachments: ' . implode(', ', array_map(fn ($a) => $a[1], $opts['attachments'] ?? [])) . PHP_EOL . PHP_EOL
            . ($opts['text'] ?? strip_tags($opts['html'])) . PHP_EOL;
        @file_put_contents(STORAGE_DIR . '/logs/mail.log', $entry, FILE_APPEND | LOCK_EX);
        return true;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = PHPMailer::CHARSET_UTF8;

        if ($driver === 'smtp') {
            $mail->isSMTP();
            $mail->Host       = $cfg['host'] ?? '';
            $mail->Port       = (int) ($cfg['port'] ?? 587);
            $mail->SMTPAuth   = true;
            $mail->Username   = $cfg['username'] ?? '';
            $mail->Password   = $cfg['password'] ?? '';
            $mail->Timeout    = 15;

            $encryption = $cfg['encryption'] ?? 'tls';
            if ($encryption === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($encryption === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                // 'none': only for a trusted local relay
                $mail->SMTPSecure = '';
                $mail->SMTPAutoTLS = false;
            }
        } else {
            $mail->isMail();
        }

        $mail->setFrom($cfg['from_email'] ?? config('email'), $cfg['from_name'] ?? config('name'));
        $mail->addAddress($opts['to'], $opts['to_name'] ?? '');
        if (!empty($opts['reply_to'])) {
            $mail->addReplyTo($opts['reply_to'], $opts['reply_to_name'] ?? '');
        }
        foreach ($opts['attachments'] ?? [] as [$path, $name]) {
            if (is_file($path)) {
                $mail->addAttachment($path, $name);
            }
        }

        $mail->isHTML(true);
        $mail->Subject = $opts['subject'];
        $mail->Body    = $opts['html'];
        $mail->AltBody = $opts['text'] ?? trim(html_entity_decode(strip_tags(str_replace(['<br>', '</tr>', '</p>'], "\n", $opts['html']))));

        $mail->send();
        return true;
    } catch (MailException $ex) {
        app_log('mail', 'Send failed to ' . $opts['to'] . ': ' . $mail->ErrorInfo);
        return false;
    }
}

/** Wrap content in the branded email layout. */
function email_layout(string $heading, string $bodyHtml): string
{
    $name    = e(config('name'));
    $phone   = e(config('phone'));
    $email   = e(config('email'));
    $address = e(full_address());
    $site    = e(absolute_url());

    return <<<HTML
<!DOCTYPE html>
<html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width"></head>
<body style="margin:0;padding:0;background:#f5f2ee;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f2ee;padding:24px 12px;">
<tr><td align="center">
<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;background:#ffffff;border-radius:12px;overflow:hidden;">
<tr><td style="background:#7a1d2b;padding:22px 28px;">
  <div style="font-size:20px;font-weight:bold;color:#ffffff;">{$name}</div>
  <div style="font-size:13px;color:#f6c77c;margin-top:4px;">{$heading}</div>
</td></tr>
<tr><td style="height:4px;background:#e8740c;"></td></tr>
<tr><td style="padding:28px;font-size:15px;line-height:1.6;">{$bodyHtml}</td></tr>
<tr><td style="padding:18px 28px;background:#faf7f2;font-size:12px;color:#6b7280;line-height:1.6;">
  {$name} · {$address}<br>📞 {$phone} · ✉️ {$email} · <a href="{$site}" style="color:#7a1d2b;">{$site}</a>
</td></tr>
</table>
</td></tr></table>
</body></html>
HTML;
}

/** Build a two-column table of submitted fields. */
function email_fields_table(array $fields): string
{
    $rows = '';
    foreach ($fields as $label => $value) {
        if ($value === '' || $value === null || $value === []) {
            continue;
        }
        if (is_array($value)) {
            $value = implode(', ', $value);
        }
        $rows .= '<tr>'
            . '<td style="padding:8px 10px;border-bottom:1px solid #eee;color:#6b7280;width:38%;vertical-align:top;">' . e($label) . '</td>'
            . '<td style="padding:8px 10px;border-bottom:1px solid #eee;vertical-align:top;">' . nl2br(e($value)) . '</td>'
            . '</tr>';
    }
    return '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;font-size:14px;">' . $rows . '</table>';
}

/** Notify the business owner about a new submission. */
function notify_owner(string $subject, string $heading, array $fields, string $replyTo, string $replyName, array $attachments = []): bool
{
    $intro = '<p style="margin:0 0 16px;">A new <strong>' . e($heading) . '</strong> was submitted on the website on ' . e(date('j M Y, g:i A')) . ' IST.</p>';
    $reply = '<p style="margin:18px 0 0;font-size:13px;color:#6b7280;">Reply to this email to respond directly to ' . e($replyName) . '.</p>';

    return send_mail([
        'to'            => config('mail.notify_to', config('email')),
        'subject'       => $subject,
        'html'          => email_layout($heading, $intro . email_fields_table($fields) . $reply),
        'reply_to'      => $replyTo,
        'reply_to_name' => $replyName,
        'attachments'   => $attachments,
    ]);
}

/** Send the "thanks, we received it" auto-reply to the customer. */
function send_auto_reply(string $toEmail, string $toName, string $subject, string $what): bool
{
    if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    $first = e(explode(' ', trim($toName))[0] ?: 'there');
    $wa    = e(whatsapp_url());
    $phone = e(config('phone'));
    $hours = e(config('hours'));
    $what  = e($what);

    $body = <<<HTML
<p style="margin:0 0 14px;">Namaste {$first},</p>
<p style="margin:0 0 14px;">Thank you for contacting <strong>AshaParth AI Multiservices</strong>. We have received your {$what} and a member of our team will get back to you within <strong>24 working hours</strong>.</p>
<p style="margin:0 0 14px;">Need a faster response? Call us on <strong>{$phone}</strong> or message us on WhatsApp.</p>
<p style="margin:22px 0;"><a href="{$wa}" style="background:#25d366;color:#ffffff;text-decoration:none;padding:12px 22px;border-radius:8px;font-weight:bold;display:inline-block;">Chat on WhatsApp</a></p>
<p style="margin:0 0 4px;font-size:13px;color:#6b7280;">Working hours: {$hours}</p>
<p style="margin:18px 0 0;">Warm regards,<br><strong>Team AshaParth AI</strong></p>
<p style="margin:18px 0 0;font-size:12px;color:#9ca3af;">This is an automatic confirmation. Please do not share passwords or payment details over email.</p>
HTML;

    return send_mail([
        'to'      => $toEmail,
        'to_name' => $toName,
        'subject' => $subject,
        'html'    => email_layout('We received your ' . $what, $body),
    ]);
}

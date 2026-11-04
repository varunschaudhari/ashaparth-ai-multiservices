<?php
/**
 * Sample resume website, linked from /services/resume-website.
 * Stands alone without the site header so it looks like a customer's own page.
 * The person shown is fictional. Hidden from search engines.
 */
defined('APP_ROOT') || exit;

$experience = [
    ['Senior Accounts Executive', 'Sample Traders Pvt Ltd, Pune', '2023 – Present', 'Manage billing, GST returns and monthly reports for a team of five.'],
    ['Accounts Assistant', 'Sample Enterprises, Nashik', '2020 – 2023', 'Handled invoices, vendor payments and bank reconciliation in Tally.'],
];
$education = [
    ['M.Com, Accounting', 'Sample University', '2020'],
    ['B.Com', 'Sample College, Jalgaon', '2018'],
];
$skills = ['Tally Prime', 'GST Filing', 'Advanced Excel', 'Bank Reconciliation', 'Payroll', 'Financial Reports'];
$achievements = ['Cut month-end closing time by streamlining reports', 'Trained two junior staff on Tally and GST', 'Certified in Advanced Excel'];
$languages = ['English', 'Marathi', 'Hindi'];
?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title>Sample Resume Website | AshaParth AI</title>
<link rel="icon" href="<?= e(asset('img/favicon.svg')) ?>" type="image/svg+xml">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
<style>
  body { background: var(--bg-soft); }
  .demo-ribbon { background: var(--maroon); color: #fff; padding: 10px 18px; display: flex; flex-wrap: wrap; gap: 8px 16px; align-items: center; justify-content: center; font-size: .9rem; font-weight: 600; }
  .demo-ribbon a { color: var(--gold-light); text-decoration: underline; }
  .resume { max-width: 860px; margin: 32px auto 56px; padding: 0 18px; }
  .resume-card { background: #fff; border: 1px solid var(--border); border-radius: var(--radius-lg); box-shadow: var(--shadow); overflow: hidden; }
  .resume-head { padding: 40px; color: #fff; display: flex; gap: 26px; align-items: center; background: linear-gradient(120deg, var(--maroon), #a3301f 65%, var(--saffron)); }
  .resume-head .avatar { width: 112px; height: 112px; font-size: 2.3rem; border: 4px solid rgba(255, 255, 255, .55); }
  .resume-head h1 { color: #fff; font-size: clamp(1.8rem, 4vw, 2.5rem); margin-bottom: 4px; }
  .resume-head p { margin: 0; color: rgba(255, 255, 255, .9); font-size: 1.08rem; }
  .resume-actions { display: flex; flex-wrap: wrap; gap: 10px; padding: 18px 40px; border-bottom: 1px solid var(--border); }
  .resume-body { padding: 8px 40px 36px; }
  .resume-body h2 { font-size: 1.2rem; margin: 28px 0 14px; padding-bottom: 8px; border-bottom: 2px solid var(--saffron-50); }
  .job { margin-bottom: 18px; }
  .job strong { display: block; font-size: 1.02rem; }
  .job small { display: block; color: var(--muted); margin-bottom: 4px; }
  .job p { margin: 0; }
  .resume-foot { text-align: center; margin-top: 18px; font-size: .85rem; color: var(--muted); }
  @media (max-width: 600px) {
    .resume-head { flex-direction: column; text-align: center; padding: 30px 20px; }
    .resume-actions, .resume-body { padding-left: 20px; padding-right: 20px; }
    .resume-actions .btn { flex: 1 1 100%; }
  }
  @page { margin: 12mm; }
  @media print {
    html { font-size: 13px; }
    body { background: #fff; font-size: 13px; line-height: 1.5; }
    .demo-ribbon, .resume-actions, .resume-foot, .review-bar { display: none !important; }
    .resume { margin: 0; max-width: none; padding: 0; }
    .resume-card { border: 0; box-shadow: none; }
    /* Browsers drop background colours when printing, so white text would vanish. */
    .resume-head { background: none; color: var(--ink); padding: 0 0 14px; border-bottom: 2px solid var(--maroon); }
    .resume-head h1 { color: var(--maroon); }
    .resume-head p { color: var(--text); }
    .resume-head .avatar { display: none; }
    .resume-body { padding: 0; }
    .resume-body h2 { margin-top: 18px; }
    .job, .check-list li, .chip { break-inside: avoid; }
  }
</style>
</head>
<body>
<div class="demo-ribbon">
  <span>This is a sample with a made-up person. Yours will have your own details.</span>
  <a href="<?= e(whatsapp_url('Hello AshaParth AI, I saw the sample and I want a resume website like this.')) ?>" target="_blank" rel="noopener">Get one like this</a>
  <a href="<?= e(url('services/resume-website')) ?>">Back to the service</a>
</div>

<main class="resume">
  <div class="resume-card">
    <header class="resume-head">
      <span class="avatar" aria-hidden="true">AK</span>
      <div>
        <h1>Aditi Kulkarni</h1>
        <p>Accounts Executive · Pune, Maharashtra</p>
      </div>
    </header>

    <div class="resume-actions">
      <button class="btn btn-primary btn-sm" type="button" onclick="window.print()"><i class="bi bi-file-earmark-arrow-down" aria-hidden="true"></i> Download Resume (PDF)</button>
      <span class="btn btn-whatsapp btn-sm"><i class="bi bi-whatsapp" aria-hidden="true"></i> +91 00000 00000</span>
      <span class="btn btn-outline btn-sm"><i class="bi bi-envelope" aria-hidden="true"></i> name@example.com</span>
    </div>

    <div class="resume-body">
      <h2>About me</h2>
      <p>Detail-oriented accounts professional with 5 years of experience in billing, GST and financial reporting, looking for a senior role in a growing company.</p>

      <h2>Skills</h2>
      <div class="chips"><?php foreach ($skills as $skill): ?><span class="chip"><?= e($skill) ?></span><?php endforeach; ?></div>

      <h2>Experience</h2>
      <?php foreach ($experience as [$role, $where, $when, $what]): ?>
        <div class="job"><strong><?= e($role) ?></strong><small><?= e($where) ?> · <?= e($when) ?></small><p><?= e($what) ?></p></div>
      <?php endforeach; ?>

      <h2>Education</h2>
      <?php foreach ($education as [$degree, $where, $year]): ?>
        <div class="job"><strong><?= e($degree) ?></strong><small><?= e($where) ?> · <?= e($year) ?></small></div>
      <?php endforeach; ?>

      <h2>Achievements</h2>
      <ul class="check-list mb-0"><?php foreach ($achievements as $item): ?><li><?= e($item) ?></li><?php endforeach; ?></ul>

      <h2>Languages</h2>
      <p class="mb-0"><?= e(implode(', ', $languages)) ?></p>
    </div>
  </div>
  <p class="resume-foot">Sample resume website by <a href="<?= e(url('services/resume-website')) ?>">AshaParth AI</a></p>
</main>
</body>
</html>

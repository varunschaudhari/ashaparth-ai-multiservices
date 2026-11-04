<?php
defined('APP_ROOT') || exit;
$delays = ['', 'reveal-d1', 'reveal-d2', 'reveal-d3'];
partial('page-hero', [
    'title'   => 'Careers at AshaParth AI',
    'text'    => 'We are always looking for talented, curious people who love technology, creativity and making a real difference for clients.',
    'crumbs'  => [['Careers', 'careers']],
    'eyebrow' => 'Join our team',
    'icon'    => 'briefcase',
    'actions' => '<a class="btn btn-primary" href="#apply">' . icon('file-earmark-arrow-up') . ' Send Your Resume</a>',
]);
?>

<section class="section">
  <div class="container">
    <div class="section-head center">
      <span class="eyebrow">Why work with us</span>
      <h2>Grow your career while building things that matter</h2>
    </div>
    <div class="grid grid-4">
      <?php foreach ([
          ['rocket-takeoff', 'Real projects', 'Work on live websites, apps, AI solutions and campaigns from day one.'],
          ['mortarboard', 'Learn & grow', 'Learn modern tools including AI, cloud and the latest frameworks, with mentoring from the founders.'],
          ['people', 'Friendly team', 'A supportive, respectful workplace where every idea is heard.'],
          ['bank', 'Meaningful work', 'Help businesses grow and connect temples with devotees around the world.'],
      ] as $k => [$ic, $t, $d]): ?>
        <div class="card feature-card card-hover reveal <?= $delays[$k] ?>">
          <div class="icon-box<?= $k % 2 ? ' maroon' : '' ?>"><?= icon($ic) ?></div>
          <h3><?= e($t) ?></h3>
          <p><?= e($d) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="section section-soft" id="apply">
  <div class="container split split-top">
    <div class="reveal">
      <span class="eyebrow">General application</span>
      <h2>Don’t see a listed role? Apply anyway.</h2>
      <p class="lead">We do not have specific openings listed right now, but we regularly hire for the roles below. Send us your resume and we will contact you when there is a suitable opportunity.</p>
      <ul class="check-list" style="margin-top:22px">
        <?php foreach (array_slice(career_positions(), 0, -2) as $role): ?><li><?= e($role) ?></li><?php endforeach; ?>
        <li>Internships for students and freshers</li>
      </ul>
      <p style="margin-top:22px;font-size:.93rem">You can also email your resume to <a href="<?= e(mailto_url()) ?>"><strong><?= e(config('email')) ?></strong></a>.</p>
    </div>

    <div class="form-card reveal reveal-d2">
      <h2>Send your application</h2>
      <p class="form-intro">Fields marked <span style="color:var(--danger)">*</span> are required.</p>
      <?php partial('form-alert'); ?>
      <form method="post" action="<?= e(url('careers')) ?>#apply" enctype="multipart/form-data" data-enhance>
        <?= form_guard_fields() ?>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?= (int) config('forms.max_upload_mb', 5) * 1048576 ?>">
        <div class="form-grid">
          <?= input_field('name', 'Full name', ['required' => true, 'autocomplete' => 'name']) ?>
          <?= input_field('email', 'Email', ['type' => 'email', 'required' => true, 'autocomplete' => 'email']) ?>
          <?= input_field('phone', 'Phone', ['type' => 'tel', 'required' => true, 'autocomplete' => 'tel', 'placeholder' => '+91', 'maxlength' => 20]) ?>
          <?= input_field('city', 'Current city', ['required' => true, 'autocomplete' => 'address-level2']) ?>
          <?= select_field('position', 'Position interested in', career_positions(), ['required' => true]) ?>
          <?= select_field('experience', 'Experience', experience_options(), ['required' => true]) ?>
          <?= input_field('portfolio_url', 'Portfolio / LinkedIn / GitHub', ['type' => 'url', 'full' => true, 'hint' => '(optional)', 'placeholder' => 'https://', 'maxlength' => 255]) ?>
          <?= textarea_field('cover_note', 'Tell us about yourself', ['rows' => 4, 'hint' => '(optional)', 'placeholder' => 'Your skills, projects you are proud of, and why you would like to join us.']) ?>
          <?= file_field('resume', 'Resume / CV', '.pdf,.doc,.docx', 'PDF, DOC or DOCX', ['required' => true]) ?>
        </div>
        <div class="form-footer">
          <p class="form-privacy"><?= icon('shield-lock-fill') ?> Your resume is used only for recruitment. See our <a href="<?= e(url('privacy-policy')) ?>">privacy policy</a>.</p>
          <button class="btn btn-primary btn-lg" type="submit"><?= icon('send') ?> Submit Application</button>
        </div>
      </form>
    </div>
  </div>
</section>

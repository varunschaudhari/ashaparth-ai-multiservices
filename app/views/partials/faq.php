<?php
/** FAQ accordion + FAQPage schema. Vars: $items = [[question, answer], ...] */
defined('APP_ROOT') || exit;
$faqSchema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn ($f) => [
        '@type'          => 'Question',
        'name'           => $f[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]],
    ], $items),
];
?>
<div class="faq">
  <?php foreach ($items as $i => [$q, $a]): ?>
    <details class="reveal"<?= $i === 0 ? ' open' : '' ?>>
      <summary><?= e($q) ?></summary>
      <div class="faq-answer"><p><?= e($a) ?></p></div>
    </details>
  <?php endforeach; ?>
</div>
<script type="application/ld+json"><?= json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>

<?php
/** Form-level error summary shown at the top of a form after a failed submit. */
defined('APP_ROOT') || exit;

if (!form_has_errors()) {
    return;
}
$general = form_error_message();
$count   = count(array_diff_key($GLOBALS['__form_errors'], ['_form' => 1]));
?>
<div class="alert alert-error" role="alert" id="form-alert" tabindex="-1">
  <?= icon('exclamation-circle-fill') ?>
  <div>
    <?php if ($general): ?>
      <?= e($general) ?>
    <?php else: ?>
      Please correct the <?= $count === 1 ? 'highlighted field' : $count . ' highlighted fields' ?> below and submit again.
    <?php endif; ?>
  </div>
</div>
<script>document.addEventListener('DOMContentLoaded',function(){var a=document.getElementById('form-alert');if(a){a.scrollIntoView({block:'center'});a.focus({preventScroll:true});}});</script>

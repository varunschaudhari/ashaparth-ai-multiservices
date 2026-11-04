<?php
/**
 * Form field renderers. Each returns HTML with the label, old value,
 * validation error and accessibility attributes wired up.
 *
 * Common options ($o): required (bool), full (bool, spans both columns),
 * placeholder, hint, autocomplete, maxlength
 */

defined('APP_ROOT') || exit;

function field_open(string $name, string $label, array $o, string $for = ''): string
{
    $req  = !empty($o['required']) ? ' <span class="req" aria-hidden="true">*</span>' : '';
    $hint = !empty($o['hint']) ? ' <span class="hint">' . e($o['hint']) . '</span>' : '';
    $for  = $for !== '' ? ' for="' . e($for) . '"' : '';
    $tag  = $for !== '' ? 'label' : 'span';
    return '<div class="field' . (!empty($o['full']) ? ' full' : '') . '">'
        . '<' . $tag . ' class="label"' . $for . '>' . e($label) . $req . $hint . '</' . $tag . '>';
}

function input_field(string $name, string $label, array $o = []): string
{
    $id   = 'f-' . $name;
    $type = $o['type'] ?? 'text';
    $attrs = ' type="' . e($type) . '" id="' . e($id) . '" name="' . e($name) . '" value="' . e(old($name)) . '"';
    $attrs .= !empty($o['required']) ? ' required' : '';
    $attrs .= isset($o['placeholder']) ? ' placeholder="' . e($o['placeholder']) . '"' : '';
    $attrs .= isset($o['autocomplete']) ? ' autocomplete="' . e($o['autocomplete']) . '"' : '';
    $attrs .= ' maxlength="' . (int) ($o['maxlength'] ?? 150) . '"';
    if ($type === 'tel') {
        $attrs .= ' inputmode="tel"';
    }
    return field_open($name, $label, $o, $id) . '<input' . $attrs . field_attrs($name) . '>' . field_error($name) . '</div>';
}

function textarea_field(string $name, string $label, array $o = []): string
{
    $id    = 'f-' . $name;
    $attrs = ' id="' . e($id) . '" name="' . e($name) . '" rows="' . (int) ($o['rows'] ?? 5) . '"';
    $attrs .= !empty($o['required']) ? ' required' : '';
    $attrs .= isset($o['placeholder']) ? ' placeholder="' . e($o['placeholder']) . '"' : '';
    $attrs .= ' maxlength="' . (int) ($o['maxlength'] ?? 3000) . '"';
    $o['full'] = $o['full'] ?? true;
    return field_open($name, $label, $o, $id) . '<textarea' . $attrs . field_attrs($name) . '>' . e(old($name)) . '</textarea>' . field_error($name) . '</div>';
}

/** $options: flat list, or ['Group label' => [..], ...] for <optgroup>s. */
function select_field(string $name, string $label, array $options, array $o = []): string
{
    $id      = 'f-' . $name;
    $current = old($name, $o['default'] ?? '');
    $html    = '<option value="">' . e($o['placeholder'] ?? 'Select…') . '</option>';

    $renderOpts = function (array $list) use ($current): string {
        $out = '';
        foreach ($list as $opt) {
            $out .= '<option value="' . e($opt) . '"' . ($current === $opt ? ' selected' : '') . '>' . e($opt) . '</option>';
        }
        return $out;
    };

    $grouped = is_string(array_key_first($options));
    if ($grouped) {
        foreach ($options as $group => $list) {
            $html .= '<optgroup label="' . e($group) . '">' . $renderOpts($list) . '</optgroup>';
        }
    } else {
        $html .= $renderOpts($options);
    }

    $attrs = ' id="' . e($id) . '" name="' . e($name) . '"' . (!empty($o['required']) ? ' required' : '');
    return field_open($name, $label, $o, $id) . '<select' . $attrs . field_attrs($name) . '>' . $html . '</select>' . field_error($name) . '</div>';
}

function checkbox_group(string $name, string $label, array $options, array $o = []): string
{
    $o['full'] = $o['full'] ?? true;
    $preset    = $o['checked'] ?? [];
    $hasOld    = isset($GLOBALS['__form_old'][$name]);
    $html      = '<div class="check-grid" role="group" aria-label="' . e($label) . '"' . (!empty($o['required']) ? ' data-required-group' : '') . '>';
    foreach ($options as $opt) {
        $checked = $hasOld ? old_has($name, $opt) : in_array($opt, $preset, true);
        $html .= '<label class="check-option"><input type="checkbox" name="' . e($name) . '[]" value="' . e($opt) . '"' . ($checked ? ' checked' : '') . '> ' . e($opt) . '</label>';
    }
    $html .= '</div>';
    $html .= '<p class="field-error group-msg" hidden>Please select at least one option.</p>';
    return field_open($name, $label, $o) . $html . field_error($name) . '</div>';
}

function radio_group(string $name, string $label, array $options, array $o = []): string
{
    $current = old($name, $o['default'] ?? '');
    $html    = '<div class="radio-row" role="radiogroup" aria-label="' . e($label) . '">';
    foreach ($options as $opt) {
        $html .= '<label class="check-option"><input type="radio" name="' . e($name) . '" value="' . e($opt) . '"' . ($current === $opt ? ' checked' : '') . '> ' . e($opt) . '</label>';
    }
    $html .= '</div>';
    return field_open($name, $label, $o) . $html . field_error($name) . '</div>';
}

function file_field(string $name, string $label, string $accept, string $hint, array $o = []): string
{
    $o['full'] = $o['full'] ?? true;
    $id        = 'f-' . $name;
    $default   = !empty($o['required']) ? 'Choose a file to upload' : 'Choose a file (optional)';
    $maxMb     = (int) config('forms.max_upload_mb', 5);
    return field_open($name, $label, $o, $id)
        . '<div class="file-drop">' . icon('cloud-arrow-up') . '<div><strong data-file-label data-default="' . e($default) . '">' . e($default) . '</strong>'
        . '<small>' . e($hint) . ' · Max ' . $maxMb . ' MB</small></div>'
        . '<input type="file" id="' . e($id) . '" name="' . e($name) . '" accept="' . e($accept) . '"' . (!empty($o['required']) ? ' required' : '') . field_attrs($name) . '>'
        . '</div>' . field_error($name) . '</div>';
}

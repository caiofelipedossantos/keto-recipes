<?php
switch ($type) {
    case 'text':
    default:
        echo '<input type="text" id="' . esc_attr($id) . '" name="' . esc_attr($name . '[' . $id . ']') . '" value="' . esc_attr($value) . '" />';
        break;
    case 'checkbox':
        echo '<label for="' . esc_attr($label_for) . '">
                <input type="checkbox" id="' . esc_attr($id) . '" name="' . esc_attr($name . '[' . $id . ']') . '" value="' . esc_attr($value) . '" ' . $checked . '>
                ' . esc_html($description) . '
            </label>';
        break;
    case 'number':
        echo '<input type="number" id="' . esc_attr($id) . '" name="' . esc_attr($name . '[' . $id . ']') . '" value="' . esc_attr($value) . '" min="' . esc_attr($min) . '" max="' . esc_attr($max) . '" />';
        break;
}

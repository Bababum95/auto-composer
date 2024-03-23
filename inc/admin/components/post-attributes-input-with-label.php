<?php

/**
 * Generate an input field with a post attributes label.
 *
 * @param string $label The label text.
 * @param string $name The input name attribute.
 * @param string $value The input value attribute.
 * @return string The generated input field HTML.
 */
function post_attributes_input_with_label($label, $name, $value) {
    return sprintf(
        '%s
        <input type="text" id="%s" name="%s" value="%s" />',
        post_attributes_label($label, $name),
        esc_attr($name),
        esc_attr($name),
        esc_attr($value)
    );
}

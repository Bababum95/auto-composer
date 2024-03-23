<?php

/**
 * Generate a post attributes label.
 *
 * @param string $label The label text.
 * @param string $for The "for" attribute value.
 * @return string The generated label HTML.
 */
function post_attributes_label($label, $for) {
    return sprintf(
        '<p class="post-attributes-label-wrapper">
            <label class="post-attributes-label" for="%s">%s</label>
        </p>',
        esc_attr($for),
        esc_html($label)
    );
}

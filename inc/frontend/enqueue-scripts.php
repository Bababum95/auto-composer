<?php

// $script_handles = array();


// function add_module_type_attribute($tag, $handle, $src) {
//     global $script_handles;

//     foreach ($script_handles as $script_handle) {
//         if (strpos($handle, $script_handle) !== false) {
//             return '<script type="module" src="' . esc_url($src) . '"></script>';
//         }
//     }

//     return $tag;
// }
// add_filter('script_loader_tag', 'add_module_type_attribute', 10, 3);

/**
 * Function to automatically enqueue scripts.
 */
function auto_enqueue_scripts() {
    enqueue_custom_asset('frontend/styles.scss');

    if(is_archive()) {
        enqueue_custom_asset('frontend/archive-questions/archive-questions.scss');
    }
}

add_action('wp_enqueue_scripts', 'auto_enqueue_scripts');

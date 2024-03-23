<?php

/**
 * Enqueues a custom asset file in the WordPress theme.
 *
 * @param string $file_path The path to the asset file.
 * @param array $dependencies An array of dependencies for the asset file.
 */
function enqueue_custom_asset($file_path, $dependencies = array()) {
    $manifest_path = get_template_directory() . '/dist/manifest.json';
    $manifest_data = json_decode(file_get_contents($manifest_path), true);
    $file_path = 'src/' . $file_path;

    $file_name = pathinfo($file_path, PATHINFO_FILENAME);
    $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);

    if (isset($manifest_data[$file_path])) {
        $asset_file = $manifest_data[$file_path]['file'];

        if ($file_extension === 'scss') {
            $function_name = 'wp_enqueue_style';
            $url = get_template_directory_uri() . '/dist/' . $asset_file;
        } elseif ($file_extension === 'ts') {
            $function_name = 'wp_enqueue_script';
            $url = get_template_directory_uri() . '/dist/' . $asset_file;
        } else {
            return;
        }

        $handle = sanitize_title($file_name, str_replace('.', '', $file_name));
        $version = isset($manifest_data[$file_path]['version']) ? $manifest_data[$file_path]['version'] : null;

        // $options = ($file_extension === 'ts') ? array('type' => 'module') : array();

        $function_name($handle, $url, $dependencies, $version);
    }
}

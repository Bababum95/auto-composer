<?php

/**
 * Register a custom post type.
 *
 * @param string $post_type The name of the post type.
 * @param array $args Optional arguments for the post type.
 * @return void
 */

function theory_exam_questions_post_type() {
    $labels = array(
        'name'                  => _x('Fragen Theorie Prüfung', 'Post Type General Name', 'auto'),
        'singular_name'         => _x('Fragen Theorie Prüfung', 'Post Type Singular Name', 'auto'),
        'menu_name'             => __('Fragen Theorie Prüfung', 'auto'),
        'name_admin_bar'        => __('Fragen Theorie Prüfung', 'auto'),
        'archives'              => __('Item Archives', 'auto'),
        'parent_item_colon'     => __('Parent Item:', 'auto'),
        'all_items'             => __('All Items', 'auto'),
        'add_new_item'          => __('Add New Item', 'auto'),
        'add_new'               => __('Add New Fragen Theorie Prüfung', 'auto'),
        'new_item'              => __('New Item', 'auto'),
        'edit_item'             => __('Edit Item', 'auto'),
        'update_item'           => __('Update Item', 'auto'),
        'view_item'             => __('View Item', 'auto'),
        'view_items'            => __('View Items', 'auto'),
        'search_items'          => __('Search Item', 'auto'),
        'not_found'             => __('Not found', 'auto'),
        'not_found_in_trash'    => __('Not found in Trash', 'auto'),
        'remove_featured_image' => __('Remove featured image', 'auto'),
        'use_featured_image'    => __('Use as featured image', 'auto'),
        'insert_into_item'      => __('Insert into item', 'auto'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'auto'),
        'items_list'            => __('Items list', 'auto'),
        'items_list_navigation' => __('Items list navigation', 'auto'),
        'filter_items_list'     => __('Filter items list', 'auto'),
    );

    $args = array(
        'label'                 => __('Fragen Theorie Prüfung', 'auto'),
        'description'           => __('Fragen Theorie Prüfung', 'auto'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail'),
        'taxonomies'            => array('category'),
        'hierarchical'          => true,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 66,
        'menu_icon'             => 'dashicons-car',
        'show_in_admin_bar'     => false,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        // 'show_in_rest'          => true,
        'has_archive'           => true,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        // 'capability_type'       => 'page',
        // 'rewrite'               => false,
    );

    register_post_type('theory-exam-question', $args);
}

add_action('init', 'theory_exam_questions_post_type', 0);

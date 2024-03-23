<?php

/* actions */
add_action('created_category',  'custom_base_refresh_rules');
add_action('delete_category',   'custom_base_refresh_rules');
add_action('edited_category',   'custom_base_refresh_rules');
add_action('init',              'custom_category_base_permastruct');

/* filters */
add_filter('category_rewrite_rules', 'custom_base_rewrite_rules');
add_filter('query_vars',             'custom_base_query_vars');
add_filter('request',                'custom_base_request');
add_filter('category_link',          'custom_category_link', 10, 2 );


function custom_base_refresh_rules() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}

/**
 * Removes category base.
 *
 * @return void
 */
function custom_category_base_permastruct() {
	global $wp_rewrite;
	global $wp_version;

	if ( $wp_version >= 3.4 ) {
		$wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
	} else {
		$wp_rewrite->extra_permastructs['category'][0] = '%category%';
	}
}

/**
 * Adds our custom category rewrite rules.
 *
 * @param  array $category_rewrite Category rewrite rules.
 *
 * @return array
 */
function custom_base_rewrite_rules($category_rewrite) {
	global $wp_rewrite;
	$category_rewrite=array();

	/* WPML is present: temporary disable terms_clauses filter to get all categories for rewrite */
	if ( class_exists( 'Sitepress' ) ) {
		global $sitepress;

		remove_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
		$categories = get_categories( array( 'hide_empty' => false ) );
		add_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ), 10, 4 );
	} else {
		$categories = get_categories( array( 'hide_empty' => false ) );
	}

	foreach( $categories as $category ) {
		$category_nicename = $category->slug;
		if ( $category->parent == $category->cat_ID ) {
			$category->parent = 0;
		} elseif ( $category->parent != 0 ) {
			// $category_nicename = get_category_parents( $category->parent, false, '/', true ) . $category_nicename;
		}

		$category_rewrite['('.$category_nicename.')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
		$category_rewrite["({$category_nicename})/{$wp_rewrite->pagination_base}/?([0-9]{1,})/?$"] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
		$category_rewrite['('.$category_nicename.')/?$'] = 'index.php?category_name=$matches[1]';
	}

	$old_category_base = get_option( 'category_base' ) ? get_option( 'category_base' ) : 'category';
	$old_category_base = trim( $old_category_base, '/' );
	$category_rewrite[$old_category_base.'/(.*)$'] = 'index.php?category_redirect=$matches[1]';

	return $category_rewrite;
}


function custom_base_query_vars($public_query_vars) {
	$public_query_vars[] = 'category_redirect';
	return $public_query_vars;
}

/**
 * Handles category redirects.
 *
 * @param $query_vars Current query vars.
 *
 * @return array $query_vars, or void if category_redirect is present.
 */
function custom_base_request($query_vars) {
	if( isset( $query_vars['category_redirect'] ) ) {
		$catlink = trailingslashit( get_option( 'home' ) ) . user_trailingslashit( $query_vars['category_redirect'], 'category' );
		status_header( 301 );
		header( "Location: $catlink" );
		exit();
	}

	return $query_vars;
}


// /**
//  * Generates a category link based on the given category ID.
//  *
//  * @param string $catlink The category link to be generated or modified.
//  * @param int $category_id The ID of the category.
//  * @return string The generated category link.
//  */
function custom_category_link( $catlink, $category_id ) {
    $category = get_category( $category_id );
    $category_nicename = $category->slug;

    $catlink = home_url( user_trailingslashit( $category_nicename, 'category' ) );
    return $catlink;
}


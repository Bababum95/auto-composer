<?php
/**
 *  Render the post content.
 */
$current_category_id = get_query_var('cat');
$args = array(
    'post_type'      => 'theory-exam-question',
    'posts_per_page' => -1,
    'cat'            => $current_category_id,
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    // Sort the posts by question number
    $posts = $query->get_posts();
    usort($posts, 'compare_question_numbers');

    echo '<div ' . get_block_wrapper_attributes() . '>';
    foreach ($posts as $post) {
        $id = $post->ID;
        $has_post = get_post_meta($post->ID, '_has_post', true);
        if( $has_post && $has_post !== 'false' ) {
            get_template_part(
                'template-parts/questions/post-summary',
                null,
                array(
                    'id'    => $id,
                    'title' => '<h2 class="question__title">' . get_the_title( $id ) . '</h2>',
                )
            );
        } else {
            get_template_part(
                'template-parts/questions/post-content',
                null,
                array(
                    'id'    => $id,
                    'title' => '<h2 class="question__title">' . get_the_title( $id ) . '</h2>',
                )
            );
        }
    }
    
    echo '</div>';
    wp_reset_postdata();
}

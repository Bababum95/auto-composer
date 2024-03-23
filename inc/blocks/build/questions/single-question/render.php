<?php
/**
 *  Render the post content.
 */

 $id = $attributes['id'];

if (!empty($id)) {
    echo '<div ' . get_block_wrapper_attributes() . '>';
    get_template_part(
        'template-parts/questions/post-content',
        null,
        array(
            'id'    => $id,
            'title' => '<h1 class="question__title">' . get_the_title( $id ) . '</h1>',
        )
    );
    echo '</div>';
}


<?php

/**
 * Compare function for sorting posts based on question numbers.
 *
 * This function retrieves the question numbers for two posts and
 * compares them using version_compare for proper numerical sorting.
 *
 * @param WP_Post|int $a Post object or Post ID for the first post.
 * @param WP_Post|int $b Post object or Post ID for the second post.
 * @return int Returns a negative value if $a is less than $b,
 *             zero if they are equal, and a positive value if $a is greater than $b.
 */
function compare_question_numbers($a, $b) {
    $question_number_a = is_a($a, 'WP_Post')
        ? get_post_meta($a->ID, '_question_number', true)
        : get_post_meta($a, '_question_number', true);
    $question_number_b = is_a($b, 'WP_Post')
        ? get_post_meta($b->ID, '_question_number', true)
        : get_post_meta($b, '_question_number', true);

    return version_compare($question_number_a, $question_number_b);
}

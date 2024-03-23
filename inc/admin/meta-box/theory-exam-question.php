<?php

class TheoryExamQuestion {
    /**
     * Constructor for setting up the actions for adding meta boxes and saving post questions.
     */
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_questions_meta_boxes'));
        add_action('save_post', array($this, 'save_questions_meta'));
    }

    /**
     * Add meta boxes for theory-exam-question.
     */
    public function add_questions_meta_boxes() {
        add_meta_box(
            'question_numb_meta_box',
            'Frage Nummer',
            array($this, 'display_question_number_meta_box'),
            'theory-exam-question',
            'side',
            'high'
        );

        add_meta_box(
            'additional_info_meta_box',
            'Zusätzliche Informationen',
            array($this, 'display_additional_info_meta_box'),
            'theory-exam-question',
            'normal',
            'high'
        );

        add_meta_box(
            'answers_meta_box',
            'Antworten',
            array($this, 'display_answers_meta_box'),
            'theory-exam-question',
            'normal',
            'high'
        );

        $this->enqueue_styles();
    }

    /**
     * Enqueue styles for the PHP function.
     */
    private function enqueue_styles() {
        enqueue_custom_asset('admin/meta-box/theory-exam-question.scss');
        enqueue_custom_asset('admin/meta-box/theory-exam-question.ts', array('wp-i18n'));
    }


    /**
     * Display question number meta box
     *
     * @param WP_Post $post The post object.
     */
    public function display_question_number_meta_box($post) {
        $question_number = get_post_meta($post->ID, '_question_number', true);
        echo post_attributes_input_with_label(__('Frage Nummer', 'auto'), 'question_number', $question_number);
    }

    /**
     * Display additional information meta box.
     *
     * @param WP_Post $post The post object.
     */
    public function display_additional_info_meta_box($post) {
        $penalty_points = get_post_meta($post->ID, '_penalty_points', true);
        $has_post = get_post_meta($post->ID, '_has_post', true);
        $post_link = get_post_meta($post->ID, '_post_link', true);
        $hint = get_post_meta($post->ID, '_hint', true);
        $test_field = get_post_meta($post->ID, '_test_field', true);

        echo '<div class="additional-info"><div class="additional-info__wrapper">';
        // Post link
        echo post_attributes_input_with_label(__('Beitragslink', 'auto'), 'post_link', $post_link);
        // Hint
        echo post_attributes_input_with_label(__('Hinweis', 'auto'), 'hint', $hint);

        echo '</div><div>';
        // Checkbox
        printf(
            '<label class="additional-info__checkbox">
                <input type="checkbox" id="has_post" name="has_post" value="1" %s />
                %s?
            </label>',
            checked($has_post, 1, false),
            __('Ist der Beitrag existiert', 'auto'),
        );

        // Dropdown with numbers
        echo post_attributes_label(__('Nummer auswählen', 'auto'), 'penalty_points');
        echo '<select class="additional-info__dropdown" id="penalty_points" name="penalty_points">';
        for ($i = 1; $i <= 10; $i++) {
            echo '<option value="' . $i . '" ' . selected($penalty_points, $i, false) . '>' . $i . '</option>';
        }
        echo '</select>';
    
        echo '</div></div>';

        // Test field
        printf(
            '%s
            <textarea class="additional-info__textarea" rows="4" id="test_field" name="test_field">%s</textarea>',
            post_attributes_label(__('Testfeld', 'auto'), 'test_field'),
            esc_attr($test_field)
        );
    }

    private function get_answer($index, $answer) {
        return sprintf(
            '<div class="answer">
                <h4 class="answer__title">Antwort %d</h4>
                <div class="answer__content">
                    <div class="answer__text">%s</div>
                    <label class="answer__correct">
                        <input type="checkbox" id="answer_correct_%d" name="answers[%d][correct]" value="1" %s />
                        %s?
                    </label>
                </div>
                %s
                <textarea class="answer__comment" rows="4" id="answer_comment_%d" name="answers[%d][comment]">%s</textarea>
            </div>',
            $index + 1,
            post_attributes_input_with_label(__('Text', 'auto'), 'answers[' . $index .'][text]', $answer['text']),
            $index,
            $index,
            checked($answer['correct'], 1, false),
            __('Korrekt', 'auto'),
            post_attributes_label(__('Kommentar', 'auto'), 'answer_comment_' . $index),
            $index,
            $index,
            esc_textarea($answer['comment'])
        );
    }

    public function display_answers_meta_box($post) {
        $answers = get_post_meta($post->ID, '_answers', true);
        $answers = is_array($answers) ? $answers : array();
        if (empty($answers)) {
            $answers[] = array('text' => '', 'comment' => '', 'correct' => 0);
        }
    
        foreach ($answers as $index => $answer) {
            echo $this->get_answer($index, $answer);
        }
    
        printf('
            <button type="button" class="button" id="add_answer">%s</button>',
            esc_html__('Antwort hinzufügen', 'auto')
        );
    }

    /**
     * Save the questions meta data for a given post.
     *
     * @param int $post_id The ID of the post to save the meta data for.
     */
    public function save_questions_meta($post_id) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        // Save question number
        if (isset($_POST['question_number'])) {
            update_post_meta($post_id, '_question_number', sanitize_text_field($_POST['question_number']));
        }

        // Save additional fields
        $penalty_points = isset($_POST['penalty_points']) ? sanitize_text_field($_POST['penalty_points']) : '';
        $has_post = isset($_POST['has_post']) ? 1 : 0;
        $post_link = isset($_POST['post_link']) ? esc_url($_POST['post_link']) : '';
        $hint = isset($_POST['hint']) ? sanitize_text_field($_POST['hint']) : '';
        $test_field = isset($_POST['test_field']) ? sanitize_text_field($_POST['test_field']) : '';

        update_post_meta($post_id, '_penalty_points', $penalty_points);
        update_post_meta($post_id, '_has_post', $has_post);
        update_post_meta($post_id, '_post_link', $post_link);
        update_post_meta($post_id, '_hint', $hint);
        update_post_meta($post_id, '_test_field', $test_field);

        // Save answers
        if (isset($_POST['answers']) && is_array($_POST['answers'])) {
            $answers = array_map(function ($answer) {
                return array(
                    'text' => sanitize_text_field($answer['text']),
                    'comment' => sanitize_text_field($answer['comment']),
                    'correct' => isset($answer['correct']) ? 1 : 0,
                );
            }, $_POST['answers']);
    
            update_post_meta($post_id, '_answers', $answers);
        }
    }
}



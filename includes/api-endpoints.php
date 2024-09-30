<?php 

/**
 * Retrieves all original strings stored.
 *
 * @return array List of original strings.
 */
function tta_get_original_texts() {
    $strings = [];
    $args = [
        'post_type' => 'translations',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ];

    $query = new WP_Query($args);
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $strings[] = get_the_title();
        }
        wp_reset_postdata();
    }

    return $strings;
}

/**
 * Retrieves translations for the requested language.
 *
 * @param WP_REST_Request $request The request object.
 * @return WP_REST_Response The response with success or error.
 */
function tta_get_translations_for_language($request) {
    $lang_code = $request['lang'];
    $texts = tta_get_original_texts();
    $translated = tta_translate_strings($texts, $lang_code);
    
    if (is_wp_error($translated)) {
        return new WP_REST_Response([
            'success' => false,
            'error' => 'Translation failed',
            'error_message' => $translated->get_error_message()
        ], 500);
    }

    return new WP_REST_Response([
        'success' => true,
        'data' => [
            'language' => [
                'code' => $lang_code,
                'name' => tta_get_available_languages()[$lang_code]
            ],
            'original' => $texts,
            'translated' => $translated
        ]
    ], 200);
}

/**
 * Returns an array of available languages for translation.
 *
 * @return array List of languages and their names.
 */
function tta_get_available_languages() {
    return [
        'br' => 'Brazilian Portuguese',
        'nl' => 'Dutch',
        'fr' => 'French',
        'de' => 'German',
        'it' => 'Italian',
        'ja' => 'Japanese',
        'pl' => 'Polish',
        'pt' => 'Portuguese',
        'es' => 'Spanish',
        'ru' => 'Russian'
    ];
}

/**
 * Registers the REST API route for translations.
 */
add_action('rest_api_init', function() {
    // Get all original translations
    register_rest_route('tta-plugin/v1', '/translate/', array(
        'methods' => 'GET',
        'callback' => 'tta_get_and_translate_texts',
        'permission_callback' => '__return_true',
    ));

    register_rest_route('tta-plugin/v1', '/translate/(?P<lang>[a-z]{2})', [
        'methods' => 'GET',
        'callback' => 'tta_get_translations_for_language',
        'args' => [
            'lang' => [
                'validate_callback' => function($param) {
                    return array_key_exists($param, tta_get_available_languages());
                }
            ],
        ],
        'permission_callback' => '__return_true',
    ]);
});

/**
 * Retrieves all English text strings to be translated.
 *
 * @return WP_REST_Response The response with success or error.
 */
function tta_get_and_translate_texts() {
    if (!function_exists('get_userdata') || !function_exists('wp_get_current_user')) {
        return new WP_REST_Response([
            'success' => false, 
            'error' => 'WordPress functions not available'
        ], 500);
    }

    $strings = tta_get_original_texts();
    
    return new WP_REST_Response([
        'success' => true, 
        'data' => [
            'original_strings' => $strings
        ]
    ], 200);
}

<?php 

/**
 * Registers a custom post type for translatable strings.
 *
 * This function creates a post type called "translations" which allows 
 * users to add and manage translatable strings in the WordPress admin.
 */
function tm_register_translations_post_type() {
    $labels = array(
        'name' => 'Translatable Strings',
        'singular_name' => 'Translatable String',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'menu_icon' => 'dashicons-translation',
        'supports' => array('title', 'editor'),
    );

    register_post_type('translations', $args);
}
add_action('init', 'tm_register_translations_post_type');

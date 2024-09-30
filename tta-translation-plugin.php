<?php
/**
 * Plugin Name: TTA Translation API
 * Description: Provides an API endpoint for translating strings using Weglot API
 * Version: 1.0
 * Author: Thomas De Grava
 */

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/custom-post-type.php';
require_once plugin_dir_path(__FILE__) . 'includes/connection-api.php';
require_once plugin_dir_path(__FILE__) . 'includes/api-endpoints.php';

function tta_enqueue_scripts() {
    // Enqueue Weglot script
    wp_enqueue_script('tta-plugin-script', 'https://cdn.weglot.com/weglot.min.js', array(), '1.0', true);
    
    // Add script on footer
    add_action('wp_footer', 'tta_add_weglot_script');
}

function tta_add_weglot_script() {
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof Weglot !== 'undefined') {
                Weglot.initialize({
                    api_key: 'wg_2fb37d56bdb5d97307b6a1d9bc1b53b45'
                });
            } else {
                console.error('Weglot is not defined');
            }
        });
    </script>
    <?php
}
add_action('wp_enqueue_scripts', 'tta_enqueue_scripts');

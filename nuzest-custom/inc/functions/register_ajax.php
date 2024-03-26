<?php

// Add AJAX support
function register_ajax()
{
    wp_localize_script('theme_js', 'theme_js_vars', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'register_ajax');

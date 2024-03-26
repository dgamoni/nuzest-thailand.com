<?php

function get_faq_search($atts) {
	
    extract(shortcode_atts(
        array(
            'search_placeholder' => ''
        ), $atts));

    $return = '<div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4 search-box">'
        . '<div class="field-icon">'
        . '<input maxlength="150" type="text" class="txt" placeholder="' . $search_placeholder . '">'
        . '<button id="searchsubmit" class="btn"><span class="glyphicon glyphicon-search"></span></button>'
        . '</div>'
        . '</div>';
	
	wp_enqueue_script('bootstrap_typeahead_js', get_template_directory_uri() . '/js/bootstrap.typeahead.min.js', array('jquery'), '', true);
    wp_enqueue_script('faq_search', get_template_directory_uri() . '/js/faq_search.js', array(), '3.7.3');

    return $return;

}

add_shortcode('faq_search', 'get_faq_search');

function faq_search_vc() {
    vc_map(
        array(
            'name' => __('FAQ Search', 'custom_elements'),
            'base' => 'faq_search',
            'description' => __('FAQ search box', 'custom_elements'),
            'category' => 'Nuzest Custom',
            'icon' => 'faq-search-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "textfield",
                    "admin_label" => true,
                    "class" => "hideContent",
                    "heading" => __("Place Holder", 'custom_elements'),
                    "param_name" => "search_placeholder",
                    "value" => "",
                    'holder' => 'div'
                ),
            )
        )
    );
}

add_action('vc_before_init', 'faq_search_vc');

add_action('wp_ajax_ajax_get_faqs', 'ajax_get_faqs');
add_action('wp_ajax_nopriv_ajax_get_faqs', 'ajax_get_faqs');

function ajax_get_faqs() {

    $args = array(
        'post_type' => 'faqs',
        'post_status' => 'publish',
        'posts_per_page' => -1
    );
    $wp_query = get_posts($args);

    $result = array();
    if (count($wp_query)) {
        foreach ($wp_query as $post) {
            $result[] = array(
                'id' => $post->ID,
                'title' => $post->post_title
            );
        }
    }

    wp_send_json($result);
    die();
}

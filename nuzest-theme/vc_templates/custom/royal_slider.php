<?php

/* 
 * Custom shortcode to place a Royal Slider 
 */

function royal_slider_shortcode($atts) {
    $royal_slider_item = false;
    extract(
        $attributes = shortcode_atts(
            array(
                'royal_slider_item' => '',
            ), $atts
        )
    );
    $html = do_shortcode( '[new_royalslider id="'.$royal_slider_item.'"]' );
    return $html;
}
add_shortcode("royal_slider_custom", "royal_slider_shortcode");

function royal_slider_shortcode_vc() {
    // Stop all if VC is not enabled
    if ( !defined( 'WPB_VC_VERSION' ) ) {
        return;
    }

    $pageList = [__('Select') => ''];

    global $wpdb;

    $qstr = "SELECT id, name FROM ".$wpdb->prefix."new_royalsliders WHERE active=1";

    $res = $wpdb->get_results( $qstr , ARRAY_A );

    if( is_array($res) ) {
        foreach ($res as $key => $slider_data) {
            $title = "{$slider_data['name']}";
            $pageList[$title] = (integer)$slider_data['id'];
        }
    }

    vc_map(
        array(
            'name' => __('Royal Slider', 'custom_elements'),
            'base' => 'royal_slider_custom',
            'description' => __('Display selected Royal Slider', 'custom_elements'),
            "category" => 'Content',
            'icon' => 'royal-slider-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "dropdown",
                    "heading" => __("Select slider", 'custom_elements'),
                    "param_name" => "royal_slider_item",
                    "value" => $pageList,
                ),
            )
        )
    );
}

add_action('vc_before_init', 'royal_slider_shortcode_vc');

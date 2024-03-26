<?php

function ggs_section_button_shortcode($atts){

    extract(
        $attributes = shortcode_atts(
            array(
                'text' => '',
                'section_id' => ''
            ), $atts
        )
    );

    ob_start();
    ?>
    <a class="btn btn-primary btn-square btn-scrollto btn-full-width" href="#<?= wp_strip_all_tags( $attributes["section_id"]); ?>"><?= wp_strip_all_tags( $attributes["text"]); ?></a>
    <?php
    return ob_get_clean();

}
add_shortcode("ggs_section_button", "ggs_section_button_shortcode");


function ggs_section_button_shortcode_vc() {
    vc_map(
        array(
            'name'            => __('Scroll to Button', 'custom_elements'),
            'base'            => 'ggs_section_button',
            'description'     => __( 'Button to scroll to any page element based on ID', 'custom_elements' ),
            'category' => 'Nuzest Custom',
            'icon' => 'scroll-to-button-vc-icon',
            'content_element' => true,
            'params'          => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Text", 'custom_elements'),
                    "param_name" => "text",
                    'holder' => 'div'
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Section ID (without #)", 'custom_elements'),
                    "param_name" => "section_id",
                    'holder' => 'div'
                ),
            ),
        )
    );
}
add_action( 'vc_before_init', 'ggs_section_button_shortcode_vc' );

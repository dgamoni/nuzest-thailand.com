<?php

/* 
 * Fixed 'Buy Now' banner 
 */


function sticky_button_shortcode($atts){

    extract(
        $a = shortcode_atts(
            array(
                'title' => '',
                'url' => '',
                'button_title' => '',
                'image_url' => '',
                'description' => '',
                'colour' => '#d7df3a',
                'style' => 'solid'
            ), $atts
        )
    );

    $img = wp_get_attachment_image_src($a["image_url"]);

    $imgSrc = $img[0];

    $inline_styles = 'border-color: '. $a["colour"] .' !important; ';

    if ($a["style"] == "solid")
      $inline_styles .= 'background-color: '. $a["colour"] . ' !important;';

    ob_start();
    ?>

    <div class="bnFixed">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-8 col-centered">
                    <div class="hidden-xs hidden-sm col-md-2">
                        <img src="<?php echo $imgSrc; ?>" alt="<?php echo $a["title"]; ?>" class="img-responsive max-width-100">
                    </div>
                    <div class="hidden-xs hidden-sm col-md-7 bnText">
                        <h5><?php echo $a["title"]; ?></h5>
                        <p><?php echo $a["description"]; ?></p>
                    </div>
                    <div class="col-md-3">
                        <a class="btn <?php echo $a["style"]; ?>" href="<?php echo $a["url"]; ?>" style="<?php echo $inline_styles; ?>"><?php echo $a["button_title"]; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    return ob_get_clean();

}
add_shortcode("sticky_button", "sticky_button_shortcode");


function sticky_button_shortcode_vc() {
    vc_map(
        array(
            'name'            => __('Quick Buy Strip', 'custom_elements'),
            'base'            => 'sticky_button',
            'description'     => __( 'Fixed-bottom Buy Now banner', 'custom_elements' ),
            "category" => 'Nuzest Custom',
            'icon' => 'quick-buy-strip-vc-icon',
            'content_element' => true,
            'params'          => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Title", 'custom_elements'),
                    "param_name" => "title",
                    'holder' => 'div'
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Description", 'custom_elements'),
                    "param_name" => "description",
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Image", "js_composer"),
                    "param_name" => "image_url",
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Button Text", 'custom_elements'),
                    "param_name" => "button_title",
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Button URL", 'custom_elements'),
                    "param_name" => "url",
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Button Colour", 'custom_elements'),
                    "param_name" => "colour",
                    "value" => array(
                        'Green' => '#d7df3a',
                        'Orange' => '#ffb231',
                        'Purple' => '#9673b3',
                        'None' => '#eaece9'

                    ),
                    'admin_label' => true
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Button Style", 'custom_elements'),
                    "param_name" => "style",
                    "value" => array(
                        'Solid' => 'solid',
                        'Outline' => 'outline'
                    ),
                    'admin_label' => true
                ),
            ),
        )
    );
}
add_action( 'vc_before_init', 'sticky_button_shortcode_vc' );

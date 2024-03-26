<?php

function ggs_intersecting_circles_shortcode($atts)
{

    extract(
        $attributes = shortcode_atts(
            array(
                'text1' => '',
                'text2' => '',
                'bg_image' => ''
            ), $atts
        )
    );

    $bg_image = wp_get_attachment_image_src($attributes["bg_image"], 'large');
    $bg_image_style = "";

    if ($bg_image)
      $bg_image_style = "background-image: url('" . $bg_image[0] . "')";

    ob_start();
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="effective-diagram drawOnView good-green-stuff">
                <div class="eff-circle science">
                    <hgroup>
                        <h2><?= wp_strip_all_tags($attributes["text1"]); ?></h2>
                    </hgroup>
                </div>
                <div class="ggs-pack" style="<?php echo $bg_image_style; ?>"></div>
                <div class="eff-circle nature">
                    <hgroup>
                        <h2><?= wp_strip_all_tags($attributes["text2"]); ?></h2>
                    </hgroup>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();

}

add_shortcode("ggs_intersecting_circles", "ggs_intersecting_circles_shortcode");


function ggs_intersecting_circles_shortcode_vc()
{
    vc_map(
        array(
            'name' => __('GGS Science/Nature', 'custom_elements'),
            'base' => 'ggs_intersecting_circles',
            'description' => __('GGS page – Science/Nature animation', 'custom_elements'),
            'category' => 'Nuzest Custom',
            'icon' => 'ggs-science-nature-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Left", 'custom_elements'),
                    "param_name" => "text1",
                    'holder' => 'div'
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Right", 'custom_elements'),
                    "param_name" => "text2",
                    'holder' => 'div'
                ),
                array(
                    'type' => 'attach_image',
                    'heading' => __("Image", 'custom_elements'),
                    'param_name' => 'bg_image',
                    'holder' => 'div'
                ),
            ),
        )
    );
}

add_action('vc_before_init', 'ggs_intersecting_circles_shortcode_vc');

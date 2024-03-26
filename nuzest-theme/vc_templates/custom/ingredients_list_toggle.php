<?php

/* 
 * Custom shortcode for a button that toggles a slide-in Ingredients Post
 */

function ingredients_list_toggle_button_shortcode($atts) {

    extract(
        $attributes = shortcode_atts(
            array(
                'text' => '',
                'colour' => '#d7df3a',
                'style' => 'solid',
                'product_cat' => ''
            ), $atts
        )
    );

    $inline_styles = 'border-color: '. $attributes["colour"] .' !important; ';

    if ($attributes["style"] == "solid")
      $inline_styles .= 'background-color: '. $attributes["colour"] . ' !important;';

    global $ingredient_vc_category;

    if ($attributes["product_cat"] !== "") {
        $ingredient_vc_category = $attributes["product_cat"];
    }

    ob_start();
    ?>
    <div class="ingredients-toggle-btn">
        <a class="btn btn-primary <?php echo $attributes["style"]; ?> toggle-in " style="<?php echo $inline_styles; ?>"><?= wp_strip_all_tags($attributes["text"]); ?></a>
    </div>
    <?php
    return ob_get_clean();

}

add_shortcode("ingredients_list_toggle_button", "ingredients_list_toggle_button_shortcode");


function ingredients_list_toggle_button_shortcode_vc() {

    $productCategoryValues = [__('Select') => ''];
    $productCategoryTerms = get_terms('product_cat', array(
        'orderby' => 'count',
        'hide_empty' => 0
    ));

    foreach ($productCategoryTerms as $productCategoryTerm) {
        $productCategoryValues[$productCategoryTerm->name] = $productCategoryTerm->term_id;
    }

    vc_map(
        array(
            'name' => __('Ingredients List Toggle', 'custom_elements'),
            'base' => 'ingredients_list_toggle_button',
            'description' => __('Button to toggle ingredients panel', 'custom_elements'),
            "category" => 'Nuzest Custom',
            'icon' => 'ingredients-list-toggle-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Text", 'custom_elements'),
                    "param_name" => "text",
                    'holder' => 'div'
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Color", 'custom_elements'),
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
                    "heading" => __("Style", 'custom_elements'),
                    "param_name" => "style",
                    "value" => array(
                        'Solid' => 'solid',
                        'Outline' => 'outline'
                    ),
                    'admin_label' => true
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Product", 'custom_elements'),
                    "param_name" => "product_cat",
                    "value" => $productCategoryValues,
                )
            ),
        )
    );
}

add_action('vc_before_init', 'ingredients_list_toggle_button_shortcode_vc');

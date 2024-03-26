<?php

/* 
 * Product info Blocks 
 */




function bubble_block_content_shortcode($atts) {
	
    extract(
        $attributes = shortcode_atts(
            array(
                'block_type' => '',
                'title' => '',
				'sub_title' => '',
                'image' => '',
                'b_b_position' => '',
                'b_b_peak_position' => '',
                'detail_url' => '',
                'shop_url' => '',
				'colour' => '',
                'items' => ''
            ), $atts
        )
    );

    $items_vars = vc_param_group_parse_atts($attributes['items']);
    $slug = sanitize_title($attributes['title']);
    $attached_image = wp_get_attachment_image_src($attributes['image'], "full");
    $imgClass = ($attributes['b_b_position'] == 'left') ? 'image-right' : '';
    $bubbleContainerClass = ($attributes['b_b_position'] == 'right') ? 'col-md-offset-4 col-lg-offset-5 col-xl-offset-7' : '';
    $scrollingTextClass = ($attributes['b_b_position'] == 'left') ? 'col-md-5 col-lg-5' : 'col-md-5 col-lg-5 col-md-offset-7 col-lg-offset-7';
	
	if ($attributes['block_type'] == 1) {
		wp_enqueue_script('scroll_js', get_template_directory_uri() . '/js/jquery.simplyscroll.min.js', array('jquery'), '', true);
		wp_enqueue_script('simplyScroll_js', get_template_directory_uri() . '/js/simplyScroll.js', array('jquery'), '', true);
	}
	
	ob_start();
		
?>

    <section class="usp-sec <?php echo $slug; ?>">
        <div class="img-wrap <?php echo $imgClass; ?>"
             style="background-image: url('<?php echo $attached_image[0]; ?>');"></div>
        <div class="container">
            <div class="row">
                <?php if ($attributes['block_type'] == 0) : ?>
                    <div class="col-md-8 col-lg-7 col-xl-5 <?php echo $bubbleContainerClass; ?>">
                        <div class="usp-bubble <?php echo $attributes['b_b_peak_position']; ?>">
                            <h2><?php echo $attributes['title']; ?>
															<?php if ( $attributes['sub_title'] != '' ){ ?>
																<small><br><?php echo $attributes['sub_title']; ?></small>
															<?php }; ?>
                           	</h2>

                            <?php if (count($items_vars)) : ?>
                            <ul class="list-unstyled">
                                <?php for ($y = 0; $y < count($items_vars); $y++) : ?>
                                    <?php
                                        $itemicon = wp_get_attachment_image_src($items_vars[$y]['item_icon'], "full");

                                    ?>
                                    <li <?php if($itemicon):?>style="background-image: url(<?=$itemicon[0]?>)"<?php endif;?>>
                                        <h4><?php echo $items_vars[$y]["item_heading"]; ?></h4>
                                        <p class="bubbleBlockText"><?php echo $items_vars[$y]["item_content"]; ?></p>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                            <div class="usp-buttons">

                                <?php if ($attributes['detail_url']) : ?>
                                    <a class="btn btn-primary bubbleBlockButton solid <?php echo $attributes['colour']; ?>"
                                       href="<?php echo $attributes['detail_url']; ?>"><?php _e('Product Info', 'nuzest-theme'); ?></a>
                                <?php endif; ?>

                                <?php if ($attributes['shop_url']) : ?>
                                    <a class="btn btn-primary bubbleBlockButton <?php echo $attributes['colour']; ?>"
                                       href="<?php echo $attributes['shop_url']; ?>"><?php _e('Shop Now', 'nuzest-theme'); ?></php></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php else : ?>
                    <div class="<?php echo $scrollingTextClass; ?>">
                        <h2 class="h1"><?php echo $attributes['title']; ?>
                        </h2>
                        <div class="vert simply-scroll-container">
                            <div class="simply-scroll-clip">
                                <div class="simply-scroll-list" style="height: 1548px;">
                                    <?php if (count($items_vars)) : ?>
                                        <ul class="scroller simply-scroll-list" style="height: 774px;">
                                            <?php for ($y = 0; $y < count($items_vars); $y++) : ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-xs-2">
                                                            <?php $icon = wp_get_attachment_image_src($items_vars[$y]["item_icon"], "full"); ?>
                                                            <img width="56" height="56" src="<?php echo $icon[0]; ?>" class="img-responsive float-right" alt="<?php echo $items_vars[$y]["item_content"]; ?>">
                                                        </div>
                                                        <div class="col-xs-10">
                                                            <h3><?php echo $items_vars[$y]["item_heading"]; ?></h3>
                                                            <p><?php echo $items_vars[$y]["item_content"]; ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endfor; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="usp-buttons">
                        <?php if ($attributes['detail_url']) : ?>
                            <a class="btn btn-primary bubbleBlockButton solid <?php echo $attributes['colour']; ?>"
                               href="<?php echo $attributes['detail_url']; ?>"><?php _e('More Info', 'nuzest-theme'); ?></a>
                        <?php endif; ?>
                        <?php if ($attributes['shop_url']) : ?>
                            <a class="btn btn-primary bubbleBlockButton <?php echo $attributes['colour']; ?>"
                               href="<?php echo $attributes['shop_url']; ?>"><?php _e('Shop Now', 'nuzest-theme'); ?></php></a>
                        <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php
    return ob_get_clean();

}

add_shortcode('bubble_block_skills_content', 'bubble_block_content_shortcode');

// Nested Element
function bubble_block_content_shortcode_vc() {

    $pageList = [__('Select') => ''];
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages();

    foreach($pages as $page) {
        $pageList[get_the_title($page->ID)] = get_page_link($page->ID);
    }

    $productCategoryValues = [__('Select') => ''];
    $productCategoryTerms = get_terms('product_cat', array(
        'orderby' => 'count',
        'hide_empty' => 0
    ));

    foreach ($productCategoryTerms as $productCategoryTerm) {
        $productCategoryValues[$productCategoryTerm->name] = get_term_link($productCategoryTerm);
    }

    vc_map(
        array(
            'name' => __('Product Info Block', 'custom_elements'),
            'base' => 'bubble_block_skills_content',
            'description' => __('Full-width product info sections', 'custom_elements'),
            "category" => 'Nuzest Custom',
            'icon' => 'product-info-blocks-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "dropdown",
                    "heading" => __("Display as", 'custom_elements'),
                    "param_name" => "block_type",
                    "value" => array(
                        'Select' => '',
                        'Speech Bubble' => '0',
                        'Scrolling Text' => '1',
                    ),
					'description' => __('Choose whether to display your list inside a speech bubble or as scrolling text', 'custom_elements'),
                    'admin_label' => true
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Product Title", 'custom_elements'),
                    "param_name" => "title",
                    'holder' => 'div',
                ),
								array(
                    "type" => "textfield",
                    "heading" => __("Sub Title", 'custom_elements'),
                    "param_name" => "sub_title",
                    'holder' => 'div',
                    //'admin_label' => true
                ),
                array(
                    "type" => "attach_image",
                    "heading" => __("Background Image", 'custom_elements'),
                    "param_name" => "image",
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Text Position", 'custom_elements'),
                    "param_name" => "b_b_position",
                    "value" => array(
                        'Select Position' => '',
                        'Right' => 'right',
                        'Left' => 'left',
                    ),
                    'admin_label' => true,
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Speech Bubble Peak", 'custom_elements'),
                    "param_name" => "b_b_peak_position",
                    "value" => array(
                        'Top Right' => 'top_right',
                        'Top Left' => 'top_left',
                        'Bottom Right' => 'bottom_right',
                        'Bottom Left' => 'bottom_left'
                    ),
                    "dependency" => array(
                        "element" => "block_type",
                        "value" => "0"
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Product Information Page (Product Info)", 'custom_elements'),
                    "param_name" => "detail_url",
                    "value" => $pageList,
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Shop Category Page (Shop Now)", 'custom_elements'),
                    "param_name" => "shop_url",
                    "value" => $productCategoryValues,
                ),
				array(
                    "type" => "dropdown",
                    "heading" => __("Button Colour", 'custom_elements'),
                    "param_name" => "colour",
                    "value" => array(
                        'Green' => '', // default btn-primary
                        'Orange' => 'btn-clean-lean-protein',
                        'Purple' => 'btn-kids-good-stuff',
                    ),
                    //'admin_label' => true
                ),
                array(
                    "type" => "param_group",
                    "heading" => __("Items", "custom_elements"),
                    "param_name" => "items",
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => 'Item Icon',
                            'param_name' => 'item_icon',
                            'admin_label' => false,
                            "dependency" => array(
                                "element" => "block_type",
                                "value" => "1"
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Item Heading',
                            'param_name' => 'item_heading',
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textarea',
                            'value' => '',
                            'heading' => 'Item Content',
                            'param_name' => 'item_content',
                        )
                    )
                ),

            ),
        )
    );
}

add_action('vc_before_init', 'bubble_block_content_shortcode_vc');

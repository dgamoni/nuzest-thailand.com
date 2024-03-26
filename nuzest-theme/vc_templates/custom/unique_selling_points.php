<?php

/* 
 * 2-Column Unique Selling Points lists 
 */

function unique_selling_point_shortcode($atts) {

    extract(
        $attributes = shortcode_atts(
            array(
                'items' => ''
            ), $atts
        )
    );

    $items_vars_array = vc_param_group_parse_atts($attributes['items']);
    ob_start();
 ?>

	<div class="usp-list quick-list container">
		<div class="row">	
			<div class="col-md-5 col-md-push-1 col-lg-4 col-lg-push-2">
				<ul class="list-unstyled">
					<?php 
					$count_total_items = count($items_vars_array);			
					$halfway = ceil($count_total_items / 2 - 1);
                	$count = 0;
					foreach ($items_vars_array as $items_vars) : ?>
						<li <?php echo ($count == 0) ? 'class="active"' : ''; ?>>
							<div class="row">
								<?php $icon = wp_get_attachment_image_src($items_vars["item_icon"], "full"); ?>
								<div class="col-xs-3 col-sm-2">
									<img src="<?php echo $icon[0]; ?>" class="img-responsive" alt="<?php echo $items_vars["item_excerpt"];  ?>" height="56" width="56">
								</div>
								<div class="col-xs-9 col-sm-10">
									<h3><?php echo $items_vars["item_heading"]; ?></h3>
									<p><?php echo $items_vars["item_excerpt"]; ?></p>
									<p class="detail" <?php echo ($count == 0) ? 'style="display: block;"' : ''; ?>><?php echo $items_vars["item_content"]; ?></p>
									<p class="quick-arrow"></p>
								</div>
							</div>
							<hr class="clear">
						</li>
						
					<?php if ( $count == $halfway ) {
						echo '</ul></div><div class="col-md-5 col-md-push-1 col-lg-4 col-lg-push-2"><ul class="list-unstyled">'; }
					?>
					<?php $count++; endforeach; ?>
					
				</ul>
			</div>
		</div><!-- .row -->          
	</div><!-- .quick-list -->

    <?php
        return ob_get_clean();
}

add_shortcode('unique_selling_point_content', 'unique_selling_point_shortcode');

function unique_selling_point_shortcode_vc()
{

    vc_map(
        array(
            'name' => __('Product USP List', 'custom_elements'),
            'base' => 'unique_selling_point_content',
            'description' => __('2-column list of expanding USPs', 'custom_elements'),
            "category" => 'Nuzest Custom',
            'icon' => 'product-usp-list-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "param_group",
                    "heading" => __("Items", "custom_elements"),
                    //"holder" => "div",
                    "param_name" => "items", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
                    'params' => array(
                        array(
                            'type' => 'attach_image',
                            'heading' => 'Item Icon',
                            'param_name' => 'item_icon',
                            'admin_label' => true,
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
                            'heading' => 'Item Excerpt',
                            'param_name' => 'item_excerpt',
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

add_action('vc_before_init', 'unique_selling_point_shortcode_vc');

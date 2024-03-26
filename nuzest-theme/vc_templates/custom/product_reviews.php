<?php

/* 
 * Display product reviews 
 */

function product_reviews_shortcode($atts) {

    extract(
        $attributes = shortcode_atts(
            array(
                'product_id' => '',
				'leave_review_button' => '',
				'button_text' => '',
            ), $atts
        )
    );

	ob_start();
	$args = array (
		'post_id' => 237,
	);
	$comments = get_comments($args);
	
	echo ('<ol class="commentlist">');
		foreach($comments as $comment) : ?>
			<li id="li-comment-<?php echo $comment->comment_ID ?>"> 
				<div id="comment-<?php echo $comment->comment_ID ?>" class="comment_container">
					<div class="comment-text">
						<div class="star-rating">
						
							<?php 
								$i = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
								switch ($i) {
								case 0:
									$width = "width:0%"; break;
								case 1:
									$width = "width:20%"; break;
								case 2:
									$width = "width:40%"; break;
								case 3:
									$width = "width:60%"; break;
								case 4:
									$width = "width:80%"; break;
								case 5:
									$width = "width:100%"; break;
								}
							?>
							
							<span style
							="<?php echo $width; ?>">Rated 
							<strong class="rating"><?php echo( intval( get_comment_meta( $comment->comment_ID, 'rating', true ) )); ?></strong> 
							 out of 5
							</span>
							
						</div>
						<p class="meta">
							<strong class="woocommerce-review__author"><?php echo $comment->comment_author ?></strong>
							<span class="woocommerce-review__dash">–</span> <time class="woocommerce-review__published-date" datetime="2018-12-14T17:14:17+00:00">December 14, 2018</time>
						</p>
						<div class="description">
							<?php echo $comment->comment_content ?>
						</div>
					</div>
				</div>
			</li>
		<?php
		endforeach;
	echo ('</ol>');
	
	if ( $attributes['leave_review_button']){
		echo ('<h4>Leave a review</h4>');
		comment_form();
	}
	
	return ob_get_clean();
}
add_shortcode('product_reviews', 'product_reviews_shortcode');


function product_reviews_shortcode_vc() {

    vc_map(
        array(
            'name' => __('Product Reviews', 'custom_elements'),
            'base' => 'product_reviews',
            'description' => __('Display product reviews', 'custom_elements'),
            "category" => 'Nuzest Custom',
            'icon' => 'ingredients-list-toggle-vc-icon',
            'content_element' => true,
            'params' => array(
				array(
                    "type" => "textfield",
                    "heading" => __("Product ID", 'custom_elements'),
                    "param_name" => "product_id",
                    'holder' => 'div',
					"description" => __( "Leave blank if this is a WooCommerce product page", "nuzest-theme" )
                ),
				array(
                    "type" => "textfield",
                    "heading" => __("Add Leave a Review Button?", 'custom_elements'),
                    "param_name" => "leave_review_button",
                    'holder' => 'div',
					"type" => "checkbox",
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Button Text", 'custom_elements'),
                    "param_name" => "button_text",
                    'holder' => 'div',
					"dependency" => array(
                         "element" => "leave_review_button",
                         "value" => 'true'
                    ),
                ),
            ),
        )
    );
}

add_action('vc_before_init', 'product_reviews_shortcode_vc');

?>
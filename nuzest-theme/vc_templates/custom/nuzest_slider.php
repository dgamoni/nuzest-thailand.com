<?php

/* 
 * Custom shortcode to place a Nuzest Slider 
 */

function nuzest_slider_shortcode($atts) {
	wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/css/owl-carousel/owl.carousel.css');
    wp_enqueue_style('owl.theme', get_template_directory_uri() . '/css/owl-carousel/owl.theme.css');
    wp_enqueue_style('owl.transitions', get_template_directory_uri() . '/css/owl-carousel/owl.transitions.css');
	wp_enqueue_script('owl_carusel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.js', array('jquery'), '1.0.0', true);
    extract(
        $attributes = shortcode_atts(
            array(
				'nuzest_slider_type' => '',
				'nuzest_slider_transition' => '',
				'nuzest_slider_arrow' => '',
				'nuzest_slider_pagination' => '',
				'nuzest_slider_post_type' => '',
				'nuzest_carousel_sliders' => '',
				'nuzest_sliders' => '',
				'nuzest_hide_slide' => '',
				'nuzest_slide_image' => '',
				'nuzest_slide_heading' => '',
				'nuzest_slide_heading_tag' => '',
				'nuzest_slide_content' => '',
				'nuzest_slider_content_white' => '',
				'nuzest_slider_show_button' => '',
				'nuzest_button_text' => '',
				'nuzest_slider_button_style' => '',
				'nuzest_slider_button_colour' => '',
				'nuzest_slide_button_url' => '',
				'nuzest_slider_feature_banner_content_position' => ''
            ), $atts
        )
    );

    $nuzest_slider_type = $attributes['nuzest_slider_type'];
	$nuzest_slider_transition = $attributes['nuzest_slider_transition'];
	$nuzest_slider_arrow = $attributes['nuzest_slider_arrow'];
	$nuzest_slider_pagination = $attributes['nuzest_slider_pagination'];
	$nuzest_slider_post_type = $attributes['nuzest_slider_post_type'];
	$nuzest_sliders = vc_param_group_parse_atts($attributes['nuzest_sliders']);
	$nuzest_carousel_sliders = vc_param_group_parse_atts($attributes['nuzest_carousel_sliders']);
    ob_start();
?>
   
    <section class="nuzest_slider <?php echo $nuzest_slider_type; ?>">	
		<?php
				if(empty($nuzest_slider_arrow)){
			?>
				<style>
					.nuzest_slider .owl-nav{
						display: none
					}
				</style>
			<?php } 
				if(empty($nuzest_slider_pagination)){
			?>
				<style>
					.nuzest_slider #owl-feature-banner .owl-dots{
						display: none
					}
					.nuzest_slider #owl-carousel-slide .owl-dots{
						display: none
					}
				</style>
			<?php } 
		if($nuzest_slider_type == 'feature_banner'){
		?>
		<div id="owl-feature-banner" class="owl-carousel">
			<?php for ($y = 0; $y < count($nuzest_sliders); $y++) : ?>
			<?php 
				$nuzest_hide_slide = $nuzest_sliders[$y]['nuzest_hide_slide'];
				$nuzest_slide_image = wp_get_attachment_image_src($nuzest_sliders[$y]['nuzest_slide_image'], "full"); 
				$nuzest_slide_heading = $nuzest_sliders[$y]['nuzest_slide_heading'];
				$nuzest_slide_heading_tag = $nuzest_sliders[$y]['nuzest_slide_heading_tag'];
				$nuzest_slide_content = $nuzest_sliders[$y]['nuzest_slide_content'];	
				$nuzest_slider_show_button = $nuzest_sliders[$y]['nuzest_slider_show_button'];
				$nuzest_slider_content_white = $nuzest_sliders[$y]['nuzest_slider_content_white'];
				$nuzest_slider_button_text = $nuzest_sliders[$y]['nuzest_slider_button_text'];
				$nuzest_slider_button_style = $nuzest_sliders[$y]['nuzest_slider_button_style'];
				$nuzest_slider_button_colour = $nuzest_sliders[$y]['nuzest_slider_button_colour'];
				$nuzest_slide_button_url = $nuzest_sliders[$y]['nuzest_slide_button_url'];
				$nuzest_slider_feature_banner_content_position = $nuzest_sliders[$y]['nuzest_slider_feature_banner_content_position'];
			if ($nuzest_hide_slide != true){
			?>
				<div class="item" style="background: url('<?php echo $nuzest_slide_image[0]; ?>') no-repeat center; background-size:cover;">
					<div class="container">
						<div class="row">
							<div class="<?php echo $nuzest_slider_feature_banner_content_position; ?>">
								<?php
									if($nuzest_slider_content_white == true){
										$content_color = "slide-content-white";
									}
								echo "<".$nuzest_slide_heading_tag." class='h1 slide-heading ".$content_color."'>";
									?>
									<?php echo $nuzest_slide_heading; ?>
								<?php echo "</".$nuzest_slide_heading_tag.">"; ?>
								<p class="slide-content <?php echo $content_color; ?>"><?php echo $nuzest_slide_content; ?></p>
								<?php
									if($nuzest_slider_show_button == true){
									?>
										<a href="<?php echo $nuzest_slide_button_url ?>" class="btn <?php echo $nuzest_slider_button_colour; echo " ". $nuzest_slider_button_style; ?>"><?php echo $nuzest_slider_button_text; ?></a>
									<?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
			<?php 
			}
			endfor; ?>

		</div>

		<?php
		}
		if($nuzest_slider_type == 'posts_banner'){
			?>
			<div class="container">
				<div id="owl-post-banner" class="owl-carousel">

				<?php
				$query = new WP_Query(array(
					'post_type' => $attributes['nuzest_slider_post_type'],
					'post_status' => 'publish',
					'posts_per_page' => 3,
				));

				while ($query->have_posts()) {
					$query->the_post();
					$post_id = get_the_ID();
					$thumb_id = get_post_thumbnail_id();
                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
					$thumb_url = $thumb_url_array[0];
					$terms = get_the_terms( $query->post->ID, 'dietary' );
					?>
					<div class="item" style="background: #fff; overflow: hidden">
						<div class="col-sm-8 col-md-9 col-xl-10">
							<img class="img-responsive" width="100%" alt="<?= get_the_title(); ?>" src="<?= $thumb_url ?>" style="margin-left: -15px">
						</div>
					 	<div class="col-sm-4 col-md-3 col-xl-2">
							<div class="info">
                                    <h2 class="title">
                                        <a target="_self" href="<?= get_the_permalink() ?>" onclick="location.reload()">
                                            <?= get_the_title(); ?>
                                        </a>
                                    </h2>
									<div class="recipe-tags clearfix">
										<?php
											if (is_array($terms)) {
												foreach ( array_slice($terms, 0, 3) as $term ) {
													$diet = $term->name;
													?>
													<p class="snip-tag"><span><?php echo $diet ?></span></p>
													<?php
												}
											} 
										?>
									</div>
                                    <p class="hidden-xs hidden-sm">
                                    <p>
                                        <?= wp_trim_words(get_the_excerpt(), 24); ?>
                                    </p>
                            </div>
                            <a class="btn btn-primary" target="_self" href="<?= get_the_permalink() ?>"><?php _e('Read more', 'nuzest-theme') ?></a></div>
					</div>
					<?php
				}

				wp_reset_query();
				?>
				</div>
			</div>
		<?php
		}
		if($nuzest_slider_type == 'carousel'){
		?>
		<div class="container">
			<div id="owl-carousel-slide" class="owl-carousel">
				<?php for ($y = 0; $y < count($nuzest_carousel_sliders); $y++) : ?>
				<?php 
					$nuzest_slide_image = wp_get_attachment_image_src($nuzest_carousel_sliders[$y]['nuzest_slide_image'], "full"); 
					$nuzest_slide_heading = $nuzest_carousel_sliders[$y]['nuzest_slide_heading'];	
					$nuzest_slide_content = $nuzest_carousel_sliders[$y]['nuzest_slide_content'];	
				?>
					<div class="item" style="text-align: center;">
						<div class="slide-img">
							<img src="<?php echo $nuzest_slide_image[0]; ?>" >
						</div>
						<div class="slide-text">
							<h2 class="slide-heading"><?php echo $nuzest_slide_heading; ?></h2>
							<p class="slide-content"><?php echo $nuzest_slide_content; ?></p>
						</div>
						
					</div>
				<?php 
				endfor; ?>
			</div>
		</div>
		<?php
		}
		?>
    </section>
	<script>
		jQuery(document).ready(function ($) {
			owl = $("#owl-feature-banner");
				owl.owlCarousel({
					items: 1,
					loop: true,
					autoplay:true,
					lazyLoad: true,
				});
			owl2 = $("#owl-post-banner");
			owl2.owlCarousel({
					items: 1,
					loop: false,
					lazyLoad: true,
			});
			
			owl3 = $("#owl-carousel-slide");
			owl3.owlCarousel({
					center:true,
					loop: true,
					autoplay:true,
					lazyLoad: true,
					smartSpeed:250,
					nav: true,
					responsive:{
						0:{
							items:1,
							nav:false
						},
						600:{
							items:1.5
						}
					}
			});
			
			var sHeight = $(window).width()*0.50;
			 $('.nuzest_slider.feature_banner .item').css('height', sHeight); 
			 $(window).resize(function() {      
				$('.nuzest_slider.feature_banner .item').css('height', sHeight); 
			 });
			 var sHeight_post = $(window).width()*0.32;
			 $('.nuzest_slider.posts_banner .item').css('height', sHeight_post); 
			 $(window).resize(function() {      
				$('.nuzest_slider.posts_banner .item').css('height', sHeight_post); 
			 });
		});
	</script>	
   
    <?php

}

add_shortcode('nuzest_slider_custom', 'nuzest_slider_shortcode');

function nuzest_slider_shortcode_vc() {

		$categories_array = array();
		$categories = get_categories(array('taxonomy' => 'category',));
		foreach( $categories as $value ) {
			$categories_array[$value->name] = $value->slug;
		}	
		$product_cat_array = array();
		$product_cat = get_categories(array('taxonomy' => 'product_cat',));
		foreach( $product_cat as $value ) {
			$product_cat_array[$value->name] = $value->slug;
		}
		$dietary_array = array();
		$dietary = get_categories(array('taxonomy' => 'dietary',));
		foreach( $dietary as $value ) {
			$dietary_array[$value->name] = $value->slug;
		}
		$meal_type_array = array();
		$meal_type = get_categories(array('taxonomy' => 'dietary',));
		foreach( $meal_type as $value ) {
			$meal_type_array[$value->name] = $value->slug;
		}
	
    vc_map(
        array(
            'name' 			=> __('Nuzest Slider', 'custom_elements'),
            'base' 			=> 'nuzest_slider_custom',
            'description' 	=> __('Display selected Nuzest Slider', 'custom_elements'),
            "category" 		=> 'Nuzest Custom',
            'icon' 			=> 'nuzest-slider-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" 			=> "dropdown",
                    "heading" 		=> __("Select slider", 'custom_elements'),
                    "param_name" 	=> "nuzest_slider_type",
                    "value" 		=> array(
						'Select slider type'  	=> "select",
						'Feature banner'  		=> "feature_banner",
						'Posts banner'   		=> "posts_banner",
						'Carousel'   			=> 'carousel'
						  ),
						'std'         			=> 'select',
					"description" 				=> __( "Slider type", "nuzest-theme" )
                ),
				array(
                    'type' 			=> 'checkbox',
                    "heading" 		=> __("Display slider arrow", 'custom_elements'),
                    "param_name" 	=> "nuzest_slider_arrow",
					"description" 	=> __( "Check the box for display slider arrow", "nuzest-theme" )
                ),
				array(
                    "type" 			=> 'checkbox',
                    "heading" 		=> __("Display slider pagination", 'custom_elements'),
                    "param_name" 	=> "nuzest_slider_pagination",
					"description" 	=> __( "Check the box for display slider pagination", "nuzest-theme" )
                ),
				array(
                    "type" 			=> "dropdown",
                    "heading" 		=> __("Select post slider type", 'custom_elements'),
                    "param_name" 	=> "nuzest_slider_post_type",
                    "value" => array(
						'Select post type' 	=> "",
						'Blog Posts'   		=> "post",
						'Recipes'   		=> "recipes",
						  ),
					"description" 	=> __( "Post slider type", "nuzest-theme" ),
					"dependency" 	=> array(
                        "element" 		=> "nuzest_slider_type",
                        "value" 		=> "posts_banner"
                    ),
                ),
				array(
                    "type" => "dropdown",
                    "heading" 		=> __("Number of posts display", 'custom_elements'),
                    "param_name" 	=> "nuzest_slider_post_number",
                    "value" 		=> array(
						'3'   	=> 3,
						'5'		=> 5,
						'7'		=> 7,
						  ),
						'std'   => 5,
					"description" 	=> __( "Post slider number", "nuzest-theme" ),
					"dependency" 	=> array(
                        "element" 		=> "nuzest_slider_type",
                        "value" 		=> "posts_banner"
                    ),
                ),
				array(
					"type" => "checkbox",
					"heading" => __( "Blog product categories", "nuzest-theme" ),
					"param_name" => "blog_categories",
					"value" => $product_cat_array,
					"description" => __( "Choose which blog categories are showing on the filter bar", "nuzest-theme" ),
					"dependency" => array(
                         "element" => "nuzest_slider_post_type",
                         "value" => "blog_posts"
                    ),
				),
				array(
					"type" => "checkbox",
					"heading" => __( "Blog categories", "nuzest-theme" ),
					"param_name" => "blog_categories",
					"value" => $categories_array,
					"description" => __( "Choose which blog categories are showing on the filter bar", "nuzest-theme" ),
					"dependency" => array(
                         "element" => "nuzest_slider_post_type",
                         "value" => "blog_posts"
                    ),
				),
				array(
					"type" => "checkbox",
					"heading" => __( "Recipes product categories", "nuzest-theme" ),
					"param_name" => "recipes_categories",
					"value" => $product_cat_array,
					"description" => __( "Choose which recipes categories are showing on the filter bar", "nuzest-theme" ),
					"dependency" => array(
                         "element" => "nuzest_slider_post_type",
                         "value" => "recipes"
                    ),
				),
				array(
					"type" => "checkbox",
					"heading" => __( "Dietary dietaries", "nuzest-theme" ),
					"param_name" => "dietary_categories",
					"value" => $dietary_array,
					"description" => __( "Choose which recipes categories are showing on the filter bar", "nuzest-theme" ),
					"dependency" => array(
                         "element" => "nuzest_slider_post_type",
                         "value" => "recipes"
                    ),
				),
				array(
					"type" => "checkbox",
					"heading" => __( "Meal type dietaries", "nuzest-theme" ),
					"param_name" => "meal_type_categories",
					"value" => $meal_type_array,
					"description" => __( "Choose which recipes categories are showing on the filter bar", "nuzest-theme" ),
					"dependency" => array(
                         "element" => "nuzest_slider_post_type",
                         "value" => "recipes"
                    ),
				),
				
				array(
                    "type" => "param_group",
                    "heading" => __("Nuzest sliders", "custom_elements"),
                    "param_name" => "nuzest_carousel_sliders",
					"dependency" => array(
                         "element" => "nuzest_slider_type",
                         "value" => "carousel"
                    ),
                    'params' => array(
						array(
                            'type' => 'attach_image',
                            'heading' => 'Slide image',
                            'param_name' => 'nuzest_slide_image',
                            'admin_label' => true,
                        ),
						array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Slide Heading',
                            'param_name' => 'nuzest_slide_heading',
                        ),
                        array(
                            'type' => 'textarea',
                            'value' => '',
                            'heading' => 'Slide Content',
                            'param_name' => 'nuzest_slide_content',
                        ),
					),
				),
				
				array(
                    "type" => "param_group",
                    "heading" => __("Nuzest sliders", "custom_elements"),
                    "param_name" => "nuzest_sliders",
					"dependency" => array(
                         "element" => "nuzest_slider_type",
                         "value" => "feature_banner"
                    ),
                    'params' => array(
						array(
						  "type" => "checkbox",
						  "heading" => __( "Hide slide", "nuzest-theme" ),
						  "param_name" => "nuzest_hide_slide",
						  "description" => __( "Check the box for hide this slide", "nuzest-theme" )
						),
                        array(
                            'type' => 'attach_image',
                            'heading' => 'Slide image',
                            'param_name' => 'nuzest_slide_image',
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Slide Heading',
                            'param_name' => 'nuzest_slide_heading',
                        ),
						array(
							"type" => "dropdown",
							"heading" => __("Heading tag", 'custom_elements'),
							"param_name" => "nuzest_slide_heading_tag",
							"value" => array(
								'H1'   => "h1",
								'H2'   => "h2"
								  ),
								'std'         => 'h2',
							"description" => __( "Heading tag for SEO", "nuzest-theme" )
						),
                        array(
                            'type' => 'textarea',
                            'value' => '',
                            'heading' => 'Slide Content',
                            'param_name' => 'nuzest_slide_content',
                        ),
						array(
                            'type' => 'checkbox',
                            'heading' => 'Text white',
                            'param_name' => 'nuzest_slider_content_white',
							"description" => __( "Check the box for slide content white", "nuzest-theme" )
                        ),
						array(
                            'type' => 'checkbox',
                            'heading' => 'Show button',
                            'param_name' => 'nuzest_slider_show_button',
							"description" => __( "Check the box for display button", "nuzest-theme" )
                        ),
						array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Button text',
                            'param_name' => 'nuzest_slider_button_text',
                        ),
						array(
							"type" => "dropdown",
							"heading" => __("Button style", 'custom_elements'),
							"param_name" => "nuzest_slider_button_style",
							"value" => array(
								'Outline'   => "",
								'Solid'   => "solid"
								  ),
								'std'         => 'outline',
							"description" => __( "Button style", "nuzest-theme" )
						),
						array(
							"type" => "dropdown",
							"heading" => __("Button colour", 'custom_elements'),
							"param_name" => "nuzest_slider_button_colour",
							"value" => array(
								'Select color'   => "",
								'Grey'   => "btn-default",
								'Green'   => "btn-primary",
								'Orange'   => "btn-orange",
								'Purple'   => "btn-purple"
								  ),
							"description" => __( "Button colour", "nuzest-theme" )
						),
						array(
                            'type' => 'textfield',
                            'heading' => 'Link to page',
                            'param_name' => 'nuzest_slide_button_url',
							"description" => __( "Please enter the URL(include http://)", "nuzest-theme" )
                        ),
						array(
							"type" => "dropdown",
							"heading" => __("Feature banner content position", 'custom_elements'),
							"param_name" => "nuzest_slider_feature_banner_content_position",
							"value" => array(
								'Left'   => 'col-sm-6 text-left',
								'Left (wide)'   => 'col-sm-8 text-left',
								'Center'   => 'col-sm-6 col-sm-offset-3 text-center',
								  ),
								'std'         => 'left',
							"description" => __( "Post slider feature banner content postion", "nuzest-theme" ),
						),
                    ),
                ),
            ),
        )
    );
}

add_action('vc_before_init', 'nuzest_slider_shortcode_vc');

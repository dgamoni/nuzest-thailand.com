<?php

/* 
 * Custom shortcode to place a Nuzest Slider 
 */

function video_banner_shortcode($atts) {
    extract(
        $attributes = shortcode_atts(
            array(
				'nuzest_video_embeded_url' => '',
				'nuzest_video_media_url' => '',
				'nuzest_slide_heading_video' => '',
				'nuzest_slide_content_video' => '',
				'nuzest_slide_heading' => '',
				'nuzest_slide_content' => '',
				'nuzest_slider_content_white' => '',
				'nuzest_slider_show_button' => '',
				'nuzest_button_text' => '',
				'nuzest_slider_button_style' => '',
				'nuzest_slider_button_colour' => '',
				'nuzest_slide_button_url' => '',
				'nuzest_slider_button_text' => '',
				'nuzest_slider_feature_banner_content_position' => ''
            ), $atts
        )
    );

	$nuzest_sliders = vc_param_group_parse_atts($attributes['nuzest_sliders']);
	$nuzest_carousel_sliders = vc_param_group_parse_atts($attributes['nuzest_carousel_sliders']);
    ob_start();
?>
    <section class="nuzest_slider <?php echo $nuzest_slider_type; ?>">	
		<div id="video-banner" class="video-banner">
					<div class="item-video video_slide">
						<div class="video_content">
						<div class="container">
						<div class="row">
							<div class="<?php echo $nuzest_slider_feature_banner_content_position; ?>">
								<?php
									if($nuzest_slider_content_white == true){
										$content_color = "slide-content-white";
									}
									?>
							<h2 class="slide-heading <?php echo $content_color; ?>"><?php echo $nuzest_slide_heading_video; ?></h2>
							<p class="slide-content <?php echo $content_color; ?>"><?php echo $nuzest_slide_content_video; ?></p>
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
							if(!empty($nuzest_video_embeded_url)){
								echo $nuzest_video_embeded_url;
							}
							else if($nuzest_video_media_url){
						?>
								<video id="banner_video" width="100%" controls autoplay loop>
									<source src="<?php echo $nuzest_video_media_url ?>">
								  Your browser does not support the video tag.
								</video>
						<?php
							}
						?>

					</div>

		</div>
    </section>
	<script>
		jQuery(document).ready(function ($) {
			$('.page-loading').css('opacity',0);
			setTimeout(function(){
			$('.page-loading').hide();
			}, 2000);
				$('video').prop('muted',true);
				$('video').attr('data-keepplaying', 'true');

			var sHeight = $(window).width()*0.50;
			 $('.video_banner .item').css('height', sHeight); 
			 $(window).resize(function() {      
				$('.video_banner .item').css('height', sHeight); 
			 });
		});
	</script>
   
    <?php

}

add_shortcode('nuzest_video_banner', 'video_banner_shortcode');

function video_banner_shortcode_vc() {
	
    vc_map(
        array(
            'name' 			=> __('Video banner', 'custom_elements'),
            'base' 			=> 'nuzest_video_banner',
            'description' 	=> __('Display video banner', 'custom_elements'),
            "category" 		=> 'Nuzest Custom',
            'icon' 			=> 'video-banner-vc-icon',
            'content_element' => true,
            'params' => array(

						array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Embeded video URL',
                            'param_name' => 'nuzest_video_embeded_url',
                        ),
						array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Media library video URL',
                            'param_name' => 'nuzest_video_media_url',
                        ),
						array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Slide Heading',
                            'param_name' => 'nuzest_slide_heading_video',
                        ),
                        array(
                            'type' => 'textarea',
                            'value' => '',
                            'heading' => 'Slide Content',
                            'param_name' => 'nuzest_slide_content_video',
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
        )
    );
}

add_action('vc_before_init', 'video_banner_shortcode_vc');

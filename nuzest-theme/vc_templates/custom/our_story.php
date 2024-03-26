<?php

/* 
 * Depreciated
 * About Us > Our Story
 */

function our_story_menu_shortcode($atts, $content = null) {
    $output = '<div class="skills-wrapper">' . do_shortcode($content) . '</div>';
    return $output;
}

add_shortcode('our_story_menu_skills', 'our_story_menu_shortcode');

/**
 * The Shortcode
 */
function our_story_menu_content_shortcode($atts) {


    extract(
        shortcode_atts(
            array(
                'header_1' => '',
                'subheader_1' => '',
                'slide_1' => '',
                'header_2' => '',
                'slide_2' => '',
                'header_3' => '',
                'slide_3' => ''
            ), $atts
        )
    );

    $output = '';
	wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/css/owl-carousel/owl.carousel.css');
    wp_enqueue_style('owl.theme', get_template_directory_uri() . '/css/owl-carousel/owl.theme.css');
    wp_enqueue_style('owl.transitions', get_template_directory_uri() . '/css/owl-carousel/owl.transitions.css');
	wp_enqueue_script('owl_carusel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.js', array('jquery'), '1.0.0', true);
    //return $output;
	?>
	<section id="story" class="content-sec">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-4">

				<div class="story-slider owl-carousel">
					<div class="item">
						<h1 data-title="<?php echo $header_1 ?>'"><?php echo $header_1 ?></h1>
						<strong><?php echo $subheader_1 ?></strong>
						<p><?php echo $slide_1 ?>'</p>
					</div>

					<div class="item">
							<h1 data-title="<?php echo $header_2 ?>"><?php echo $header_2 ?></h1>
						<p><?php echo $slide_2 ?></p>
					</div>

					<div class="item">
							<h1 data-title="<?php echo $header_3 ?>"><?php echo $header_3 ?></h1>
						<p><?php echo $slide_3 ?></p>
					</div>
				</div>
				<div class="slide-nav btn-group btn-group-justified carousel-custom-dots" id="carousel-custom-dots" >
					<a href="#" class="btn btn-primary active owl-dot"><?php echo $header_1 ?></a>
					<a href="#" class="btn btn-primary owl-dot"><?php echo $header_2 ?></a>
					<a href="#" class="btn btn-primary owl-dot"><?php echo $header_3 ?></a>
				</div>

			</div>
		</div>
	</div>
</section>
	<script>
		jQuery(document).ready(function ($) {
			$(".story-slider").owlCarousel({
				 items: 1,
				 autoplay: true,
				 autoplayTimeout: 5000,
				 autoplayHoverPause: true, 
				 dots: true,
				 dotsContainer: '#carousel-custom-dots',
				 nav: true,
				 navRewind: true,
				 loop: true,
			});
		$('.owl-dot').click(function (e) {
			e.preventDefault();
			$("#carousel-custom-dots .active").removeClass("active");
			$(this).addClass("active");
			$(".story-slider").trigger('to.owl.carousel', [$(this).index(), 400]);
		});
		});	
		
	</script>
	<?php
}

add_shortcode('our_story_menu_skills_content', 'our_story_menu_content_shortcode');


// Nested Element
function our_story_menu_content_shortcode_vc() {
    vc_map(
        array(
            'name' => __('Our Story', 'custom_elements'),
            'base' => 'our_story_menu_skills_content',
            'description' => __('About page - our story tabs', 'custom_elements'),
            'admin_enqueue_css' => array(get_template_directory_uri() . '/css/styles/vc_extend/our_story.css'),
            'category' => 'Nuzest Custom',
            'icon' => 'our-story-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "textfield",
                    "admin_label" => "Title 1",
                    "heading" => __("Title 1", 'nuzest-theme'),
                    "param_name" => "header_1",
                    'holder' => 'div'
                ),
                array(
                    "type" => "textarea",
                    "admin_label" => "Subtitle 1",
                    "heading" => __("Subtitle 1", 'nuzest-theme'),
                    "param_name" => "subheader_1",
                    'holder' => 'div'
                ),
                array(
                    "type" => "textarea",
                    "class" => 'big_textarea',
                    "admin_label" => "Text 1",
                    "heading" => __("Text 1", 'nuzest-theme'),
                    "param_name" => "slide_1",
                    'holder' => 'div'
                ),
                array(
                    "type" => "textfield",
                    "admin_label" => "Title 2",
                    "heading" => __("Title 2", 'nuzest-theme'),
                    "param_name" => "header_2",
                    'holder' => 'div'
                ),
                array(
                    "type" => "textarea",
                    "class" => 'big_textarea',
                    "admin_label" => "Text 2",
                    "heading" => __("Text 2", 'nuzest-theme'),
                    "param_name" => "slide_2",
                    'holder' => 'div'
                ),
                array(
                    "type" => "textfield",
                    "admin_label" => "Title 3",
                    "heading" => __("Title 3", 'nuzest-theme'),
                    "param_name" => "header_3",
                    'holder' => 'div'
                ),
                array(
                    "type" => "textarea",
                    "class" => 'big_textarea',
                    "admin_label" => "Text 3",
                    "heading" => __("Text 3", 'nuzest-theme'),
                    "param_name" => "slide_3",
                    'holder' => 'div'
                )
            )
        )
    );
}

add_action('vc_before_init', 'our_story_menu_content_shortcode_vc');
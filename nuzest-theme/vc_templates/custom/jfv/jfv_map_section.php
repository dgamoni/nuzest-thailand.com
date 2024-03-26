<?php

function jfv_map_section_shortcode($atts) {

    extract(
        $attributes = shortcode_atts(
            array(
                'brazil' => '',
                'belgium' => '',
        				'germany' => '',
        				'philippines' => '',
        				'australia' => '',
            ), $atts
        )
    );

    ob_start();
    ?>
	<div class="row map-row">
	<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-xl-6 col-xl-offset-3">
		<div class="map-layer">
			<img class="img-responsive" src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-map.png">

				<a class="location loc-1">
				<img src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-locationcircle.png">
				</a>
				<div class="loc-inner" id="loc-1">
					<img src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-locationcircle.png">
					<p><strong class="uppercase">Brazil </strong><br class="hidden-xs hidden-sm"><?= wp_strip_all_tags($attributes["brazil"]); ?></p>
				</div>
				<a class="location loc-2">
				<img src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-locationcircle.png">
				</a>
				<div class="loc-inner" id="loc-2">
					<img src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-locationcircle.png">
					<p><strong class="uppercase">Belgium </strong><br class="hidden-xs hidden-sm"><?= wp_strip_all_tags($attributes["belgium"]); ?></p>
					<img src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-locationcircle.png">
					<p><strong class="uppercase">Germany </strong><br class="hidden-xs hidden-sm"><?= wp_strip_all_tags($attributes["germany"]); ?></p>
				</div>
				<a class="location loc-3">
				<img src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-locationcircle.png">
				</a>
				<div class="loc-inner" id="loc-3">
					<img src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-locationcircle.png">
					<p><strong class="uppercase">Philippines </strong><br class="hidden-xs hidden-sm"><?= wp_strip_all_tags($attributes["philippines"]); ?></p>
				</div>
				<a class="location loc-4">
				<img src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-locationcircle.png">
				</a>
				<div class="loc-inner" id="loc-4">
					<img src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-locationcircle.png">
					<p><strong class="uppercase">Australia </strong><br class="hidden-xs hidden-sm"><?= wp_strip_all_tags($attributes["australia"]); ?></p>
				</div>

			<img class="stamp" src="<?php bloginfo( 'template_directory' );?>/images/jfv/JFV-webpage-sustainablestamp.png">
		</div>
	</div>

</div>
<script type="text/javascript">
jQuery(function($){
$(document).ready(function(){
  $('.map-layer .location').click(function(){
    $('.loc-inner').hide();
      var className = $(this).attr('class').split(' ')[1];
      $('#'+ className).show();
    });
  });
});
</script>
    <?php
    return ob_get_clean();

}

add_shortcode("jfv_map_section", "jfv_map_section_shortcode");


function jfv_map_section_shortcode_vc() {
    vc_map(
        array(
            'name' => __('JFV Map Section', 'custom_elements'),
            'base' => 'jfv_map_section',
            'description' => __('JFV page – display ingredient source map', 'custom_elements'),
            'category' => 'Nuzest Custom',
            'icon' => 'jfv-map-section-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Brazil", 'custom_elements'),
                    "param_name" => "brazil",
                    'holder' => 'div'
                ),
				array(
                    "type" => "textfield",
                    "heading" => __("Germany", 'custom_elements'),
                    "param_name" => "germany",
                    'holder' => 'div'
                ),
				array(
                    "type" => "textfield",
                    "heading" => __("Belgium", 'custom_elements'),
                    "param_name" => "belgium",
                    'holder' => 'div'
                ),
				array(
                    "type" => "textfield",
                    "heading" => __("Philippines", 'custom_elements'),
                    "param_name" => "philippines",
                    'holder' => 'div'
                ),
				array(
                    "type" => "textfield",
                    "heading" => __("Australia", 'custom_elements'),
                    "param_name" => "australia",
                    'holder' => 'div'
                ),
            ),
        )
    );
}

add_action('vc_before_init', 'jfv_map_section_shortcode_vc');

<?php

function most_effective_section_bottom_shortcode($atts)
{

    extract(
        $attributes = shortcode_atts(
            array(
                'background_color' => '',
								'divider_position' => '',
            ), $atts
        )
    );

    $background_color = $attributes['background_color'];
		$divider_position = $attributes['divider_position'];

    if ($divider_position == 'true') {
	?>
	
		<div class="section-divider" style="position:relative; top:-1px; padding:0; text-align: center;">
       <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 140 70" style="enable-background:new 0 0 140 70; max-height: 70px;" xml:space="preserve">
				<style type="text/css">
					.st0{fill:<?php echo $background_color; ?>;}
				</style>
				<path class="st0" d="M-1.7,0C34.1,5.7,62.5,33.3,68,69.1l0,0c1.4,1.2,2.8,1.1,4.1,0l0,0C77.5,33.3,105.9,5.7,141.7,0H-1.7z"/>
			</svg>
    </div>
    
    
    <?php } else { ?>
	
    <div class="section-divider">
        <div class="spacer left" style="background-color: <?php echo $background_color; ?>; z-index:1;"></div>
        <div class="spacer right" style="background-color: <?php echo $background_color; ?>; z-index:1;"></div>
    </div>
    
    <?php } 

}

add_shortcode("most_effective_section_bottom", "most_effective_section_bottom_shortcode");


function most_effective_section_bottom_shortcode_vc()
{
    vc_map(
        array(
            'name' => __('Nuzest Section Divider', 'custom_elements'),
            'base' => 'most_effective_section_bottom',
            'description' => __('Bubble-bottom section divider', 'custom_elements'),
            'category' => 'Nuzest Custom',
            'icon' => 'nuzest-section-divider-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Background Color", 'custom_elements'),
                    "param_name" => "background_color",
                ),
				array(
                    "type" => "checkbox",
                    "heading" => __("Inverted/Top position?", 'custom_elements'),
                    "param_name" => "divider_position",
					"value" => __( "top", "my-text-domain" ),
                )
            )
        )
    );
}

add_action('vc_before_init', 'most_effective_section_bottom_shortcode_vc');

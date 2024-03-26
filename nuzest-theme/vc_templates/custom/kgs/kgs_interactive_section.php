<?php

/**
 * The Shortcode
 */
function kgs_interactive_section_shortcode( $atts, $content = null ) {
    $output = '<div class="skills-wrapper">'. do_shortcode($content) .'</div>';
    return $output;
}
add_shortcode( 'kgs_interactive_section_skills', 'kgs_interactive_section_shortcode' );

/**
 * The Shortcode
 */
function kgs_interactive_section_content_shortcode( $atts) {


    //TODO _e('Ingredients List', 'nuzest-theme')

    extract(
        $attributes = shortcode_atts(
            array(
                'bubble_size' => '',
                'nutrients_bubbles' => '',
                'image' => ''
            ), $atts
        )
    );


    $nutrients_bubbles_vars = vc_param_group_parse_atts($nutrients_bubbles);

    $attached_image = wp_get_attachment_image_src($attributes['image'], "full");

    if($attached_image[0] == "") {
        $custombgdefault = get_template_directory_uri() . '/images/kgs/nutrients-pack.png';
        $custombg = ' style="background: url('.$custombgdefault.') no-repeat scroll center top / cover;"';
    } else {
        $custombg = ' style="background: url('.$attached_image[0].') no-repeat scroll center top / cover;"';
    }


    $output =
        '<!-- kids good stuff interactive section -->
        <style>
body.kids-good-stuff .kgs-nutrients:before { height: 0 !important; }
body.kids-good-stuff .kgs-nutrients { padding-top: 0 !important; }
.in-backdrop { z-index: 10; }
        </style>
<div class="kids-good-stuff">
<section class="kgs-nutrients">
	<div class="container">
		<div class="row">
			<div class="kgs-nutrients__content drawOnView">
				<div class="nutrients">';

    if( count($nutrients_bubbles_vars) > 0 ){
        for($x = 0; $x < count($nutrients_bubbles_vars); $x++){

            $output .= '<div class="nutrients__bubble bubble--'. $nutrients_bubbles_vars[$x]["bubble_size_repeater"] .' activeToggle">
						<div class="wrap">
							<h2>'.$nutrients_bubbles_vars[$x]["nutrients_name"].'</h2>
						</div>
						<div class="wrap">
							<p>'.$nutrients_bubbles_vars[$x]["nutrients_content"].'</p>
						</div>
						<span></span>
					</div>';

        }}

    $output .= '</div>

				<div class="kgs-nutrients__package"';
    $output .= $custombg;
    $output .=
        '></div>
				<div class="kgs-nutrients__straw"></div>

			</div>
		</div>
	</div>
</section>
</div>';

    return $output;

}
add_shortcode( 'kgs_interactive_section_skills_content', 'kgs_interactive_section_content_shortcode' );


// Nested Element
function kgs_interactive_section_content_shortcode_vc() {
    vc_map(
        array(
            'name'            => __('KGS Bubbles', 'custom_elements'),
            'base'            => 'kgs_interactive_section_skills_content',
            'description'     => __( 'KGS page – vitamin animation', 'custom_elements' ),
            'category'        => 'Nuzest Custom',
            'icon' => 'kgs-bubbles-vc-icon',
            'content_element' => true,
            'params'          => array(
                array(
                    "type" => "attach_image",
                    "heading" => __("Background Image", 'custom_elements'),
                    "param_name" => "image",
                    'holder' => 'div'
                ),
                array(
                    "type" => "param_group",
                    "heading" => __( "Nutrients Bubbles", "my-text-domain" ),
//                    "holder" => "div",
                    "param_name" => "nutrients_bubbles", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Nutrients Name',
                            'param_name' => 'nutrients_name',
                            'admin_label' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Nutrients Content',
                            'param_name' => 'nutrients_content',
                        ),
                        array(
                            'type'        => 'dropdown',
                            'heading'     => 'Bubble Size',
                            'param_name'  => 'bubble_size_repeater',
                            'value'       => array(
                                'Small'   => 'sm',
                                'Medium'   => 'md',
                                'Large' => 'lg',
                            ),
                        )
                    )
                ),
            ),
        )
    );
}
add_action( 'vc_before_init', 'kgs_interactive_section_content_shortcode_vc' );
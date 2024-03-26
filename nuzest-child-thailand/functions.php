<?php
function my_theme_enqueue_styles() {

    $parent_style = 'main_css';

   /* wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );*/
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
	if(ICL_LANGUAGE_CODE == 'th'){ //thai
          wp_enqueue_style( 'style-th', get_stylesheet_directory_uri() . "/css/style-th.css", array('main_css', 'child-style'), null );
		  wp_enqueue_script('scripts-th', get_stylesheet_directory_uri().'/js/scripts-th.js', array('jquery', 'bootstrap_js', 'theme_js'), '', true);
    };
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );


function wcpvd_get_variation_description( $variation_id ) {
	return get_post_meta( $variation_id, 'variable_description', TRUE );
}

?>

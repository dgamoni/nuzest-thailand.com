<?php

function my_theme_enqueue_styles() {

    $parent_style = 'main_css'; 

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
	//wp_enqueue_script('child-scripts', get_stylesheet_directory_uri().'/js/scripts.js', array('jquery', 'bootstrap_js', 'theme_js'), '', true);
	
		if(ICL_LANGUAGE_CODE == 'th'){ // thai lanugage pages (assuming English is still the Primary language)
			wp_enqueue_script( 'kanit-font', 'https://fonts.googleapis.com/css?family=Kanit:100,200,400,400i,500&subset=thai', array($parent_style) );
			wp_enqueue_style( 'style-th', get_stylesheet_directory_uri() . "/style-th.css", array('main_css', 'child-style'), null );
			//wp_enqueue_script('scripts-th', get_stylesheet_directory_uri().'/js/scripts-th.js', array('jquery', 'bootstrap_js', 'theme_js'), '', true);
    };
	
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

/** Disable Ajax Call from WooCommerce */
add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_cart_fragments', 11); 
function dequeue_woocommerce_cart_fragments() { 
if (is_front_page()) wp_dequeue_script('wc-cart-fragments'); }

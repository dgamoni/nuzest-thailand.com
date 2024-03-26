<?php

function theme_styles()
{
	wp_enqueue_style('webfonts_css', '//cloud.webtype.com/css/8b80ec6f-e85e-4254-bfca-b071627bf8ab.css');
	wp_enqueue_style('font_awesome', get_template_directory_uri(). '/css/font-awesome.min.css');
	wp_enqueue_style('slider_css', get_template_directory_uri(). '/css/royalslider.css');
	wp_enqueue_style('jquery_ui', get_template_directory_uri(). '/css/jquery-ui.min.css');
	wp_enqueue_style('main_css', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('jansy_css', get_template_directory_uri(). '/css/jasny-bootstrap.css');
	wp_enqueue_style('bstheme_css', get_template_directory_uri(). '/css/bootstrap-xl.css');
}
add_action('wp_enqueue_scripts', 'theme_styles');

// HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
function theme_scripts()
{
	global $wp_scripts;

	wp_register_script('html5_shiv', 'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js', '', '', false);
	wp_register_script('respond_js', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', '', '', false);

	$wp_scripts->add_data('html5_shiv', 'conditional', 'lt IE 9');
	$wp_scripts->add_data('respond_js', 'conditional', 'lt IE 9');

	if ( !is_admin() ) {
		wp_enqueue_script('underscore', null, null, null, true);
		wp_enqueue_script('underscore-mixins', get_template_directory_uri().'/js/common/_.mixins.js', array('underscore'), '', true);
		wp_enqueue_script('bootstrap_js', get_template_directory_uri().'/js/bootstrap.js', array('jquery'), '', true);
		wp_enqueue_script('bootstrap_typeahead_js', get_template_directory_uri().'/js/bootstrap.typeahead.min.js', array('jquery'), '', true);
		wp_enqueue_script('jasny_js', get_template_directory_uri().'/js/jasny-bootstrap.js', array('jquery', 'bootstrap_js'), '', true);
		wp_enqueue_script('scroll_js', get_template_directory_uri().'/js/jquery.simplyscroll.js', array('jquery'), '', true);
		wp_enqueue_script('easing_js', get_template_directory_uri().'/js/jquery.easing-1.3.js', array('jquery'), '', true);
		wp_enqueue_script('jquery_ui', get_template_directory_uri().'/js/jquery-ui.min.js', array('jquery'), '', true);
		wp_enqueue_script('slick_js', get_template_directory_uri().'/js/slick.min.js', array('jquery'), '', true);
		wp_enqueue_script('slider_js', get_template_directory_uri().'/js/jquery.royalslider.min.js', array('jquery'), '', true);
		wp_enqueue_script('theme_js', get_template_directory_uri().'/js/theme.js', array('jquery', 'bootstrap_js'), '', true);
		wp_dequeue_script( 'swatches-and-photos' );
		wp_enqueue_script( 'swatches-and-photos-custom', get_template_directory_uri().'/js/swatches-and-photos-custom.js', array('jquery'), '1.5.0', true );
	}
}
add_action('wp_enqueue_scripts', 'theme_scripts');

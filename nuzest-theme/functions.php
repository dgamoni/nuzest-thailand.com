<?php
/**
 * Nuzest Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Nuzest_Theme
 */


/*
 * Kernl.us theme updater
 */
require 'theme_update_check.php';
$MyUpdateChecker = new ThemeUpdateChecker(
    'nuzest-theme',
    'https://kernl.us/api/v1/theme-updates/5965d46950c8100368c45726/'
);


if ( ! function_exists( 'nuzest_theme_setup' ) ) :
	/* Sets up theme defaults and registers support for various WordPress features. */
	function nuzest_theme_setup() {

		load_theme_textdomain( 'nuzest-theme', get_template_directory() . '/languages' );
		load_theme_textdomain( 'nuzest-theme-admin', get_template_directory() . '/languages');
		
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );

		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		
		register_nav_menus( array(
			'main-menu' => esc_html__('Main Menu', 'nuzest-theme'),
			'header-menu' => esc_html__('Header Menu', 'nuzest-theme'),
			'footer-menu' => esc_html__('Footer Menu', 'nuzest-theme'),
			'social-menu' => esc_html__('Social Menu', 'nuzest-theme')
     	));

	}
endif;
add_action( 'after_setup_theme', 'nuzest_theme_setup' );

/* Adds a `js` class to the root `<html>` element when JavaScript is detected. */
function nuzesttheme_javascript_detection() {
    echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action('wp_head', 'nuzesttheme_javascript_detection', 0);


/* Register scripts and stylesheets */
require(get_template_directory() . '/inc/actions/wp_enqueue_scripts.php');


/* Register AJAX support (Ajax URL should include WPML language) */
function register_ajax() {

	$ajaxurl = defined('ICL_LANGUAGE_CODE')
		? add_query_arg( [ 'lang' => ICL_LANGUAGE_CODE ], admin_url('admin-ajax.php') )
		: admin_url('admin-ajax.php')
	;

	wp_localize_script('theme_js', 'theme_js_vars', array('ajaxurl' => $ajaxurl));
}
add_action('wp_enqueue_scripts', 'register_ajax');


/* Add Nuzest navigation menu items */
require get_template_directory() . '/inc/filters/bootstrap-wp-navwalker.php';
require get_template_directory() . '/inc/filters/wp_nav_menu_items.php';

/* Widgets */
require(get_template_directory() . '/inc/widgets/setup-widgets.php');
require(get_template_directory() . '/inc/widgets/social-widget-v1.php');
require(get_template_directory() . '/inc/widgets/social-widget-v2.php');

/* Register Custom Post Types */
require(get_template_directory() . '/inc/register_post_types.php');

/* Custom template tags for this theme. */
require get_template_directory() . '/inc/functions/template-tags.php';

/* Functions which enhance the theme by hooking into WordPress. */
require get_template_directory() . '/inc/functions/template-functions.php';

/* Customizer additions. */
require get_template_directory() . '/inc/customizer.php';

/* Load Jetpack compatibility file. */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/plugin-compat/jetpack.php';
}

/* Load WooCommerce compatibility file if WooCommerce is installed and active */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/plugin-compat/woocommerce.php';
}

/* Register product_cat regardless of WooCommerce plugin status */
if ( ! taxonomy_exists('product_cat') ){
	require(get_template_directory() . '/inc/actions/register_product_cat.php');
}

/* Register Visual Composer Custom Elements */
if ( is_plugin_active( 'js_composer/js_composer.php' ) ) {
	require(get_template_directory() . '/inc/register_custom_vc_elements.php');
}

/* Load RoyalSlider customisation file */
if ( is_plugin_active( 'new-royalslider/newroyalslider.php' ) ) {
	require get_template_directory() . '/inc/plugin-compat/royalslider.php';
}

/* Author and Profile functions */
require get_template_directory() . '/inc/functions/ajax_get_profile.php';
require get_template_directory() . '/inc/functions/user_avatars.php';
require get_template_directory() . '/inc/functions/nz_numeric_pagination.php';


/* Custom Body Class */
function custom_class( $classes ) {
    if ( get_field('custom_body_class') ) {
        $classes[] = get_field('custom_body_class');
    }
    return $classes;
}
add_filter( 'body_class', 'custom_class' );


/* Change Author Permalinks to Profiles */
function change_author_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'profiles';
    $wp_rewrite->author_structure = '/' . $wp_rewrite->author_base. '/%author%';
}
add_action('init','change_author_permalinks');


/* Add editor formats */
require get_template_directory() . '/inc/functions/editor_formats.php';


/* Filter to replace default css class names for vc_row shortcode and vc_column */
require get_template_directory() . '/inc/filters/bootstrap_js_composer.php';


/* Social Sharing Buttons */
require get_template_directory() . '/inc/functions/social_share_btns.php';


/* Require included Visual Composer with TGMPA */
require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', function() {

    $plugins = [ [
        'name'     => 'WPBakery Visual Composer',
        'slug'     => 'js_composer',
        'source'   => get_template_directory() . '/lib/js_composer.zip',
        'required' => true,
        'version'  => '5.6',
    ] ];
   
	$config = [ 'domain' => 'nuzest-theme' ];

    tgmpa( $plugins, $config );
} );
add_action( 'vc_before_init', 'vc_set_as_theme' );  

?>


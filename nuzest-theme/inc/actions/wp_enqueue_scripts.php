<?php

function theme_styles() {
	
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css');
	wp_enqueue_style('jasny-bootstrap', '//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css');
	wp_enqueue_style('font_awesome', get_template_directory_uri() . '/css/font-awesome.min.css'); //included with WooCommerce?
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700', array(), null);
	wp_enqueue_style('select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css');
	wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/css/owl-carousel/owl.carousel.css', array(), null);
	wp_enqueue_style('main_css', get_template_directory_uri() . '/style.css', array('google-fonts'), null);

	wp_enqueue_style('main_css_all', get_template_directory_uri() . '/css/styles/all.min.css', array(), null);

	/* Development mode 
	wp_enqueue_style('main_css_body', get_template_directory_uri() . '/css/styles/style-01-body.css', array(), null);
	wp_enqueue_style('main_css_nav', get_template_directory_uri() . '/css/styles/style-02-navigation.css', array(), null);
	wp_enqueue_style('main_css_mega', get_template_directory_uri() . '/css/styles/style-03-mega-menu.css', array(), null);
	wp_enqueue_style('main_css_footer', get_template_directory_uri() . '/css/styles/style-04-footer.css', array(), null);
	wp_enqueue_style('main_css_forms', get_template_directory_uri() . '/css/styles/style-05-forms.css', array(), null);
	wp_enqueue_style('main_css_common', get_template_directory_uri() . '/css/styles/style-06-common.css', array(), null);
	wp_enqueue_style('main_css_pagination', get_template_directory_uri() . '/css/styles/style-07-pagination.css', array(), null);
	wp_enqueue_style('main_css_slider', get_template_directory_uri() . '/css/styles/style-08-slider.css', array(), null);
	wp_enqueue_style('main_css_vc_snippets', get_template_directory_uri() . '/css/styles/style-09-vc-snippets.css', array(), null);
	wp_enqueue_style('main_css_vc_product_blocks', get_template_directory_uri() . '/css/styles/style-10-vc-product-blocks.css', array(), null);
	wp_enqueue_style('main_css_vc', get_template_directory_uri() . '/css/styles/style-11-vc-elements.css', array(), null);
	wp_enqueue_style('main_css_product', get_template_directory_uri() . '/css/styles/style-12-product.css', array(), null);
	wp_enqueue_style('main_css_vc_ggs', get_template_directory_uri() . '/css/styles/style-13-vc-ggs.css', array(), null);
	wp_enqueue_style('main_css_vc_kgs', get_template_directory_uri() . '/css/styles/style-14-vc-kgs.css', array(), null);
	wp_enqueue_style('main_css_vc_jfv', get_template_directory_uri() . '/css/styles/style-15-vc-jfv.css', array(), null);
	wp_enqueue_style('main_css_ingredients', get_template_directory_uri() . '/css/styles/style-16-ingredients.css', array(), null);
	wp_enqueue_style('main_css_blog', get_template_directory_uri() . '/css/styles/style-17-blog.css', array(), null);
	wp_enqueue_style('main_css_recipes', get_template_directory_uri() . '/css/styles/style-18-recipes.css', array(), null);
	wp_enqueue_style('main_css_faqs', get_template_directory_uri() . '/css/styles/style-19-faqs.css', array(), null);
	wp_enqueue_style('main_css_about', get_template_directory_uri() . '/css/styles/style-20-about.css', array(), null);
	wp_enqueue_style('main_css_testimonials', get_template_directory_uri() . '/css/styles/style-21-testimonials.css', array(), null);
	wp_enqueue_style('main_css_store', get_template_directory_uri() . '/css/styles/style-22-store-locator.css', array(), null);
	wp_enqueue_style('main_css_region', get_template_directory_uri() . '/css/styles/style-23-region-select.css', array(), null);
	 end dev mode */
	
	
	
	
		
	// Load the Internet Explorer specific stylesheet.
    wp_enqueue_style('nuzesttheme-ie', get_template_directory_uri() . '/css/ie.css', array('main_css'), '20150930');
    wp_style_add_data('nuzesttheme-ie', 'conditional', 'lt IE 10');

    // Load the Internet Explorer 8 specific stylesheet.
    wp_enqueue_style('nuzesttheme-ie8', get_template_directory_uri() . '/css/ie8.css', array('main_css'), '20151230');
    wp_style_add_data('nuzesttheme-ie8', 'conditional', 'lt IE 9');

    // Load the Internet Explorer 7 specific stylesheet.
    wp_enqueue_style('nuzesttheme-ie7', get_template_directory_uri() . '/css/ie7.css', array('main_css'), '20150930');
    wp_style_add_data('nuzesttheme-ie7', 'conditional', 'lt IE 8');

}

add_action('wp_enqueue_scripts', 'theme_styles');


/* Admin panel styles */
function admin_style() {
	wp_enqueue_style('admin_css', get_template_directory_uri() . '/css/admin/admin.css', array(), null);
}

add_action('admin_enqueue_scripts', 'admin_style');


/* Style the visual editor to resemble the theme style */
add_editor_style(array('css/editor-style.css', 'google-fonts'));



/*/// 
 * Register Scripts
 */
function theme_scripts() {
    global $wp_scripts;
	
	if (!is_admin()) {
		
	/* Replace core Jquery version for compatibility with Owl Carousel */
	wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/js/jquery-2.2.4.min.js', array(), '2.2.4' );
	
	/* HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries */
    wp_register_script('html5_shiv', 'https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js', '', '', false);
    wp_register_script('respond_js', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', '', '', false);


    $wp_scripts->add_data('html5_shiv', 'conditional', 'lt IE 9');
    $wp_scripts->add_data('respond_js', 'conditional', 'lt IE 9');
		
	if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
	
	wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', true);
	wp_enqueue_script('jasny-bootstrap', '//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js', 'bootstrap_js', '', true);
	wp_enqueue_script('scroll_magic', get_template_directory_uri() . '/js/ScrollMagic.js', array('jquery'), '', false);
	wp_enqueue_script('select2_js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js','', '', true);
	wp_enqueue_script('theme_js', get_template_directory_uri() . '/js/theme.js', array('jquery', 'bootstrap_js'), '', true);
	
	}

	
}

add_action('wp_enqueue_scripts', 'theme_scripts');




// ADMIN SCRIPTS //

function admin_scripts_nav( $hook ) {
	
	if( $hook != 'nav-menus.php' ) 
		return;
    wp_enqueue_script( 'admin-scripts_nav', get_template_directory_uri() . '/js/admin-nav.js', array( 'jquery' ), '1.0.0', true );
}

add_action( 'admin_enqueue_scripts', 'admin_scripts_nav' );



	
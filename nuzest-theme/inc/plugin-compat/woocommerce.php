<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package nuzest-theme
 */


/**
 * Add WooCommerce product_cat taxonomy to CPTs if WooCommerce is enabled
 */

if ( ! function_exists( 'add_product_cat_to_custom_post_type' ) ) {
		
	function add_product_cat_to_custom_post_type() {
		register_taxonomy_for_object_type( 'product_cat', 'recipes' );
		register_taxonomy_for_object_type( 'product_cat', 'post' );
		register_taxonomy_for_object_type( 'product_cat', 'ingredient_template' );
		register_taxonomy_for_object_type( 'product_cat', 'faqs' );
	}
	
	add_action( 'init', 'add_product_cat_to_custom_post_type' );
}

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function nuzest_theme_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'nuzest_theme_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function nuzest_theme_woocommerce_scripts() {
	wp_enqueue_style( 'nuzest-theme-woocommerce-style', get_template_directory_uri() . '/css/woocommerce.css' );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'nuzest-theme-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'nuzest_theme_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' and conditional 'woo-single-custom' classes to the body tag.
 */
function nuzest_theme_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';
	if( get_field( 'display_type' ) == 'custom' ) {
		$classes[] = 'woo-single-custom';
	}
	if(get_theme_mod("wc_ds_position") == "notice_top"){
		$classes[] = 'woo-demo-store-top' ;
	}
	return $classes;
}
add_filter( 'body_class', 'nuzest_theme_woocommerce_active_body_class' );

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);



/**
 * Product gallery thumnbail columns.
 *
 * @return integer number of columns.
 */
function nuzest_theme_woocommerce_thumbnail_columns() {
	$placement = get_theme_mod( 'wc_product_gallery', 'default' );
	if ($placement == 'horizontal') { return 4; }
	if ($placement == 'vertical') { return 1; }
	if (empty($placement)) { return 4; }
}
add_filter( 'woocommerce_product_thumbnails_columns', 'nuzest_theme_woocommerce_thumbnail_columns' );


/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function nuzest_theme_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 4,
		'columns'        => 4,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'nuzest_theme_woocommerce_related_products_args' );


/**
 * Remove related products when up-sell products are defined
 */
/*remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_after_single_product_summary', 'related_upsell_products', 15 );

function related_upsell_products() {
	global $product;

	if ( isset( $product ) && is_product() ) {
		$upsells = $product->get_upsells();

		if ( sizeof( $upsells ) > 0 ) {
			woocommerce_upsell_display();	
		} else {
			woocommerce_upsell_display();
			woocommerce_output_related_products();
		}
	}
}*/


/**
 * General Setup for Standard Single Product Pages 
 */

/**
 * Replace default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'nuzest_theme_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 */
	function nuzest_theme_woocommerce_wrapper_before() {
		global $post; 
		global $product;
		if (empty($product->get_id)){
			unset($product);
			$product = wc_get_product($post->ID);
		}
		$template = get_field( 'display_type', $post->ID ); // ACF + VC standard product page method
		?>
		<div id="primary" class="content-area 
			<?php if( !is_product() || $template == 'standard' || $template == null ) { echo ' container'; } ?>
		">
		<script type="application/ld+json">
			{
			  "@context": "http://schema.org/",
			  "@type": "Product",
			  "name": "<?php echo the_title(); ?>",
			  "image": "<?php echo get_the_post_thumbnail_url( $product->get_id, 'medium' ); ?>",
			  "description": "<?php echo strip_tags( get_the_excerpt() ); ?>",
			  "brand": {
				"@type": "Thing",
				"name": "Nuzest"
			  },
			  "aggregateRating": {
				"@type": "AggregateRating",
				"ratingValue": "<?php echo $product->get_average_rating(); ?>",
				"reviewCount": "<?php echo $product->get_review_count(); ?>",
				"bestRating": "5",
				"worstRating": "1"
			  },
			  "offers": {
				"@type": "Offer",
				"priceCurrency": "AUD <?php //echo get_woocommerce_currency(); ?>",
				"price": "<?php echo $product->get_price(); ?>",
				"priceValidUntil": "2020-11-05",
				"itemCondition": "http://schema.org/NewCondition",
				"availability": "http://schema.org/InStock",
				"seller": {
				  "@type": "Organization",
				  "name": "Nuzest"
				}
			  }
			}
			</script>
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'nuzest_theme_woocommerce_wrapper_before' );

if ( ! function_exists( 'nuzest_theme_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 */
	function nuzest_theme_woocommerce_wrapper_after() {
			?>
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'nuzest_theme_woocommerce_wrapper_after' );


// Add a nutrition button to single product pages //
function nz_wc_nutrition_button() {
	global $post;
	if ( get_post_meta($post->ID, 'show_ingredients', true) == true && get_field( 'display_type' ) != 'custom') {
			echo '<a class="btn toggle-in margin-top-md margin-bottom-md">';
       			_e('Ingredients/Nutrition','show_ingredients');
            echo '</a>';
			$cat = get_the_terms ( $post->ID, 'product_cat' );
      }
}
add_action('woocommerce_single_product_summary', 'nz_wc_nutrition_button', 20);



/** 
 * Setup for VC Composer Custom Single Product Pages 
 */

// Wrap Image Gallery and Product Summery in Bootstrap container //
function bbloomer_custom_action() {
	if( get_field( 'display_type' ) == 'custom' ) {
	 echo '<div class="container woo_product_info_wrap">';
	}
}
add_action( 'woocommerce_before_single_product_summary', 'bbloomer_custom_action', 15 );


function bbloomer_custom_action2() {
	if( get_field( 'display_type' ) == 'custom' ) {
	 echo '</div>';
	}
}
add_action( 'woocommerce_after_single_product_summary', 'bbloomer_custom_action2', 15 );


// Remove standard Product Tabs on custom layouts //
function remove_product_tabs() {
	if ( get_field( 'display_type' ) == 'custom' ) {
		remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	}
}
add_action( 'wp', 'remove_product_tabs' );


// Show content/description and reviews separately instead //
function show_product_description() {
	if ( get_field( 'display_type' ) == 'custom' ) {
		echo ('<div class="woo_vc_custom">');
		the_content();
		echo ('</div>');
		echo ('<div class="woo_vc_reviews container">');
		comments_template();
		echo ('</div>');
	}
}
add_action( 'woocommerce_after_single_product_summary', 'show_product_description', 15 );


// Wrap Related Products section in Bootstrap container //
function wc_before_related() {
		if( get_field( 'display_type' ) == 'custom' ) { 
				echo ('<div class="container">');
		}
}
add_action( 'woocommerce_after_single_product_summary', 'wc_before_related', 19 );


function wc_after_related() {
	if( get_field( 'display_type' ) == 'custom' ) { 
		echo ('</div>');
	}
}
add_action( 'woocommerce_after_single_product_summary', 'wc_after_related', 21 );







// Archive title empty (use content in intro) //
function nz_wc_shop_page_title($page_title)
{
    if (is_shop()) {
        return false;
    } else {
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        echo $cat_obj->name;
    }
}
add_filter('woocommerce_page_title', 'nz_wc_shop_page_title');

// Add category list before shop loop //
/* create category list buttons */
function nz_wc_category_list() {

	/* get current category */
	global $wp_query;
	$category_ID = null;
	if ( get_queried_object_id() ) {
		$category_ID = get_queried_object_id();
	}

	/* get category list */
	$args = array(
		'taxonomy' => 'product_cat',
		'orderby' => 'name',
		'show_count' => 0,
		'pad_counts' => 0,
		'hierarchical' => 0,
		'title_li' => '',
		'hide_empty' => 1,
		'meta_query' => array(
			array(
				'key' => 'show_on_shop_page',
				'value' => 'show',
				'compare' => '='
			)
		)
	);
	$all_categories = get_categories( $args );
	echo '<div class="category-list text-center">';
	nz_shop_header_button( get_site_url( 'shop' ) . '/shop', __( 'All', 'nuzest-theme' ), is_shop() );
	foreach ( $all_categories as $cat ) {
		if ( $cat->category_parent == 0 ) {
			nz_shop_header_button(
				get_term_link( $cat->slug, 'product_cat' ),
				$cat->name,
				$category_ID == $cat->term_id
			);
		}
	}
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'nz_wc_category_list' );

function nz_shop_header_button($link, $title, $is_active){
    printf('<a class="btn btn-plain %s" href="%s">%s</a>',
        ($is_active) ? 'active' : '',
        $link,
        $title
    );
}

// Do not display the product category 'hidden' in the shop page
function custom_pre_get_posts_query( $q ) {

	if ( ! $q->is_main_query() ) return;
	if ( ! $q->is_post_type_archive() ) return;
	
	if ( ! is_admin() && is_shop() ) {
		$q->set( 'tax_query', array(array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => array( 'hidden' ), // Don't display products in the hidden category on the shop page
			'operator' => 'NOT IN'
		)));
	
	}
	remove_action( 'woocommerce_product_query', 'custom_pre_get_posts_query' );
}
add_action( 'woocommerce_product_query', 'custom_pre_get_posts_query' );


/* 
 * Setup for Cart and Checkout
 */

// Hide coupon entry from checkout form
function hide_coupon_field_on_checkout( $enabled ) {
	if ( is_checkout() ) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );


// Close 'Ship to a different address' by default
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );


/* 
 * Show login on Cart
 * Author: orionk
 * Author URI: https://codeable.io/developers/orionk-k/
 */
//if ( get_theme_mod( 'wc_cart_add_login_form' ) == true ){
function woocommerce_login_form_in_cart( $args = array() ) {

	//dont show anything if user is logged in
	if ( is_user_logged_in() ) {
		return;
	}
	?>

	<script>
		jQuery(document).ready(function(){
			jQuery( document.body ).on( 'click', 'a.showlogin', function() {
				jQuery( 'form.login' ).slideToggle();
				return false;
			})
		});
	</script>

	<?php

		$info_message  = apply_filters( 'woocommerce_checkout_login_message', __( 'Returning customer?', 'woocommerce' ) );

		$info_message .= ' <a href="#" class="showlogin">Click here to login</a>';

		wc_print_notice( $info_message, 'notice' );

		woocommerce_login_form(

			array(

				'message'  => 'If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to checkout.',

				'redirect' => wc_get_page_permalink( 'cart' ),

				'hidden'   => true

			)

		);

	}
add_action( 'woocommerce_before_cart', 'woocommerce_login_form_in_cart2' );
//}

function woocommerce_payment_heading (){
	echo ('<h3>Payment Details</h3>'); 
}

add_action( 'woocommerce_review_order_before_payment', 'woocommerce_payment_heading' );

/* Exclude non-product post types from product category archive
|  @Since: 2.1.2
|  @Added: 8/21/2017
|  @Author: john@jsweb.solutions
|  @Tag: query filter
|  @Variables: wp_query
*/
function cp_product_archive_count_fix($query) {
	if($query->is_main_query() && $query->is_tax('product_cat')  && !is_admin() ):

	   if ( $query->is_main_query() ) {				
        $query->set( 'post_type', 'product' );
    }
	endif;
}
add_action('pre_get_posts', 'cp_product_archive_count_fix');

// Show product short description on Shop Catalogue page

function trimmed_single_excerpt() {
	echo wp_trim_words(get_the_excerpt(), 24)."<br><br>";
}
add_action( 'woocommerce_after_shop_loop_item_title', 'trimmed_single_excerpt', 20 );


// Add Clear Cart button to Cart page

function woocommerce_clear_cart_url() {
    global $woocommerce;
    if( isset($_REQUEST['clear-cart']) ) {
        $woocommerce->cart->empty_cart();
    }
}
add_action('init', 'woocommerce_clear_cart_url');


// Woo Single Product Image Slider
function ud_update_woo_flexslider_options( $options ) {
    $options['directionNav'] = true;
	$options['animation'] = "slide";

    return $options;
}
add_filter( 'woocommerce_single_product_carousel_options', 'ud_update_woo_flexslider_options' );


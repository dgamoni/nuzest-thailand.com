<?php
/**
 * Nuzest Theme Theme Customizer
 *
 * @package Nuzest_Theme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function nuzest_theme_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	
	/* Nuzest Add Section and Options for Blog post display */
	$wp_customize->add_section( 
		'nuzest_blog_options', 
			array(
				'title'       => __( 'Blog Settings', 'nuzest-theme' ),
				'priority'    => 100,
				'capability'  => 'edit_theme_options',
				'description' => __('Select your blog post layout.', 'nuzest-theme'), 
			) 
	);
	
	$wp_customize->add_setting( 
		'blog_template',
			array(
			'default' => 'post'
			)
	);  
	
	$wp_customize->add_control( 
		'blog_template_control', 
		array(
			'label' => __( 'Blog Template', 'nuzest-theme' ),
			'section' => 'nuzest_blog_options',
			'settings' => 'blog_template',
			'type' => 'radio',
			'choices' => array(
				'post' => 'Author Sidebar',
				'post-sb-dynamic' => 'Dynamic Sidebar',
			),
	));
	
	
	
	/* Nuzest Add Section and Options for Single Product Image Gallery */
	$wp_customize->add_section( 
	'nuzest_wc_product_layout', 
		array(
			'title'       => __( 'Product Page Layout', 'nuzest-theme' ),
			'priority'    => 100,
			'capability'  => 'edit_theme_options',
			'description' => __('How to display your product gallery images', 'nuzest-theme'),
			'panel'    => 'woocommerce',
		) 
	);
	
	$wp_customize->add_setting( 
	'wc_product_gallery',
		array(
			'default' => 'horizontal'
		)
	);  
	
	$wp_customize->add_control( 
	'wc_template_control', array(
		'label' => __( 'Product Template', 'nuzest-theme' ),
		'section' => 'nuzest_wc_product_layout',
		'settings' => 'wc_product_gallery',
		'type' => 'radio',
		'choices' => array(
			'horizontal' => 'Underneath featured image',
			'vertical' => 'To the left of the featured image',
			),
	));
	
	
	
	/* Add additional styling paramaters to the WooCommerce Demo Store options */
	$wp_customize->add_setting( 
		'wc_ds_bg_color',
		array(
			'default' => '#333'
		)
	); 
	$wp_customize->add_setting( 
		'wc_ds_position',
		array(
			'default' => 'notice_top'
		)
	); 
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'wc_ds_bg_color_control',
			array(
				'label'       => __( 'Background Color', 'woocommerce' ),
				'section'     => 'woocommerce_store_notice',
				'settings'    => 'wc_ds_bg_color',
			)
		)
	);
	
	$wp_customize->add_control(
			'wc_ds_notice_position',
			array(
				'label'       => __( 'Notice Position', 'woocommerce' ),
				'description' => __( 'Should the store notice banner scroll with the page or stay fixed to the top of the screen?', 'woocommerce' ),
				'section'     => 'woocommerce_store_notice',
				'settings'    => 'wc_ds_position',
				'type' 				=> 'radio',
				'choices' 		=> array(
					'notice_top' => 'Fixed to Top',
					'notice_bottom' => 'Fixed to Bottom',
				),
			)
		);
	
	
	
	/* Add additional WooCommerce options */
	$wp_customize->add_setting(
			'wc_checkout_hide_coupon_field',
			array(
				'default'              => 'yes',
				'type'                 => 'option',
				'capability'           => 'manage_woocommerce',
				'sanitize_callback'    => 'wc_bool_to_string',
				'sanitize_js_callback' => 'wc_string_to_bool',
			)
		);
	
	// Register controls.
		$wp_customize->add_control(
			'wc_checkout_hide_coupon_field',
			array(
				'label'    => __( 'Hide the Coupon Code field from Checkout', 'woocommerce' ),
				'section'  => 'woocommerce_checkout',
				'settings' => 'wc_checkout_hide_coupon_field',
				'type'     => 'checkbox',
			)
		);
	
	
		$wp_customize->add_section(
			'woocommerce_cart_page',
			array(
				'title'       => __( 'Cart', 'woocommerce' ),
				'description' => 'These options let you change the appearance of the WooCommerce shopping cart.',
				'priority'    => 20,
				'panel'       => 'woocommerce',
			)
		);
	
		$wp_customize->add_setting(
			'wc_cart_hide_coupon_field',
			array(
				'default'              => 'Show',
				/*'type'                 => 'option',
				'capability'           => 'manage_woocommerce',
				'sanitize_callback'    => 'wc_bool_to_string',
				'sanitize_js_callback' => 'wc_string_to_bool',*/
			)
		);
	
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'wc_cart_hide_coupon_field_control',
			array(
				'label'    => __( 'Hide the Coupon Code field from Cart', 'woocommerce' ),
				'section'  => 'woocommerce_cart_page',
				'settings' => 'wc_cart_hide_coupon_field',
				'type'     => 'select',
				'choices'   => array("Hide" => "Hide", "Show" => "Show")
			)
			)
		);
	
		$wp_customize->add_setting(
			'wc_cart_show_coupon_field_btn',
			array(
				'default'              => 'Add a Coupon',
			)
		);
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'wc_cart_hide_coupon_field_control_btn',
			array(
				'label'    => __( 'Button text', 'woocommerce' ),
				'section'  => 'woocommerce_cart_page',
				'settings' => 'wc_cart_show_coupon_field_btn',
			)
			)
		);
	
		$wp_customize->add_setting(
			'wc_cart_add_login_form',
			array(
				//'type'       => 'option',
				'default'              => true,
				'capability' => 'edit_theme_options',
				//'capability'           => 'manage_woocommerce',
				//'sanitize_callback'    => 'wc_bool_to_string', from woocommerce - class-wc-shop-customizer.php
				//'sanitize_js_callback' => 'wc_string_to_bool',
				'sanitize_callback' => 'nuzest_theme_sanitize_checkbox',
			)
		);
	
		$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'wc_cart_add_login_form',
			array(
				'label'    => __( 'Add a login form to the Cart page (useful if using Points & Rewards)', 'woocommerce' ),
				'section'  => 'woocommerce_cart_page',
				'settings' => 'wc_cart_add_login_form',
				'type'     => 'checkbox',
			)
			)
		);
	
		function nuzest_theme_sanitize_checkbox( $checked ) {
  	// Boolean check.
  	return ( ( isset( $checked ) && true == $checked ) ? true : false );
		}
	
	
	
	/* End Nuzest */
	
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => 'nuzest_theme_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => 'nuzest_theme_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'nuzest_theme_customize_register' );

function notice_background_colour(){
	?>
	<style>
		.woocommerce-store-notice{
			background-color: <?php echo get_theme_mod('wc_ds_bg_color'); ?>!important ;
		}
	</style>
	
	<?php
}
add_action('wp_head', 'notice_background_colour');

function notice_position_change(){
	if(get_theme_mod("wc_ds_position") == "notice_top"){
	?>
	<style>
		/*.woocommerce-store-notice{
			position: fixed !important;
		}
		#topNav{
			margin-top:49px
		}*/
	</style>
	<?php
	}
	if(get_theme_mod("wc_ds_position") == "notice_bottom"){
		
	?>
	<style>
		.woocommerce-store-notice{
				position: fixed !important;
				top: unset !important;
				bottom: 0;
		}
	</style>
	<?php
	}
}
add_action('wp_head', 'notice_position_change');

function coupon_show_hide(){
	if(get_theme_mod("wc_cart_hide_coupon_field") == "Hide"){
	?>

		<script>
			jQuery(document).ready(function(){
				jQuery(".coupon").css("display", "none");
				jQuery( "<input type='button' id='coupon_btn' class='button' value='<?php echo get_theme_mod(wc_cart_show_coupon_field_btn); ?>'></button>" ).insertAfter( ".coupon" );
				jQuery("#coupon_btn").click(function () {
					jQuery(".coupon").css("display", "block");
					jQuery("#coupon_btn").css("display", "none");
				});

			});
		</script>
<?php
	}
}
add_action('wp_head', 'coupon_show_hide');
/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function nuzest_theme_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function nuzest_theme_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function nuzest_theme_customize_preview_js() {
	wp_enqueue_script( 'nuzest-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'nuzest_theme_customize_preview_js' );

function page_customise_preview(){
	

	$query = new WC_Product_Query( array(
    'limit' => 10,
    'orderby' => 'date',
    'order' => 'DESC',
    'return' => 'ids',
	) );
	$varProducts = $query->get_products();
	asort($varProducts);
	$varProductId = reset($varProducts);
	print_r($varProductId);
	?>
		<script>
			jQuery(document).ready(function(){
				wp.customize.section( 'nuzest_wc_product_layout', function( section ) {
					section.expanded.bind( function( isExpanded ) {
						if ( isExpanded ) {
							wp.customize.previewer.previewUrl.set( 'https://' + window.location.hostname + '/?p=<?php echo $varProductId; ?>/' );
						}
					} );
				} );
				wp.customize.section( 'woocommerce_cart_page', function( section ) {
					section.expanded.bind( function( isExpanded ) {
						if ( isExpanded ) {
							wp.customize.previewer.previewUrl.set( 'https://' + window.location.hostname + '/cart/' );
						}
					} );
				} );
			});
		</script>
	<?php
}
add_action('customize_controls_print_scripts', 'page_customise_preview', 10 );

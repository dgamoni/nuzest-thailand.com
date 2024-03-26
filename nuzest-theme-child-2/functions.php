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

add_action('wp_footer', 'add_custom_css');
function add_custom_css() { ?>
    <script>
        jQuery(document).ready(function($) {

        });
    </script>
    <style>
        .recipe-video {
            display: flex;
        }
        .menu-item-language .dropdown-menu {
			margin:0;
		}
		#menu-header-menu .menu-item-language .dropdown-menu li a {
			display: block;
			padding: 3px 3px;
		}
    </style>
    <?php
}

// Add coupon name to order and email
add_action( 'woocommerce_email_after_order_table', 'add_payment_method_to_admin_new_order', 15, 2 );

/**
 * Add used coupons to the order confirmation email
 *
*/
function add_payment_method_to_admin_new_order( $order, $is_admin_email ) {
	
	if ( $is_admin_email ) {
	
		if( $order->get_used_coupons() ) {
		
			$coupons_count = count( $order->get_used_coupons() );
		
		    echo '<h4>' . __('Coupons used') . ' (' . $coupons_count . ')</h4>';
		     
		    echo '<p><strong>' . __('Coupons used') . ':</strong> ';
		    
		    $i = 1;
		    $coupons_list = '';
		    
		    foreach( $order->get_used_coupons() as $coupon) {
		        $coupons_list .=  $coupon;
		        if( $i < $coupons_count )
		        	$coupons_list .= ', ';
		        $i++;
		    }
		
		    echo '<p><strong>Coupons used (' . $coupons_count . ') :</strong> ' . $coupons_list . '</p>';
		
		} // endif get_used_coupons
	
	} // endif $is_admin_email
}



add_action( 'woocommerce_admin_order_data_after_billing_address', 'custom_checkout_field_display_admin_order_meta', 10, 1 );

/**
 * Add used coupons to the order edit page
 *
*/
function custom_checkout_field_display_admin_order_meta($order){

    if( $order->get_used_coupons() ) {
    
    	$coupons_count = count( $order->get_used_coupons() );
    
        echo '<h4>' . __('Coupons used') . ' (' . $coupons_count . ')</h4>';
         
        echo '<p><strong>' . __('Coupons used') . ':</strong> ';
        
        $i = 1;
        
        foreach( $order->get_used_coupons() as $coupon) {
	        echo $coupon;
	        if( $i < $coupons_count )
	        	echo ', ';
	        $i++;
        }
        
        echo '</p>';
    }

}


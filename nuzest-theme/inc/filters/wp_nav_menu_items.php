<?php

//Add various items to the menus
add_filter('wp_nav_menu_items', 'add_menu_items', 10, 2);
function add_menu_items($items, $args) {

    if( $args->theme_location == 'header-menu' ) {
        $items = add_header_menu_region_select($items);
        $items = add_header_menu_account_btn($items);
		$items = menu_cart_wrap($items);
    } else if( $args->theme_location == 'main-menu' ) {
        $items = add_main_menu_search_form($items);
        //$items = add_main_menu_shop_form($items);
    }
    return $items;
}
// Add search box to main menu
function add_main_menu_search_form($items)
{
    $items .=
    '<li class="menu-search-box">
        <form role="search" method="get" id="menuSearchForm" action="' . home_url('/') . '">
            <input type="text" placeholder="' . __('Search') .'..." name="s" id="s" />
            <a class="glyphicon glyphicon-search" id="menuSearchSubmit"></a>
            <a href="#" title="' . __('Search') .'" id="menuSearchButton"><span class="glyphicon glyphicon-search"></span></a>
        </form>
    </li>';

    return $items;
}

//Add region select to header menu
function add_header_menu_region_select($items)
{
	$items .= '<li class="menu-item"><a href="#" class="region-select">' . __('Select Region', 'nuzest-theme') . '</a></li>';
    return $items;
}

// Add log in / account button to header menu
function add_header_menu_account_btn($items)
{
    global $post, $sitepress;
	
    $current_main_id = (function_exists('icl_object_id')) ? icl_object_id( get_the_id(), 'post', true, $sitepress->get_default_language() ) : false;

    $original_post = get_post( $current_main_id );

    if ( is_user_logged_in() ) {
        $title = __('My Account','woothemes');
    } else {
        $title = __('Log In', 'nuzest-theme');
    }
    $items .= '<li class="menu-item '. (($original_post && $original_post->post_name == 'my-account')?'current-menu-item':'') .'"><a href="' . get_permalink( get_option('woocommerce_myaccount_page_id') ) .'" title="'. $title .'">'. $title .'</a></li>';

    return $items;
}

// add cart total to the utility nav

function menu_cart_wrap($items) {

	if (WC()->cart->cart_contents_count <= 1) {
		$itemText = 'item';
	} else {
		$itemText = 'items';
	}

	if (sizeof(WC()->cart->get_cart()) != 0) {

		$items .= '<li class="cart">';
		$items .= '<a href="' . WC()->cart->get_cart_url() . '"><i class="fa fa-shopping-cart"></i>';
		//$wrap .= WC()->cart->get_cart_total();
		$items .= WC()->cart->cart_contents_count . ' ' . $itemText;
		$items .= '</a>';
		$items .= '</li>';
	} 

  return $items;
}
//<ul id="%1$s" class="%2$s">%3$s<li class="cart"><a href=""><i class="fa fa-shopping-cart"></i></a></li></ul>



<?php

//remove result count
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20);

//remove result ordering
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

//remove prices
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);

//remove add to cart button
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' , 10 );

//archive title empty (use content in intro)
add_filter( 'woocommerce_page_title', 'nz_wc_shop_page_title');
function nz_wc_shop_page_title( $page_title ) {
	if (is_shop()) {
		return false;
	} else {
		global $wp_query;
		$cat_obj = $wp_query->get_queried_object();
		echo $cat_obj->name;
	}
}

//archive intro from content
remove_action( 'woocommerce_archive_description', 'woocommerce_product_archive_description', 10 );
add_action( 'woocommerce_archive_description', 'nz_wp_archive_description', 100);
function nz_wp_archive_description($page_intro) {
	if (is_shop()) {
		$shop_page_id = wc_get_page_id( 'shop' );
		$post = get_post($shop_page_id);
		$content = apply_filters('the_content', $post->post_content);
		echo '<div class="archive-description">'.$content.'</div>';
	}
}

//add category list before shop loop
add_action('woocommerce_before_shop_loop', 'nz_wc_category_list');

//create category list buttons
function nz_wc_category_list() {

	//get current category
	global $wp_query;
	$query_obj = $wp_query->get_queried_object();
	$category_ID = null;
	if($query_obj)    {
	    $category_ID  = $query_obj->term_id;
	}

	//get category list
	$args = array(
	  'taxonomy'     => 'product_cat',
	  'orderby'      => 'name',
	  'show_count'   => 0,
	  'pad_counts'   => 0,
	  'hierarchical' => 0,
	  'title_li'     => '',
	  'hide_empty'   => 1
	);
	$all_categories = get_categories( $args );
	echo '<div class="category-list text-center">';
	nz_shop_header_button(
		get_permalink( woocommerce_get_page_id( 'shop' ) ),
		__('All', 'nuzest-custom'),
		is_shop()
	);
	foreach ($all_categories as $cat) {
	    if($cat->category_parent == 0) {
	    	nz_shop_header_button(
	    		get_term_link($cat->slug, 'product_cat'),
	    		$cat->name,
	    		$category_ID==$cat->term_id
	    	);
		}
	}
	echo '</div>';
}

function nz_shop_header_button($link, $title, $is_active) {
	printf('<a class="btn btn-square btn-plain %s" href="%s">%s</a>',
		($is_active)?'active':'',
		$link,
		$title
	);
}

//add variation image sliders
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnails', 10);
function woocommerce_template_loop_product_thumbnails() {
	global $product;
    if ($product->product_type != "variable") {
    	//do default
    	woocommerce_template_loop_product_thumbnail();
    	return;
    } else {
      $variations = $product->get_available_variations();
      if (count($variations)<2) {
      	woocommerce_template_loop_product_thumbnail();
      	return;
      }
      echo '<div class="variation-images">';
      // echo '<div class="nav"><div class="prev"><</div><div class="next">></div></div>';
      foreach ($variations as $key => $variation) {
      	echo get_the_post_thumbnail( $variation['variation_id'], 'shop_catalog' );
      }
      echo '</div>';
    }
}

//add excerpt after item title in loop
add_action('woocommerce_after_shop_loop_item_title', 'nz_wc_product_loop_product_description', 10);
function nz_wc_product_loop_product_description() {
	if ( !is_cart() ) {
		woocommerce_template_single_excerpt();
	}
}

//add a more info button linking full product page
add_action( 'woocommerce_after_shop_loop_item_title', 'nz_wc_product_more_info_link' , 15 );
function nz_wc_product_more_info_link() {
	echo '<div><a class="btn btn-textual" href="'. get_the_permalink() .'">'. __('Buy Now') .'</a></div>';
}


<?php

//remove breadcrumbs
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

//remove sidebar
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

//before content wrapper
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action('woocommerce_before_main_content', 'nz_wc_before_main_content', 10);
function nz_wc_before_main_content() {
	include(TEMPLATEPATH . '/woocommerce/content_before.php');
}

//after content wrapper
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_after_main_content', 'nz_wc_after_main_content', 10);
function nz_wc_after_main_content() {
	include(TEMPLATEPATH . '/woocommerce/content_after.php');
}

//override default function to return product thumbnails as responsive images
function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $post;

	if ( has_post_thumbnail() ) {
		$post_thumbnail_id = get_post_thumbnail_id($post->ID);
		$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );
		$post_alt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);
		return '<img class="img-responsive" src="' . $post_thumbnail_url . '" alt="'.$post_alt.'">';
	} elseif ( wc_placeholder_img_src() ) {
		return wc_placeholder_img( $size );
	}
}

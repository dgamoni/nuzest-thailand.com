<?php

// Add custom body classes to pages (but not single posts)
function add_bodyclass($classes)
{
    global $post;
    if (is_page()) {
        $classes[] = $post->post_name;
    }
    return $classes;
}
add_action('body_class', 'add_bodyclass');


// Add products tax terms if selected to body for styling
function products_taxonomy_body( $classes ) {
	global $post;
	if (!is_single() && !is_archive()) {
		$products = get_the_terms( $post->ID, 'products' );
		if ($products) {
			foreach ($products as $key => $value) {
				$classes[] = 'term-' . $value->slug;
			}
		}
	}
	return $classes;
}
add_action( 'body_class', 'products_taxonomy_body' );

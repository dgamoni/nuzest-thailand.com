<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

?>
<div itemprop="description">
	<?php
		$excerpt = ($post->post_excerpt) ? $post->post_excerpt : '<!-- no excerpt -->';
		echo apply_filters( 'woocommerce_short_description', $excerpt );
	?>
</div>

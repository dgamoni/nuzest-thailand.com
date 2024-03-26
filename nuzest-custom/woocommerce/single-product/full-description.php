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
<div class="full-description" itemprop="description">
	<?php
		$content = ($post->post_content) ? $post->post_content : '<!-- no content -->';
		echo apply_filters( 'woocommerce_full_description', $content );
	?>
</div>

<?php
/**
 * Quick view template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post, $woocommerce;

$cats = get_the_terms($product->id, 'product_cat');


do_action( 'wc_quick_view_before_single_product' );
?>
<div class="woocommerce quick-view <?php foreach ( $cats as $cat ) { echo 'term-' . $cat->slug; } ?>">

	<div class="product">
		<div class="quick-view-image images">

			<?php woocommerce_template_loop_product_thumbnail(); ?>

			<a class="quick-view-detail-button button" href="<?php echo get_permalink( $product->id ); ?>"><?php _e( 'View Full Details', 'wc_quick_view' ); ?></a>

		</div>

		<div class="quick-view-content">
			<?php do_action( 'woocommerce_single_product_summary' ); ?>
		</div>
	</div>
</div>

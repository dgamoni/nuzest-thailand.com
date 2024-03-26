<?php
	$terms = wp_get_post_terms( $post->ID, 'products');
	$product = $terms[0];
	if ($product) :
	   // get WooCommerce catalogue image 
	   $category = get_term_by('slug', $product->slug, 'product_cat', 'ARRAY_A');
	   $thumbnail_id = get_woocommerce_term_meta( $category[ 'term_id' ], 'thumbnail_id', true );
	   $image = wp_get_attachment_url( $thumbnail_id );
?>


<!-- buy now button fixed on scroll -->
<section class="bnFixed">
    <div class="container">
        <div class="row row-centered">
        	<div class="col-md-8 col-centered">
            	<div class="hidden-xs hidden-sm col-md-2"> 
                	<img src="<?php echo $image; ?>" alt="<?php echo $product->name; ?>" class="img-responsive">
                </div>
                <div class="hidden-xs hidden-sm col-md-7 bnText">    
                	<h5><?php printf( _x('Buy %s online', 'Buy now footer text', 'nuzest-custom'), $product->name ) ?></h5>
                	<p><?php echo $category['description']; ?></p>
                </div>
                <div class="col-md-3">
                	<a class="btn" href="/product-category/<?php echo $product->slug?>"><?php _ex('Buy Now','Buy now footer button text', 'nuzest-custom') ?></a>
                </div>    
       		</div>
        </div>
    </div>
</section>
<?php endif; ?>

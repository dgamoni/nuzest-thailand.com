<?php

	/***
	*
	*	Shows recent posts (recipes and blog) related to a product (post taxonomy)
	*
	***/

	//either set a global $product object before including this block
	global $product;
	//or will be looked up based on current post products taxonomy
	if (!$product) {
		$terms = wp_get_post_terms( $post->ID, 'products');
		$product = $terms[0];
	}
	if ($product) :
?>
<section class="snippets">
	<!-- not sure why this was changed to fluid? <div class="container-fluid">-->
    <div class="container">
		<div class="row section-header">
			<div class="col-md-12">
				<h1><?php _e('Recent Posts', 'nuzest-custom') ?></h1>
				<?php printf(__('Recipes and articles about %s', 'nuzest-custom'), $product->name) ?>
			</div>
		</div>

		<div class="row">

			<?php
				$post_types = array( 'post', 'recipes' );
				global $postcountnum;
				$postcountnum = 1;
				foreach( $post_types as $post_type) {
					$args = array(
						'post_type' => $post_type,
						'posts_per_page' => '2',
						'tax_query' => array(
							array(
								'taxonomy' => 'products',
								'field'    => 'slug',
								'terms'    => $product->slug,
							),
						)
					);
					$snippet_query = new WP_Query( $args );
					while ($snippet_query->have_posts()) {
						$snippet_query->the_post();
						// generate related post snippets using php include to allow passing of the $postcountnum variable
						// include(locate_template( 'inc/content-snippets.php'));
						get_template_part( 'inc/content', 'snippets' );
						$postcountnum++;
					}
					wp_reset_query();
				} // end foreach
			?>

		</div>
	</div>
</section>
<?php endif; ?>

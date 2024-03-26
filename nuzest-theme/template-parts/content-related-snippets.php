<div class="row">

	<?php
	global $post;
	$args = array(
		'post_type' => get_post_type($post),
		'order' => 'DESC',
		'orderby' => 'rand',
		'post__not_in' => array( $post->ID ),
		'posts_per_page' => 4,
		'ignore_sticky_posts' => true
	);

	$categories = get_the_category();
	$cats = array();
	foreach ( $categories as $category ) {
		$cats[] = $category->cat_ID;
	}
	if (count($cats)) {
		$cats = implode(',', $cats);
		$args['cat'] = $cats;
	}

	$snippet_query = new WP_Query( $args );

	while ( $snippet_query->have_posts() ) {
		$snippet_query->the_post();
		// generate related post snippets
		get_template_part( 'template-parts/content', 'snippets' );
	}
	wp_reset_query(); 
	?>
</div>
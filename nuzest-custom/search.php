<?php get_header(); ?>

<div class="container">
	<?php if ( have_posts() ) : ?>
	<section class="intro-sec primary-intro fill-none">
		<!-- search results -->
		<div class="row">
			<div class="col-md-12">		
					<header class="page-header">
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'NuZest Theme' ), get_search_query() ); ?></h1>
					</header>
					<!-- .page-header -->
			</div>   
		</div>
	</section>
	<div class="paginated-content row">
		<div class="col-xs-8 col-xs-offset-2 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2">
		<?php 
		while ( have_posts() ) : 
			the_post(); 
			$thumbnail_id = get_post_thumbnail_id(); 
			$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail-size', true );
			$post_type = get_post_type_object( get_post_type($post) );
			// var_dump($post_type);

			$link = get_the_permalink();
			//deep link to faqs
			if ($post_type->name == 'faqs') {
				$link = get_permalink( get_page_by_path( 'faqs' ) ) . '?q=' . get_the_title();
			}
			//general link to testimonials
			if ($post_type->name == 'testimonials') {
				$link = get_permalink( get_page_by_path( 'testimonials' ) );
			}
		?>
			<?php if ($wp_query->current_post % 2 == 0) : ?>
			<div class="row">
			<?php endif; ?>
				<div class="col-xs-12 col-sm-6 margin-bottom-xs">
					<div class="col-xs-3 col-md-4">
						<a href="<?php echo $link ?>"><img class="img-responsive" src="<?php echo $thumbnail_url[0]; ?>" alt="<?php the_title();?>"></a>
					</div>
					<div class="col-xs-9 col-md-8">
						<h3 class="flat-top"><a href="<?php echo $link ?>"><?php the_title(); ?></a></h3>
						<p><?php echo __('Content Type :') ?> <?php echo $post_type -> labels -> singular_name ; ?></p>
					</div>
				</div>	
			<?php if($wp_query->current_post % 2 != 0 || $wp_query->current_post == $wp_query->post_count): ?>
			</div>
			<?php endif ?>
		<?php endwhile; ?>
		</div>
	</div>
	<div class="row row-pagination">
		<?php nz_numeric_pagination(); ?>
	</div>
	<?php else: ?>
	<section class="intro-sec primary-intro fill-none">
		<!-- no results -->
		<div class="row">
			<div class="col-sm-10 col-sm-push-1 col-md-8 col-md-push-2 col-xl-6 col-xl-push-3">
				<h1><?php _e( 'Not found!' ); ?></h1>
				<p><?php _e( 'Sorry, we couldn&rsquo;t find the content you were looking for. Please try searching:', '' ); ?></p>
			</div>
		</div>
		<div class="row search-box">
			<div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
				<?php get_search_form(); ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
</div>

<?php get_footer(); ?>

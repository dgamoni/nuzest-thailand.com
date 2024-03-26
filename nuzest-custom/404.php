<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 */

get_header(); ?>

<section class="intro-sec primary-intro fill-none">
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-push-1 col-md-8 col-md-push-2 col-xl-6 col-xl-push-3">
				<h1><?php _e( 'Not found!', 'nuzest-custom' ); ?></h1>
				<p><?php _e( 'Sorry, we couldn&rsquo;t find the content you were looking for. Please try searching:', 'nuzest-custom' ); ?></p>
			</div>
		</div>
		<div class="row search-box">
			<div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
					<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</section>



<?php get_footer(); ?>
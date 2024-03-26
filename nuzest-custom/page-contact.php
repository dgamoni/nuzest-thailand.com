<?php get_header(); ?>
<!-- start #page-content in header.php -->

<!-- Page intro -->
<?php get_template_part( 'inc/content', 'intro' ); ?>

<!-- FAQ Search bar -->
<?php get_template_part( 'inc/block', 'faq-search' ); ?>

<!-- locations -->
<?php get_template_part( 'inc/block', 'locations' ); ?>

<!-- Store Finder -->
<?php if (wp_count_posts('stores')->publish): ?>
<div class="container">
	<div class="row section-header">
		<div class="col-md-12">
			<h1><?php _e('Find Stockists', 'nuzest-custom') ?></h1>
		</div>
	</div>
	<?php echo do_shortcode('[acf-store-locator]') ?>
</div>
<?php endif; ?>


<!-- Modal -->
<div class="modal fade" id="contactForm" tabindex="-1" role="dialog" aria-labelledby="contactForm" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="<?php _e('Close', 'nuzest-custom') ?>"><span aria-hidden="true">&times;</span></button>
				<h2 id="contactModalLabel"><?php _e('Email Us', 'nuzest-custom') ?></h2>
			</div>
			<div class="modal-body">
				<?php if ( dynamic_sidebar( 'contact-form' ) ); ?>
			</div>
		</div>
	</div>
</div>


<?php get_footer(); ?>

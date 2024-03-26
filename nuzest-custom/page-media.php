<?php get_header(); ?>
<!-- start #page-content in header.php -->

<?php get_template_part( 'inc/content', 'intro' ); ?>

<?php
$testNum = 0;
$the_query = new WP_Query( array(
		'post_type' => 'media'
		));
if ( $the_query -> have_posts() ) :
?>

<section class="content-sec snippets">
	<div class="container">
		<div class="row">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<div class="col-sm-6 col-md-3">
				<?php get_template_part( 'inc/snippet', 'media' ); ?>	
			</div>
		<?php endwhile; endif; wp_reset_query(); ?>
		</div>
	</div>
</section>



<!-- Modal -->
<div class="modal fade" id="viewMedia" tabindex="-1" role="dialog" aria-labelledby="viewMedia" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="<?php _e('Close', 'nuzest-custom') ?>"><span aria-hidden="true">&times;</span></button>
                <h5></h5>
			</div>
			<div class="modal-body">
            	<!-- Moda content generated from /inc/snippet-media.php -->
			</div>
		</div>
	</div>
</div>


<!-- // end #page-content in footer.php -->
<?php get_footer(); ?>

<?php
	wp_enqueue_script('testimonials_script', get_template_directory_uri().'/js/testimonials/testimonials.js', array('jquery'), '', true);

	get_header(); 
?>
<!-- start #page-content in header.php -->

<!-- Page intro -->
<?php get_template_part( 'inc/content', 'intro' ); ?>

<section>
	<div class="container">
    	<?php 
				$args = array(
                    'post_type' => 'testimonials',
                    'orderby' => 'date',
                    'order'   => 'DESC',
                );
                $query = new WP_Query( $args );
        ?> 
        
        <?php if ( $query->have_posts() ) : ?> 
		<div class="row padd-xs">
			
            <?php 
			$row = 0;
			while ( $query->have_posts() ) : $query->the_post(); 
				$row++; 
				
				if ( $row % 2 == 0 ) {
					echo '<div class="col-md-4 col-md-push-3 user-profile text-center">';
				} else { 
					echo '<div class="col-md-4 col-md-push-1 user-profile text-center">'; 
				}; 
				
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail_size' );
					$thumb_url = $thumb['0'];
					$test_quote = get_field( 'testimonial' );
					$trim_quote = wp_trim_words( $test_quote, $num_words = 30, $more = '&hellip; ' );
				?>
				
					<div class="img-circle img-profile" alt="<?php the_field( 'name' ) ?>" style="background-image: url( <?php echo $thumb_url ?>);"></div>
					<h4><?php the_field( 'name' ) ?></h4>
					<p class="byline"><?php the_field( 'byline' ) ?></p>
					<ul class="list-unstyled quick-list">
						<li>
							<blockquote class="blockquote-sm"><?php echo $trim_quote; ?></blockquote>
							<div class="detail"><blockquote class="blockquote-sm"><?php echo $test_quote; ?></blockquote></div>
							<p class="quick-arrow"></p>
						</li>
					</ul>
				</div><!-- end col -->
				<?php 
					if ( $row % 2 == 0 ) {
						echo '</div><div class="row">'; 
					};
					
				endwhile; ?>
		</div><!-- end row -->
         	
			
			<?php else: ?>
                <div class="row padd-xs">
                	<div class="col-md-12">
                		<?php _e('No testimonials found', 'nuzest-custom') ?>
                	</div>
                </div>
            <?php endif; ?>
    </div>
</section>


		
<div class="modal fade" id="testimonialForm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php _e('Close') ?></span></button>
				<h4 class="modal-title"><?php _e('Leave a Testimonial', 'nuzest-custom') ?></h4>
			</div>
			<div class="modal-body">
				<?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 6 ); } ?>
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php get_footer(); ?>
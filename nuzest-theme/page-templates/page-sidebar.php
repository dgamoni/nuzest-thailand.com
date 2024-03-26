<?php
/**
 * Template Name: Sidebar
 *
 * Page template with an optional right-hand sidebar area
 *
 * @package Nuzest_Theme
 */

get_header();
?>		

		<?php
		while ( have_posts() ) : the_post(); // Start of the loop.
		?>
			
			<div class="container">
				<div class="row">
				
					<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-9'); ?>>

						<div class="entry-content">
							<?php
							the_content();

							wp_link_pages( array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'nuzest-theme' ),
								'after'  => '</div>',
							) );
							?>
						</div><!-- .entry-content -->
						
						<?php if ( get_edit_post_link() ) : 
						 	get_template_part( 'template-parts/content', 'edit-link' ); 
						endif; ?>
						
						
					</article><!-- #post-<?php the_ID(); ?> -->

		
				<!-- Page Sidebar is active -->
				<?php if ( is_active_sidebar( 'page-sidebar' ) ) { ?>
					<aside class="col-md-3">
						<?php dynamic_sidebar( 'page-sidebar' ); ?>
					</aside>
				<?php } ?>
				
				</div><!-- .row -->			
			</div><!-- .container -->
			
			<?php endwhile; // End of the loop. ?>

<?php
get_footer();		

<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 *
 * @package Nuzest_Theme
 */

get_header();
?>
		
		<?php
		while ( have_posts() ) : the_post(); // Start of the loop.
		?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					
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
			
			
		<?php	// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
		?>
		
		<?php endwhile; // End of the loop. ?>
		
<?php
get_footer();

<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nuzest_Theme
 */

?>

<div class="col-xs-12 col-sm-6 margin-bottom-xs">
	<div class="col-xs-3 col-md-4">
		<a href="<?php echo get_permalink(); ?>">
			<?php 
				if ( has_post_thumbnail() ) {
				    the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ), 'class' => 'img-responsive' ) );
				} else {
					?>
					<img class="img-responsive" src="<?php echo get_template_directory_uri(). '/images/icons/default.png'; ?>">
					<?php
				}	
			?>
		</a>
	</div>
	<div class="col-xs-9 col-md-8">
		<?php the_title( sprintf( '<h3 class="flat-top"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<p><?php printf( __( 'Content Type: %s', 'nuzest-theme' ), ucfirst ( get_post_type() ) ); ?></p>
	</div>
</div>
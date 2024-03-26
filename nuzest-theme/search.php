<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage Nuzest_Theme
 * @since Nuzest Theme 2.0
 */

get_header(); ?>

	<section class="intro-sec primary-intro content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'nuzest-theme' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
			</header><!-- .page-header -->
			</main>
			</section>
			<div class="paginated-content row">
				<div class="col-xs-8 col-xs-offset-2 col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2">
			<?php
			// Start the loop.
			$count = 0;
			while ( have_posts() ) : the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				echo ($count%2 == 0 ? '<div class="row">' : '');
				get_template_part( 'template-parts/content', 'search' );
				echo ($count%2 == 1 ? '</div>' : '');

				$count++;

			// End the loop.
			endwhile;

			?>

			<div class="row row-pagination">
				<?php nz_numeric_pagination(); ?>
			</div>
			<div class="row row-pagination">
				<div class="pagination">
					<?php
					echo paginate_links(array(
						'base' => '%_%',
						'format' => '?paged=%#%',
						'current' => max(1, @$_POST['page']),
						'total' => $query->max_num_pages,
						'type' => 'list'
					));
					?>
				</div>
			</div>
			<?php
		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );
			?>
				</main><!-- .site-main -->
			</section><!-- .content-area -->
			<?php
		endif;
		?>
			</div>
		</div>


<?php //get_sidebar(); ?>
<?php get_footer(); ?>

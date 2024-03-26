<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Nuzest_Theme
 */

get_header();
?>


			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'nuzest-theme' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 text-center">
						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'nuzest-theme' ); ?></p>
					</div>
				</div>
					<div class="row search-box">
					<?php
					get_search_form();
					?>
					</div>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->


<?php
get_footer();

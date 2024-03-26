<?php

		global $post;
		global $ingredient_vc_category;

		$ingredient_list_category = "";

		if(is_product()) {
			$terms = get_the_terms( $post->ID, 'product_cat');
			foreach ( $terms as $term ) {
				$termID[] = $term->term_id;
			}
			$ingredient_list_category = $termID[0];
		} else {
			if(isset($ingredient_vc_category)) {
				$ingredient_list_category = $ingredient_vc_category;
			}
		} 

		if($ingredient_list_category !== "") {
			include(locate_template('template-parts/content-ingredients.php'));
		}


		?>

		</main><!-- / main#page-content (opened in header.php) -->

		<footer class="<?php echo $ingredient_vc_category ?>">
			<div class="footer-top">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-md-5 col-md-offset-1"><?php if (dynamic_sidebar('footer-left')) ; ?></div>
						<div class="col-xs-12 col-md-5 mailing-list"><?php if (dynamic_sidebar('footer-right')) ; ?></div>
					</div>
				</div>
			</div>

			<div class="footer-bottom">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<?php
							$args = array(
								'theme_location' => 'footer-menu',
								'menu_class' => 'footer-menu list-inline list-stacked-mobile',
								'container' => false,
								'fallback_cb' => false
							);
							wp_nav_menu($args);
							?>
							
							<p>&copy; <?php bloginfo('name'); ?> <?php echo date('Y'); ?> | <?php _e('Site design by', 'nuzest-theme' ); ?>
								<a href="http://squadink.com" title="Squad Ink digital agency" target="_blank">Squad Ink</a></p>
						</div>
					</div>
				</div>
			</div>

			<a class="scrollToTop pull-right" href="#"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>

		</footer>


		<script type="text/javascript">
			window.TEMPLATE_PATH = '<?php echo get_template_directory_uri(); ?>';
		</script>

		<!-- General modal -->
		<?php get_template_part('template-parts/content', 'modal'); ?>

		<!-- Region Select Modal -->
		<?php get_template_part('template-parts/content', 'region'); ?>

		<!-- backdrop to be activated in theme.js when ingredients sidebars are revealed -->
		<div class="in-backdrop"></div>

		<?php wp_footer(); ?>


		</div><!-- / div#page (opened in header.php) -->
	</body>
</html>
<?php get_header(); ?>
<!-- start #page-content in header.php -->

<?php get_template_part( 'inc/content', 'intro' ); ?>


<section class="text-center content-sec snippets">
	<div class="container">
		<?php
			$team = nz_get_team('ambassadors', false);

			if ( count($team) ) : shuffle($team); ?>
				<div class="row"><!--
					<?php foreach ($team as $i => $user): ?>
						--><?php include(locate_template('inc/content-bio.php')); ?><!--
					<?php endforeach; ?>
				--></div>
			<?php endif; ?>
	</div>
</section>


<!-- // end #page-content in footer.php -->
<?php get_footer(); ?>

<?php /* Template Name: About Template */ ?>

<?php get_header(); ?>
<!-- start #page-content in header.php -->

<!-- Page intro -->
<?php get_template_part( 'inc/content', 'intro' ); ?>

<!-- OUR STORY SECTION -->
<section id="story" class="content-sec">
	<div class="container">

		<div class="row">
			<div class="col-md-6 col-md-offset-4">

				<div class="story-slider royalSlider rsDefault">
					<div class="slide rsContent">
						<h1><?php the_field( 'header_1' ); ?></h1>
						<?php the_field( 'slide_1' ); ?>
					</div>

					<div class="slide rsContent">
						<h1><?php the_field( 'header_2' ); ?></h1>
						<?php the_field( 'slide_2' ); ?>
					</div>

					<div class="slide rsContent">
						<h1><?php the_field( 'header_3' ); ?></h1>
						<?php the_field( 'slide_3' ); ?>
					</div>
				</div>

				<div class="slide-nav btn-group  btn-group-justified">
					<a href="#" class="btn btn-primary btn-active"><?php the_field( 'header_1' ); ?></a>
					<a href="#" class="btn btn-primary"><?php the_field( 'header_2' ); ?></a>
					<a href="#" class="btn btn-primary"><?php the_field( 'header_3' ); ?></a>
				</div>

			</div>
		</div>
	</div>
</section>


<!-- OUR PHILOSOPHY SECTION -->
<section id="philosophy" class="content-sec">
	<div class="container">
		<div class="row section-header">
			<div class="col-md-8 col-md-offset-2">
				<h1><?php the_field( 'header_4' ); ?></h1>

				<div class="text-columns">
					<?php the_field( 'our_philosophy' ); ?>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- OUR TEAM SECTION -->
<section id="team" class="snippets content-sec fill-bg-alt text-center">
	<div class="container">
		<div class="row section-header section-header-large">
			<div class="col-md-12">
				<h1><?php _e('Our Team', 'nuzest-custom') ?></h1>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<?php // loop through to display all team members under their allocated roles
					$roles = array( 'founders', 'formulators', 'local-team' );

					foreach ( $roles as $role) :

                                                $team = nz_get_team($role,true);

						if ( count($team) ) : ?>
							<div class="team-group">
								<h1 class="role"><?php echo $team[0]->data->company_role->name ?></h1>

								<div class="row"><!--
									<?php foreach ($team as $i => $user): ?>
										--><?php include(locate_template('inc/content-bio.php')); ?><!--
									<?php endforeach; ?>
								--></div>
							</div>
				<?php   endif;
					endforeach;
				?>
			</div>
		</div>
	</div>
</section>


<!-- TESTIMONIALS SLIDER -->
<?php
/* translators: This must match the translated title of the testimonials page */
$testimonials_page = get_page_by_title( __('Testimonials','nuzest-custom') );

if( have_rows( 'testimonials' )) { ?>
<section id="testimonials" class="content-sec fill-bg-body">
	<div class="container">
		<div class="row section-header">
			<div class="col-md-12">
				<h1><?php _e('Testimonials', 'nuzest-custom') ?></h1>
				<a href="<?php echo get_page_link( $testimonials_page->ID ) ?>" class="btn btn-primary"><?php _e('View all', 'nuzest-custom') ?></a>

			</div>
		</div>

		<div class="row">
			<div class="col-md-10 col-md-push-1">
				<div class="quote-slider royalSlider rsDefault">

					<?php while ( have_rows( 'testimonials' )) {
						the_row(); ?>
						<div class="rsContent">

							<?php $test_object = get_sub_field( 'testimonial' );
                            if( $test_object ){
                                $test_quote = get_field( 'testimonial', $test_object->ID );
								$test_img = wp_get_attachment_image_src( get_post_thumbnail_id($test_object->ID), 'thumbnail_size' );
								$img_url = $test_img[0];
								$test_name = get_field( 'name', $test_object->ID );
                                $test_byline = get_field( 'byline', $test_object->ID );
                            } ?>

                            <p class="quote"><?php echo $test_quote; ?></p>
                            <article class="user-profile">
                            	<div class="img-circle img-profile img-profile-sm" alt="<?php echo $test_name; ?>" style="background-image: url(<?php echo $img_url; ?>);"></div>
								<h2><?php echo $test_name; ?></h2>
								<h4 class="byline"><?php echo $test_byline; ?></h4>
                            </article>

                        </div>
					<?php } ?>
                 </div>


				</div>
			</div>
		</div>
</section>
<?php } ?>


<!-- MEDIA SECTION -->
<?php
/* translators: This must match the translated title of the 'In the media' page */
$media_page = get_page_by_title( __('In the media', 'nuzest-custom') );
$the_query = new WP_Query( array(
	'post_type' => 'media',
	'posts_per_page' => '4'
	));
if ( $the_query -> have_posts() ) : ?>

<section id="media" class="snippets fill-bg-alt content-sec text-center">
	<div class="container">
		<div class="row section-header">
			<div class="col-md-12">
				<h1><?php _e('Media Coverage', 'nuzest-custom') ?></h1>
				<a class="btn btn-primary" href="<?php echo get_page_link($media_page->ID) ?>"><?php _e('View all', 'nuzest-custom') ?></a>
			</div>
		</div>

		<div class="row">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<div class="col-sm-6 col-md-3">
				<?php get_template_part( 'inc/snippet', 'media' ); ?>
			</div>
		<?php endwhile; ?>
		</div>
	</div>
</section>
<?php endif; wp_reset_query(); ?>



<!-- AMBASSADORS SECTION -->
<?php
	$team = nz_get_team('ambassadors', false);
	if (count($team)):
	shuffle($team);
	$team = array_slice($team, 0, 3);?>
<section id="ambassadors" class="snippets content-sec text-center">
	<div class="container">
		<div class="row section-header">
			<h1><?php _e('NuZest Ambassadors', 'nuzest-custom') ?></h1>
			<a href="/ambassadors/" class="btn btn-primary"><?php _e('View all', 'nuzest-custom') ?></a>
		</div>

		<div class="row">
			<?php foreach ($team as $i => $user): $bio_hide_link = true; ?>
				<?php include(locate_template('inc/content-bio.php')); ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>


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

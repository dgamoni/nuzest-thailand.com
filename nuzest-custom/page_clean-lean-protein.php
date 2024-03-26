<?php /* Template Name: Clean Lean Protein Template */ ?>

<?php get_header(); ?>
<!-- start #page-content in header.php -->

<!-- Generate banners -->
<?php
    $flush_banner = true;
    include(locate_template('inc/content-banners.php'));
?>

<!-- Page intro -->
<?php get_template_part( 'inc/content', 'intro' ); ?>

<!-- buy now button -->
<?php get_template_part( 'inc/banner', 'buynowbutton' ); ?>

<!-- quick list section -->
<?php get_template_part( 'inc/section', 'quicklist' ); ?>

<!-- INGREDIENTS QUOTE SECTION -->
<section class="most-effective clp">
	<div class="container static">
		<div class="row">
			<div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 col-xl-6 col-xl-offset-3">
				<blockquote><?php the_field( 'quote' ); ?></blockquote>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php
					$user = get_field('quote_author');

					if ($user) {
						// our bio partial expects a user object and ACF returns an array
						// so we gotta look it up ... again
						$user = get_user_by('email', $user['user_email']);

						// some params for the bio partial
						$bio_hide_link = true;
						$bio_small_img = true;
                        $bio_not_column = true;

						include(locate_template('inc/content-bio.php'));
					}
				?>
			</div>
		</div>
		<div class="row">
			<!--<div class="col-md-12 static">-->
            <div class="col-md-12">
				<hgroup class="effective-signoff">
					<h2><?php _e('We have nothing to hide', 'nuzest-custom') ?></h2>
					<a class="btn btn-clean-lean-protein solid toggle-in" ><?php _e('Ingredients List', 'nuzest-custom') ?></a>
				</hgroup>
			</div>
		</div>
	</div>
	<div class="spacer left"></div>
	<div class="spacer right"></div>
</section>

<!-- IMAGE GALLERY SECTION -->
<section class="gallery-story fill-bg-alt text-center">
	<h2><?php the_field( 'slideshow_header' ); ?></h2>
	<?php the_field( 'slideshow_text' ); ?>

	<!-- image carousel -->
	<div class="carousel carousel--usp drawOnView" data-carousel="product-usp">
		<?php if( have_rows( 'usp_slideshow' ) ) : while( have_rows( 'usp_slideshow' ) ): the_row(); ?>
			<div class="carousel__slide">
				<img class="carousel__image" src="<?php the_sub_field( 'image' ); ?>">
				<div class="carousel__caption">
					<h2><?php the_sub_field( 'title' ); ?></h2>
					<p><?php the_sub_field( 'description' ); ?></p>
				</div>
			</div>
		<?php endwhile; endif; ?>
	</div>
</section>

<!-- TESTIMONIAL QUOTE SECTION -->
<?php
	if ( get_field('quote') ) :
	$quote_profile   = get_field('quote_author');
?>
	<section class="product-quote">
		<div class="container fill-table">
			<div class="row vertical-align">
				<div class="col-sm-12">
					<blockquote><?php the_field( 'quote' ); ?></blockquote>

					<?php if ($quote_profile) : ?>
						<article class="profile-small">
							<h3><?php echo $quote_profile['display_name'] ?> <small><?php echo get_field('byline', 'user_' . $quote_profile['ID']); ?></small></h3>
						</article>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- HOW TO USE SECTION -->
<section class="how-to-take padd-xs">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center">
				<h1><?php the_field( 'usage_header' ); ?></h1>
				<?php the_field( 'usage_text' ); ?>
            </div>
         </div>
         <div class="row">
         	<div class="col-md-10 col-md-offset-1">
				<?php if( get_field( 'video' ) ): ?>
                	<div class="videoWrapper">
                		<?php the_field( 'video' ); ?>
                	</div>
				<?php endif; ?>
            </div>
         </div>
	</div>
</section>





<?php get_template_part( 'inc/block', 'recent-product-posts' ); ?>

<?php get_footer(); ?>


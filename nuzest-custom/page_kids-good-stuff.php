<?php /* Template Name: Kids Good Stuff Template */ ?>

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


<!-- kids good stuff interactive section -->
<section class="kgs-nutrients">
	<div class="spacer left"></div>
	<div class="spacer right"></div>
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h1><?php the_field( 'nutrients_header' ); ?></h1>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3 text-center">
				<?php the_field( 'nutrients_text' );?>
			</div>
		</div>
        
	<div class="row">
        <div class="col-md-12 text-center">
			<a class="btn btn-primary solid toggle-in"><?php _e('Ingredients List', 'nuzest-custom') ?></a>
        </div>
    </div>
    
		<div class="row">
			<div class="kgs-nutrients__content drawOnView">
				<div class="nutrients">

					<?php if( have_rows( 'nutrients' ) ) : while( have_rows( 'nutrients' ) ): the_row(); ?>

					<div class="nutrients__bubble bubble--<?php the_sub_field( 'size' ); ?> activeToggle">
						<div class="wrap">
							<h2><?php the_sub_field( 'title' ); ?></h2>
						</div>
						<div class="wrap">
							<p><?php the_sub_field( 'description' ); ?></p>
						</div>
						<span></span>
					</div>

					<?php endwhile; endif; ?>

				</div>

				<div class="kgs-nutrients__package"></div>
				<div class="kgs-nutrients__straw"></div>

			</div>
		</div>
	</div>
</section>

<!-- IMAGE GALLERY SECTION -->
<section class="gallery-story fill-bg-alt text-center">
	<h2><?php the_field( 'slideshow_header' ); ?></h2>
	<?php the_field( 'slideshow_text' ); ?>

	<!-- image carousel -->
	<div class="carousel carousel--usp drawOnView" data-carousel="product-usp">
		<?php if( have_rows( 'slides' ) ) : while( have_rows( 'slides' ) ): the_row(); ?>
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

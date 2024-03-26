<?php /* Template Name: Good Green Stuff Template */ ?>

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

<section class="most-effective">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				<h1 class="larger"><?php the_field( 'section_0_header' ); ?></h1>
				<?php the_field( 'section_0_text' ); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-md-6 col-lg-6 col-xl-4 col-sm-offset-2 col-md-offset-3 col-lg-offset-3 col-xl-offset-4">
				<ul class="list-unstyled effective">
					<li><a class="btn btn-primary btn-square btn-full-width" href="#effective-1">1. <?php the_field( 'section_1_header' ); ?></a></li>
					<li><a class="btn btn-primary btn-square btn-full-width" href="#effective-2">2. <?php the_field( 'section_2_header' ); ?></a></li>
					<li><a class="btn btn-primary btn-square btn-full-width" href="#effective-3">3. <?php the_field( 'section_3_header' ); ?></a></li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				<h2><?php _e('Good Green Stuff is packed full of greens, fruits, vegetables, herbs, vitamins, minerals, anti-oxidants and much more', 'nuzest-custom') ?></h2>
				<a class="btn btn-primary solid toggle-in"><?php _e('Ingredients List', 'nuzest-custom') ?></a>
			</div>
		</div>
	</div>
	<div class="spacer left"></div>
	<div class="spacer right"></div>
</section>

<!-- Vitamins and Minerals infographic section -->
<p class="anchor" id="effective-1"></p>
<section class="effective-1 fill-bg-alt text-center">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<p class="eff-num">1</p>
				<h2><?php the_field( 'section_1_header' ); ?></h2>
				<p><?php the_field( 'section_1_text' ); ?></p>
			</div>
		</div>

		<div class="row">
			<div class="vitamins col-lg-10 col-lg-offset-1">

				<div class="rsArrow rsArrowLeft"><div class="rsArrowIcn"></div></div>
				<div class="rsArrow rsArrowRight"><div class="rsArrowIcn"></div></div>

				<ul class="vitamins__menu list-unstyled">
				<?php if( have_rows( 'vitamins' ) ) : while( have_rows( 'vitamins' ) ): the_row(); ?>
					<?php
						// calculate percentages and differences
						$nz_qty = get_sub_field('nz_qty');
						$comp_qty =  get_sub_field('comp_qty');

						switch ($nz_qty) {
							case in_array($nz_qty, range(0,4)): $max_val = "5"; break;
							case in_array($nz_qty, range(5,9)): $max_val = "10"; break;
							case in_array($nz_qty, range(10,20)): $max_val = "20"; break;
							case in_array($nz_qty, range(21,49)): $max_val = "50"; break;
							case in_array($nz_qty, range(51,99)): $max_val = "100"; break;
							case in_array($nz_qty, range(100,199)): $max_val = "200"; break;
							case in_array($nz_qty, range(200,299)): $max_val = "300"; break;
							default : $max_val = "350"; break;
						}

						$nz_val = 100/$max_val * $nz_qty;
						$comp_val = 100/$max_val * $comp_qty;
					?>

					<li>
						<a href="#" class="vitamins__link"
						   	data-title="<?php the_sub_field('vitamin'); ?>"
						   	data-heading="<?php the_sub_field('heading'); ?>"
						   	data-description="<?php the_sub_field('description'); ?>"
						   	data-nz-bar-value="<?php echo $nz_val; ?>"
							data-other-bar-value="<?php echo $comp_val; ?>"
							data-nz-pct-more="<?php the_sub_field( 'percentage' ); ?>">

							<?php the_sub_field('vitamin'); ?>
						</a>
					</li>
				<?php endwhile; endif; ?>
				</ul>

				<div class="vitamins__bubble">
					<a href="#" class="close">
						<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					</a>

					<h2 class="more visible-xs visible-sm"></h2>
                    <h2 class="heading hidden-xs hidden-sm"></h2>
					<h3 class="heading visible-xs visible-sm"></h3>
					<div class="description"></div>
				</div>

				<div class="btmBar">
					<div class="bar-graph">
						<!-- NuZest bar -->
						<div class="barNuZest">
							<div class="barDetails">
								<div class="percent"></div>
								<span class="moreOf"></span>
							</div>
						</div>
						<!-- Competitor bar -->
						<div class="barCompet"></div>

						<div class="bubble-link-wrapper">
							<a href="#" class="bubble-link">?</a>
						</div>
					</div>

					<div class="logo"><?php _e('NuZest', 'nuzest-custom') ?></div>
					<p class="other-logo"><?php _e('Comparison<br/>Brands', 'nuzest-custom') ?></p>
				</div>

			</div>
		</div>
	</div>
</section>

<!-- INGREDIENTS + IMAGE GALLERY SECTION -->
<p class="anchor" id="effective-2"></p>
<section class="gallery-story text-center">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<p class="eff-num">2</p>
				<h2><?php the_field( 'section_2_header' ); ?></h2>
				<p><?php the_field( 'section_2_text' ); ?></p>
			</div>
		</div>
	</div>

	<!-- image carousel -->
	<div class="carousel carousel--usp drawOnView" data-carousel="product-usp">
		<?php if( have_rows( 'better_forms' ) ) : while( have_rows( 'better_forms' ) ): the_row(); ?>
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

<!-- FORMULATED BY EXPERTS SECTION -->
<p class="anchor" id="effective-3"></p>
<section class="effective-3 fill-bg-alt text-center">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<p class="eff-num">3</p>
				<h2><?php the_field( 'section_3_header' ); ?></h2>
				<p><?php the_field( 'section_3_text' ); ?></p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="effective-diagram drawOnView">
					<div class="eff-circle science">
						<hgroup>
							<h2><?php _e('Science', 'nuzest-custom') ?></h2>
						</hgroup>
					</div>
					<div class="ggs-pack"></div>
					<div class="eff-circle nature">
						<hgroup>
							<h2><?php _e('Nature', 'nuzest-custom') ?></h2>
						</hgroup>
					</div>
				</div>
			</div>
		</div>

		<?php
			$roles = array( 'formulators' );

			foreach ( $roles as $role) :
				$team = nz_get_team($role);
				if ( count($team) ) : ?>
					<div class="row">
                    	<div class="col-lg-10 col-lg-push-1">
                    		<div class="row">
						<?php foreach (array_slice($team, 0, 4) as $user) : // limit to 4 records
							$authURL = get_author_posts_url($user->ID);
							$photo = get_field( 'photo', 'user_' . $user->ID );
						?>
							<article class="user-profile col-sm-6 col-md-3 col-centered">
								<div class="img-circle img-profile"
									<?php if( !empty( $photo ) ) : ?>
										style="background-image: url( <?php echo $photo['url']; ?> );"
									<?php endif; ?>
									alt="<?php echo $user->data->display_name ?>">
								</div>
								<h4><?php echo $user->data->display_name ?></h4>
								<p class="byline"><?php echo get_field('byline', 'user_' . $user->ID); ?></p>
                                <p class="shortBio"><?php echo get_field( 'short_bio', 'user_' . $user->ID ); ?></p>
								<p>
									<a class="btn btn-primary hidden-xs" href="#showBio" data-show-modal="bio" data-profile-id="<?php echo$user->data->ID ?>"><?php _e('View Bio', 'nuzest-custom') ?></a>
									<a class="hidden-sm hidden-md hidden-lg" href="<?php echo $authURL ?>"><?php _e('View Bio', 'nuzest-custom') ?></a>
								</p>
							</article>
						<?php endforeach; ?>
                        	</div>
                        </div>
					</div>
		<?php   endif;
			endforeach;
		?>
	</div>
</section>


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

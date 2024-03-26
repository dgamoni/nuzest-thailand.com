<?php
/**
 * Template part for displaying single blog posts with author sidebar
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nuzest_Theme
 */

?>

	<?php
	// Get the post banner image
	$banner_image_url = get_field( 'banner_image', $post->ID );
	
	// Get the post author
	$auth = $post->post_author;
	
	// User details from team custom post type
	$user_details_args = array(
		'post_type' => 'teams',
		'meta_query' => array(
			array(
				'key' => 'user_page_email',
				'value' => get_the_author_meta( 'email', $auth ),
				'compare' => 'LIKE',
			)
		)
	);

	$user_details = new WP_Query( $user_details_args );

	// Set up author information
	$authID = get_the_author_meta( 'ID' );
	$authName = get_the_author_meta( 'display_name', $auth );
	$authPhotoUrl = nuzest_avatar( get_the_author_meta( 'ID' ) );
	$authURL = get_author_posts_url( $auth );
	$authDescription = get_the_author_meta( 'description' );
	
	$teamUser = '';

	// If Author has a Team Bio post, use that information instead
	$has_profile = get_field( 'has_profile', 'user_' . $authID );
	$has_profile_object = get_field( 'profile_link', 'user_' . $authID );

	if ( $has_profile ) {

		$teamUser = $has_profile_object->ID;

		$authDescription = get_the_excerpt( $has_profile_object->ID );
		$authPhotoUrl = get_the_post_thumbnail( $has_profile_object->ID );
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $has_profile_object->ID ), "thumbnail" );

		if ( isset( $thumbnail[ 0 ] ) )
			$authPhotoUrl = $thumbnail[ 0 ];
	}
	?>

	
<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-post'); ?> itemscope="itemscope" itemtype ="http://schema.org/Article">

	<div class="post-detail wrap container">
			<div class="row">

				<section class="col-md-9 col-md-push-1 post-wrapper">

					<!-- Post banner image -->
					<?php if ($banner_image_url) { ?>
					<div class="row">
						<div class="col-md-11">
							<header class="entry-header-image">
								<img class="img-responsive" src="<?php echo $banner_image_url; ?>" itemprop="image">
							</header>
						</div>
					</div>
					<?php }  ?>

					<!-- Post body -->
					<div class="row">
						<div class="col-md-11">
							<div class="post-body">
								<!-- Post header -->
								<header class="entry-header">
									<?php the_title( '<h1 class="entry-title" itemprop="headline name">', '</h1>' ); ?> 
									<p class="posted-on"><?php _e('Posted on', 'nuzest-theme'); ?> 
										<span itemprop="datePublished" content="<?php echo get_the_date( 'Y-m-d' ); ?>"><?php echo get_the_date( 'd-M-Y' ); ?></span>
										| <span rel="author" itemprop="author" href="<?php echo $authURL ?>"><?php echo $authName; ?></span>
									</p>
								</header>
								<!-- Post content -->
								<div itemprop="articleBody">
									<?php the_content(); ?>
								</div>
								
							</div>
						</div>
					</div>


					<!-- Post navigation -->
					<div class="row post-navigation">
						<?php $prev_post = get_previous_post();
							if (!empty($prev_post)): ?>
								<a class="col-xs-12 col-sm-6 prev" href="<?php echo get_permalink($prev_post->ID); ?>">
									<?php _e('Previous', 'nuzest-theme') ?> -
									<?php echo $prev_post->post_title; ?>
								</a>
						<?php endif; ?>
						<?php $next_post = get_next_post();
								if (!empty($next_post)): ?>
								<a class="col-xs-12 col-sm-6 next <?php if (empty($prev_post)) echo 'col-sm-offset-6' ?>" href="<?php echo get_permalink($next_post->ID); ?>">
									<?php _e('Next', 'nuzest-theme') ?> -
									<?php echo $next_post->post_title; ?>
								</a>
						<?php endif; ?>
					</div>

				</section> <!-- / .col.post-wrapper -->


				<aside class="col-md-3 author-wrapper no-print">
					<div class="author-inner text-center">

						<div class="author-upper">
							<p class="text-uppercase">
								<?php _e('This article written by', 'nuzest-theme') ?>
							</p>
							<div class="img-circle img-profile" 
								alt="<?php echo $authName; ?>" 
								<?php if ($authPhotoUrl): ?>style="background-image: url(<?php echo $authPhotoUrl; ?>);"
								<?php endif; ?>>
							</div>
							<p class="authName" >
								<?php echo $authName; ?>
								<span class="authByline">
									<?php if($authDescription):?>–
									<?php endif;?>
									<?=$authDescription ?>
								</span>
							</p>
							<p>
								<?php echo($user_details->have_posts() ? $user_details->get_posts()[0]->short_bio : ""); ?>
							</p>
							<p>
								<a href="<?php echo $authURL ?>">
									<?php printf(__('More articles by %s', 'nuzest-theme'), $authName) ?>
								</a>
							</p>
							<?php if ($teamUser): ?>
							<a class="btn btn-primary hidden-sm hidden-md hidden-lg" href="<?= get_author_posts_url(get_the_author_id()); ?>">
								<?php _e('View Bio', 'nuzest-theme') ?>
							</a>
							<?php if($teamUser):?>
							<a class="btn btn-primary hidden-xs" href="<?php echo $authURL ?>" data-show-modal="bio" data-profile-id="<?php echo $auth; ?>" data-author-id="<?php echo $teamUser; ?>">
								<?php _e('View Bio', 'nuzest-theme') ?>
							</a>
							<?php endif;?>
							<?php endif; ?>
						</div>

						<div class="author-lower">
							<!-- Post tage -->
							<div class="tags clearfix">
								<?php
								$terms = get_the_terms( $post->ID, 'category' );
								foreach ( $terms as $term ) {
									if ( $term->name != 'home-page' ) {
										$tag = $term->name;
										echo '<p class="snip-tag"><span itemprop="about">' . $tag . '</span></p>';
									}
								}
								?>
							</div>

							<!---- Social Share Section ---->
							<div class="share social-links">
								<?php echo social_sharing_buttons(); ?>
							</div>
							
							<!-- Schema.org Publisher information -->
							<?php get_template_part('template-parts/content', 'schema-publisher'); ?>

						</div>
					</div>

				</aside><!-- .col.author-wrapper -->

			</div><!-- .row -->

	</div><!-- .container -->

</article>

<aside class="snippets fill-bg-alt">
	<div class="container">
		<div class="row section-header">
			<div class="col-md-12">
				<h1>
					<?php _e('Related Articles', 'nuzest-theme') ?>
				</h1>
			</div>
		</div>

		<?php get_template_part('template-parts/content', 'related-snippets'); ?>
	</div>
</aside>

<?php get_header(); ?>

<?php the_post(); ?>

<?php
	$thumbnail_id = get_post_thumbnail_id();
	$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail-size', true );
	$thumbnail_meta = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true);
?>

<section class="post-detail">
	<div class="container">
		<div class="row">

			<div class="col-md-9 col-md-push-1 post-wrapper">

				<div class="row">
					<div class="col-md-11">
						<header class="page-header">
							<img class="img-responsive" src="<?php the_field( 'banner_image' ); ?>">
						</header>
					</div>
				</div>
				<div class="row">
					<div class="col-md-11">
						<div class="post-body">
							<h1><?php the_title(); ?></h1>
							<?php the_content(); ?>
						</div>
					</div>
				</div>

				<div class="row post-navigation">
					<?php $prev_post = get_previous_post(); if (!empty( $prev_post )): ?>
					<a class="col-xs-12 col-sm-6 prev" href="<?php echo get_permalink( $prev_post->ID ); ?>"><?php _e('Previous') ?> - <?php echo $prev_post->post_title; ?></a>
					<?php endif; ?>
					<?php $next_post = get_next_post(); if (!empty( $next_post )): ?>
					<a class="col-xs-12 col-sm-6 next <?php if (empty( $prev_post )) echo 'col-sm-offset-6' ?>" href="<?php echo get_permalink( $next_post->ID ); ?>"><?php _e('Next') ?> - <?php echo $next_post->post_title; ?></a>
					<?php endif; ?>
				</div>
			</div><!-- /END CONTENT COLUMN -->

			<div class="col-md-3 author-wrapper">
			<?php
				$authID = $post->post_author;
				$authName = get_the_author_meta( 'display_name', $authID );
				$authByline = get_field( 'byline', 'user_' . $authID );
				$authBio = get_field( 'short_bio', 'user_' . $authID );
				$authPhoto = get_field( 'photo', 'user_' . $authID );
				$authURL = get_author_posts_url($authID);
			?>

				<div class="author-inner text-center">
					<div class="author-upper">
						<p class="text-uppercase"><?php _e('This article written by', 'nuzest-custom') ?></p>
						<div class="img-circle img-profile"
							alt="<?php echo $authName; ?>"
							<?php if ($authPhoto): ?>
								style="background-image: url(<?php echo $authPhoto['url']; ?>);"
							<?php endif; ?>>
						</div>
						<p class="authName"><?php echo $authName; ?><span class="authByline"> – <?php echo $authByline; ?></span></p>
						<p><?php echo $authBio; ?></p>
						<p><a href="<?php echo $authURL ?>"><?php printf(__('More articles by %s', 'nuzest-custom'), $authName) ?></a></p>
						<a class="btn btn-primary hidden-xs" href="<?php echo $authURL ?>" data-show-modal="bio" data-profile-id="<?php echo $authID; ?>"><?php _e('View Bio', 'nuzest-custom') ?></a>
						<a class="btn btn-primary hidden-sm hidden-md hidden-lg" href="<?php echo $authURL ?>"><?php _e('View Bio', 'nuzest-custom') ?></a>
					</div>
					<div class="author-lower">
						<div class="recipe-tags clearfix">
						<?php
							$taxarray = array ('category');
							$terms = get_the_terms( $post->ID, $taxarray );
							foreach ( $terms as $term ) {
								if($term->name != 'home-page') {
									$tag = $term->name;
									echo '<p class="snip-tag"><span>' . $tag . '</span></p>';
								}
							}
						?>
						</div>
						<?php get_template_part( 'inc/block', 'social-share' ); ?>
					<!-- <p><em>on <?php echo the_time( 'l, F, jS, Y' ); ?><br>
						in <?php the_category( ', ' ); ?></em>
					</p> -->
					</div>
				</div>
			</div><!-- /END AUTHOR SIDEBAR -->
		</div><!-- /END ROW -->
	</div>
</section>

<section class="snippets fill-bg-alt">
	<div class="container">
		<div class="row section-header">
			<div class="col-md-12">
				<h1><?php _e('Related Articles', 'nuzest-custom') ?></h1>
			</div>
		</div>

		<?php get_template_part( 'inc/block', 'related-snippets' ); ?>
	</div>
</section>

<?php get_footer(); ?>

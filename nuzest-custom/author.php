<?php
	get_header();

	// set up author details
	$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
	$authID = $curauth->ID;

	$authName 		= get_the_author_meta( 'display_name', $authID );
	$authByline 		= get_field( 'byline', 'user_' . $authID );
	$authBio 		= get_field( 'full_bio', 'user_' . $authID );
	$authPhoto 		= get_field( 'photo', 'user_' . $authID );
	$authURL 		= get_the_author_meta('user_url', $authID);
	$authEmail 		= get_the_author_meta('user_email', $authID);
?>

<section>
	<div class="container">
		<div class="row section-header">
			<div class="col-sm-12">
				<h1><?php printf(__('Articles by %s','nuzest-custom'), $authName) ?></h1>
                <h4><?php echo $authByline; ?></h4>
                <a class="btn btn-primary hidden-xs" href="<?php echo $authURL ?>" data-show-modal="bio" data-profile-id="<?php echo $authID; ?>"><?php _e('View Bio', 'nuzest-custom') ?></a>
						<a class="btn btn-primary hidden-sm hidden-md hidden-lg" href="<?php echo $authURL ?>"><?php _e('View Bio', 'nuzest-custom') ?></a>
			</div>
		</div>
	</div>
</section>

<!-- posts by user -->
<section class="fill-bg-alt">
	<div class="container">

		<div class="row padd-xs">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<div class="col-sm-6 col-md-3">
					<?php
						$thumbnail_id = get_post_thumbnail_id();
						$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail-size', true );
						$desc = get_the_content();
   						$trim_desc = wp_trim_words( $desc, $num_words = 18, $more = '&hellip; ' );
					?>
					<article class="snippet">
						<a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo $thumbnail_url[0]; ?>" alt="<?php the_title();?>"></a>

						<div class="info">
							<h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
							<p class="hidden-xs hidden-sm"><?php echo($trim_desc); ?></p>
						</div>

						<a class="btn btn-primary" href="<?php the_permalink(); ?>">View</a>
					</article>
				</div>
			<?php endwhile; endif; ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>

<?php
//// Generate post snippets (query must be opened and closed on the page itself) ////

// generate responsive boostrap column based on post type and number
// open the <div class="col">
global $post;
setup_postdata( $post );

// posts cols get staggered 1/3/2/4 at lg, and shown/hidden on <lg , based on $postcountnum
global $postcountnum;
if (!isset($postcountnum)) $postcountnum = 0;
switch ($postcountnum) {
	case 1: $col_classes = "col-sm-6 col-md-4 col-lg-3"; break;
	case 2: $col_classes = "hidden-xs hidden-sm col-md-4 col-md-push-4 col-lg-3 col-lg-push-3"; break;
	case 3: $col_classes = "col-md-4 col-md-pull-4 col-lg-3 col-lg-pull-3"; break;
	case 4: $col_classes = "hidden-xs hidden-sm hidden-md col-lg-3"; break;
	default: $col_classes = "col-sm-6 col-md-6 col-lg-3";
}

$title = get_the_title($post->ID);
$permalink = get_permalink($post->ID);
$thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail-size', true );

// BUG - something is resetting the $post when we call get_the_excerpt,
// (possibly a pluggin / filter calling reset_post?)
// WORKAROUND - store $post before and reset after call...
$pre_post = $post;
$desc = get_the_excerpt();
$post = $pre_post;
// END WORKAROUND

?>
<div class="<?php echo $col_classes ?>">
	<article class="snippet">
		<a href="<?php echo $permalink ?>" title="<?php echo $title ?>" class="snippet-image">
			<img class="img-responsive" width="100%" src="<?php echo $thumbnail_url[0]; ?>" alt="<?php echo $thumbnail_meta; ?>">
		</a>

		<?php
		if( get_post_type() == 'recipes' ) {
			//if snippet is a recipe, display tags
			$terms = get_the_terms( $post->ID, 'dietary' );
		?>
		<div class="recipe-tags clearfix">
			<?php
			if (is_array($terms)) {
				foreach ( array_slice($terms, 0, 3) as $term ) {
					$diet = $term->name;
			?>
			<p class="snip-tag"><span><?php echo $diet ?></span></p>
			<?php
				}
			} ?>
		</div>
        
		<?php
		} else {
			//otherwise snippet is a blog post so display author info
			$authID = $post->post_author;
			$authName = get_the_author_meta( 'display_name', $authID );
			$authByline = get_field( 'byline', 'user_' . $authID );
			$authBio = get_field( 'short_bio', 'user_' . $authID );
			$authPhoto = get_field( 'photo', 'user_' . $authID );
			$authURL = get_author_posts_url($authID);
		?>
        
		<div class="author-info">
			<div class="img-circle img-profile" alt="<?php echo $authName ?>" <?php if ($authPhoto): ?>style="background-image: url(<?php echo $authPhoto['url'] ?>);"<?php endif; ?>></div>
			<p class="authName"><?php echo $authName ?></p>
			<p class="authByline hidden-xs hidden-sm"><?php echo $authByline ?></p>
        </div>
		<?php
		} ?>

		<div class="info">
			<h5 class="title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h5>
			<p><?php echo($desc); ?></p>
		</div>
		<a class="btn btn-primary" href="<?php echo $permalink; ?>"><?php _e('View', 'nuzest-custom') ?></a>
	</article>
</div>

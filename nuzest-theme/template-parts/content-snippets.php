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
$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium', true );
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
        <a href="<?= $permalink ?>" title="<?= $title ?>" class="snippet-image">
        	<img  width="100%" src="<?= $img[0] ?>" alt="<?= $title ?>">
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

            $user_details_args = array(
                'post_type' => 'teams',
                'meta_query' => array(
                    array(
                        'key' => 'user_page_email',
                        'value' => get_the_author_meta( 'email', $post->post_author ),
                        'compare' => 'LIKE',
                    )
                )
            );

            $user_details = new WP_Query($user_details_args);

            $authID = $post->post_author;
            $authName = get_the_author_meta( 'display_name', $authID );
//            $authByline = get_field( 'byline', 'user_' . $authID );
            $authBio = ($user_details->have_posts() ? $user_details->get_posts()[0]->short_bio : "");
            $authPhoto = get_avatar( get_the_author_meta( 'ID' ), 32 );
            $authURL = get_author_posts_url($authID);
            $avatarUrl = nuzest_avatar( get_the_author_meta('ID') );
            ?>
            <?php

            $author_description = ($user_details->have_posts() ? $user_details->get_posts()[0]->post_excerpt : "");

            $author_id = get_the_author_meta('ID');
            $has_profile = get_field('has_profile', 'user_'.$author_id);
            $has_profile_object = get_field('profile_link', 'user_'.$author_id);

            if($has_profile) {
                $auth_description = get_the_excerpt($has_profile_object->ID);
                $avatarUrl = get_the_post_thumbnail($has_profile_object->ID);
                $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $has_profile_object->ID ), "thumbnail" );

                if(isset($thumbnail[0]))
                    $avatarUrl = $thumbnail[0];
            }
            ?>

            <div class="author-info">
                <div class="img-circle img-profile" alt="<?php echo $authName ?>" <?php
                if ($avatarUrl): ?>style="background-image: url(<?php echo $avatarUrl ?>);"<?php endif; ?>></div>
                <p class="authName"><?php echo $authName ?></p>
                <p class="authByline hidden-xs hidden-sm"><?php echo $auth_description; ?></p>
            </div>
            <?php
        } ?>

        <div class="info">
			<h5 class="title">
				<a target="_self" href="<?= $permalink ?>" onclick="location.reload()">
					<?= $title ?>
				</a>
			</h5>
			<p class="hidden-xs hidden-sm">
				<?= wp_trim_words($desc, 24); ?>
			</p>
		
			<a class="text-link" target="_self" href="<?= $permalink ?>" onclick="location.reload()">
				<?php _e('View More', 'nuzest-theme') ?>
			</a>
		 </div>
    </article>
</div>

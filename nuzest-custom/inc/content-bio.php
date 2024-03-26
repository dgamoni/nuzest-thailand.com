<div class="<?php if (!isset($bio_not_column) || !$bio_not_column): ?>col-xs-6 col-sm-6 col-md-3 col-centered<?php endif ?>">
<article class="user-profile snippet UID-<?php echo $user->ID; ?>">
    <div class="img-circle img-profile <?php if (isset($bio_small_img) && $bio_small_img): ?>img-profile-sm<?php endif; ?>"
        
		<?php 
		$photo = get_field( 'photo', 'user_' . $user->ID );
		if( !empty( $photo ) ) { ?>
        	 style="background-image: url( <?php echo $photo['url']; ?> );"
        <?php }; ?>
        
        alt="<?php echo $user->data->display_name ?>">
    </div>
    <h2><?php echo $user->data->display_name ?></h2>
    <h4><?php echo get_field('byline', 'user_' . $user->ID); ?></h4>

    <?php if (!isset($bio_hide_link) || !$bio_hide_link): ?>
        <a class="btn btn-primary hidden-xs
        	<?php 
			$bio = get_field( 'full_bio', 'user_' . $user->ID );
			if( empty( $bio ) ) {
				echo 'disabled'; };
            ?>
            " 
        	href="#showBio"
            data-show-modal="bio"
            data-profile-id="<?php echo $user->data->ID ?>"
            >
            Bio
            <img src="<?php bloginfo('template_directory'); ?>/images/loading-bubbles.svg" alt="Loading icon" class="loading">
        </a>
        <a class="btn btn-primary hidden-sm hidden-md hidden-lg" href="<?php echo get_author_posts_url($user->ID); ?>"><?php _e('View Bio', 'nuzest-custom') ?></a>
    <?php endif; ?>
</article>
</div>
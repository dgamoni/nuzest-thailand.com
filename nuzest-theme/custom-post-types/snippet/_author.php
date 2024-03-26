<div class="author-info">
    <?php

    $author_name = get_the_author_meta('display_name');
    $author_description = get_the_author_meta('description');

    $user_id = get_the_author_meta('ID');

    $has_profile = get_field('has_profile', 'user_'.$user_id);
    $has_profile_object = get_field('profile_link', 'user_'.$user_id);

    if($has_profile) {

        $author_description = get_the_excerpt($has_profile_object->ID);
        $avatarUrl = get_the_post_thumbnail($has_profile_object->ID);
        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $has_profile_object->ID ), "thumbnail" );

        if(isset($thumbnail[0]))
            $avatarUrl = $thumbnail[0];
    }
    ?>

    <div class="img-circle img-profile" alt="<?=$author_name; ?>"
        <?php if ($avatarUrl) {
            echo 'style="background-image: url(' . $avatarUrl . ')"';
        } ?>
    >
        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"
           class="blockLink"></a>
    </div>
    <p class="authName"><?=$author_name; ?></p>
    <p class="authByline hidden-xs hidden-sm"><?=$author_description;?></p>
</div>
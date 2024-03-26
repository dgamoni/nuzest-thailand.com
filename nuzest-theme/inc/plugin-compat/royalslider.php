<?php
// Royal Slider Custom Fields
function royal_slider_custom_fields($m, $post, $options) {

    // Get Banner Image
    $m->addHelper('banner_image_url', function() use ($post) {
		
		if( get_field('banner_image', $post->ID) ){
			$imgURL = get_field('banner_image', $post->ID);
		} else {
			$thumb_id = get_post_thumbnail_id( $post->ID );
        	$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
        	$imgURL = $thumb_url_array[0];
		}
		return $imgURL;
		
		
    } );

    // Get Author Name
    $m->addHelper('custom_field_author_name', function() use ($post) {

        return get_the_author_meta('display_name', $post->post_author);

    } );

    // Get Description
    $m->addHelper('custom_field_author_snippet', function() use ($post) {

        $author_description = get_the_author_meta('description', $post->post_author);

        $author_id = $post->post_author;
        $has_profile = get_field('has_profile', 'user_'.$author_id);
        $has_profile_object = get_field('profile_link', 'user_'.$author_id);

        if($has_profile) {
            $author_description = get_the_excerpt($has_profile_object->ID);
        }

        return $author_description;
    } );

    // Get Avatar
    $m->addHelper('custom_field_author_photo', function() use ($post) {

        $avatarUrl = nuzest_avatar( $post->post_author );

        $author_id = $post->post_author;
        $has_profile = get_field('has_profile', 'user_'.$author_id);
        $has_profile_object = get_field('profile_link', 'user_'.$author_id);

        if($has_profile) {
            $avatarUrl = get_the_post_thumbnail($has_profile_object->ID);
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $has_profile_object->ID ), "thumbnail" );

            if(isset($thumbnail[0]))
                $avatarUrl = $thumbnail[0];
        }

        return $avatarUrl;
    } );

    // Get Avatar
    $m->addHelper('custom_field_diet_types', function() use ($post) {
        $terms = get_the_terms($post->ID, 'dietary');
        $tags = "";
        if (is_array($terms)) {
            foreach (array_slice($terms, 0, 3) as $term) {
                $tags .= '<p class="snip-tag"><span>'.$term->name.'</span></p>';
            }
        }
        return $tags;
    } );
}

add_filter('new_rs_slides_renderer_helper','royal_slider_custom_fields', 10, 4);


/// ROYAL SLIDER PLUGIN FUNTIONS ///

// Add custom skins
add_filter('new_royalslider_skins', 'new_royalslider_add_custom_skin', 10, 2);
function new_royalslider_add_custom_skin($skins) {
    $skins['nz-feat-banner'] = array(
        'label' => 'Nuzest feature banner',
        'path' => get_template_directory_uri() . '/css/royalslider-skins/nuzest-feature-banner/nuzest-feature-banner.css'
    );
    $skins['nz-post-slider'] = array(
        'label' => 'Nuzest post slider',
        'path' => get_template_directory_uri() . '/css/royalslider-skins/nuzest-post-slider/nuzest-post-slider.css'
    );
    $skins['nz-inner-carousel'] = array(
        'label' => 'Nuzest inner carousel',
        'path' => get_template_directory_uri() . '/css/royalslider-skins/nuzest-inner-carousel/nuzest-inner-carousel.css'
    );
    return $skins;
}

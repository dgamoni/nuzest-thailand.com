<?php

function ajax_get_profile() {

	// The $_REQUEST contains all the data sent via ajax
	if ( isset($_REQUEST) ) {

		$authID = $_REQUEST['authorID'];

		$args = array(
			'p' => $authID,
			'post_type' => 'teams',
			'tax_query' => array(
				array(
					'taxonomy' => 'team_taxonomy',
					'field' => 'slug',
					'terms' => $_REQUEST["role"],
				)
			)
			);

		$user = new WP_Query($args);
		$image = wp_get_attachment_image_src(get_post_thumbnail_id($user->posts[0]->ID), 'single-post-thumbnail');
//		$authType = get_field('company_role', 'user_' . $authID)->slug;
		// customer wanted to change here
		//if (!in_array($authType, array('ambassadors','formulators','founders','local-team'))) {
		//	die();
		//}

		// load the page data, passing the id
		$authName 		= $user->posts[0]->post_title;
		$authNameOnly = substr($authName, 0, strpos($authName, " "));
		$authByline 	= $user->posts[0]->post_excerpt;
		$authBio 		= $user->posts[0]->post_content;
		$authPhotoURL	= $image[0];
//
		$authURL 		= get_post_meta($authID, 'user_url')[0];
		$authEmail 		= get_post_meta($authID, 'user_email')[0];
		$authFacebook 	= get_post_meta($authID, 'facebook')[0];
		$authTwitter 	= get_post_meta($authID, 'twitter')[0];
		$authGooglePlus = get_post_meta($authID, 'googleplus')[0];
		$authSkype 		= get_post_meta($authID, 'skype')[0];
		$authInstagram 	= get_post_meta($authID, 'instagram')[0];
//
		$authContact = '';
		if ($authURL) {
			$authContact .= '<div class="row margin-bottom-xs"><a class="underlined" target="_blank" href="' . $authURL . '"><i class="fa fa-globe col-xs-1 text-center"></i> '.$authURL.'</a></div>';
		}
		if ($authEmail) {
			$authContact .= '<div class="row margin-bottom-xs"><a class="underlined" href="mailto:' . $authEmail . '"><i class="fa fa-envelope-o col-xs-1 text-center"></i> '.$authEmail.'</a></div>';
		}
		if ($authFacebook) {
			$authContact .= '<div class="row margin-bottom-xs"><a class="underlined" target="_blank" href="' . $authFacebook . '"><i class="fa fa-facebook col-xs-1 text-center"></i> '.$authFacebook.'</a></div>';
		}
		if ($authTwitter) {
			$authContact .= '<div class="row margin-bottom-xs"><a class="underlined" target="_blank" href="' . $authTwitter . '"><i class="fa fa-twitter col-xs-1 text-center"></i> '.$authTwitter.'</a></div>';
		}
		if ($authInstagram) {
			$authContact .= '<div class="row margin-bottom-xs"><a class="underlined" target="_blank" href="' . $authInstagram . '"><i class="fa fa-instagram col-xs-1 text-center"></i> '.$authInstagram.'</a></div>';
		}
		if ($authGooglePlus) {
			$authContact .= '<div class="row margin-bottom-xs"><a class="underlined" target="_blank" href="' . $authGooglePlus . '"><i class="fa fa-google-plus col-xs-1 text-center"></i> '.$authGooglePlus.'</a></div>';
		}
		if ($authSkype) {
			$authContact .= '<div class="row margin-bottom-xs"><a class="underlined" target="_blank" href="' . $authSkype . '"><i class="fa fa-skype col-xs-1 text-center"></i> '.$authSkype.'</a></div>';
		}
		if ($authContact != '') $authContact = '<h3 class="margin-bottom-xs">'. __('Contact', 'nuzest-theme') .'</h3>' . $authContact;

		$authPosts = '';
		$posts = get_posts(array(
			'author' => $_REQUEST['id'],
			'numberposts' => 3
		));
		foreach($posts as $post) {
			$authPosts .= '<div class="margin-bottom-xs"><a class="underlined" href="' . get_permalink($post->ID) . '">'.$post->post_title.'</a></div>';
		}
		if ($authPosts != '') $authPosts = '<h3 class="margin-bottom-xs">' . sprintf(__('Recent Posts By %s', 'nuzest-theme'), $authNameOnly) . '</h3>' . $authPosts;

		$data = <<<EOD
<div class="row">
	<div class="col-md-5">
		<img class="img-responsive margin-bottom-md" src="$authPhotoURL" ?>
		$authContact
		$authPosts
	</div>
	<div class="col-md-6 col-xl-5 author-info">
		<hgroup>
			<h1>$authName</h1>
			<h4>$authByline</h4>
		</hgroup>
		$authBio
	</div>
</div>
EOD;

		// return data
		echo $data;

		// print_r($_REQUEST);

	}

	// Always die in functions echoing ajax content
	die();
}

add_action( 'wp_ajax_ajax_get_profile', 'ajax_get_profile' );
add_action( 'wp_ajax_nopriv_ajax_get_profile', 'ajax_get_profile' );

?>

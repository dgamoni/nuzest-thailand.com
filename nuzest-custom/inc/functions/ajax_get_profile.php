<?php

	function ajax_get_profile() {
	 
		// The $_REQUEST contains all the data sent via ajax
		if ( isset($_REQUEST) ) {
		 
			$authID = $_REQUEST['id'];

			$authType = get_field('company_role', 'user_' . $authID)->slug;
			if (!in_array($authType, array('ambassadors','formulators','founders','local-team'))) {
				die();
			}
			 
			// load the page data, passing the id
			$authName 		= get_the_author_meta( 'display_name', $authID );
			$authByline 	= get_field( 'byline', 'user_' . $authID );
			$authBio 		= get_field( 'full_bio', 'user_' . $authID );
			$authPhoto 		= get_field( 'photo', 'user_' . $authID );
			$authPhotoURL	= $authPhoto['url'];
			
			$authURL 		= get_the_author_meta('user_url', $authID);
			$authEmail 		= get_the_author_meta('user_email', $authID);
			$authFacebook 	= get_the_author_meta('facebook', $authID);
			$authTwitter 	= get_the_author_meta('twitter', $authID);
			$authGooglePlus = get_the_author_meta('googleplus', $authID);
			$authSkype 		= get_the_author_meta('skype', $authID);

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
			if ($authGooglePlus) {
				$authContact .= '<div class="row margin-bottom-xs"><a class="underlined" target="_blank" href="' . $authGooglePlus . '"><i class="fa fa-google-plus col-xs-1 text-center"></i> '.$authGooglePlus.'</a></div>';
			}
			if ($authSkype) {
				$authContact .= '<div class="row margin-bottom-xs"><a class="underlined" target="_blank" href="' . $authSkype . '"><i class="fa fa-skype col-xs-1 text-center"></i> '.$authSkype.'</a></div>';
			}
			if ($authContact != '') $authContact = '<h3 class="margin-bottom-xs">'. __('Contact', 'nuzest-custom') .'</h3>' . $authContact;

			$authPosts = '';
			$posts = get_posts(array(
				'author' => $_REQUEST['id'],
				'numberposts' => 3
			));
			foreach($posts as $post) {
				$authPosts .= '<div class="margin-bottom-xs"><a class="underlined" href="' . get_permalink($post->ID) . '">'.$post->post_title.'</a></div>';
			}
			if ($authPosts != '') $authPosts = '<h3 class="margin-bottom-xs">' . sprintf(__('Recent Posts By %s', 'nuzest-custom'), get_the_author_meta( 'first_name', $authID )) . '</h3>' . $authPosts;
		 	
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

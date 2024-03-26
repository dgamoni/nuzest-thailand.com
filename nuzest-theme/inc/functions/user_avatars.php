<?php

/**
 * Custom Avatar
 *
 * A wrapper to get an avatar src from WP User Avatar or WP Core
 *
 * @author Justin Frydman
 * @url https://codeable.io/developers/justin-frydman/?ref=7Ltd9
 *
 * @param mixed $id_or_email The ID or email address
 * @param string $size The avatar size
 *
 * @return string The avatar URL
 */
function nuzest_avatar( $id_or_email, $size = 'medium' ) {

	if( empty( $id_or_email ) ) {
		return null;
	}

	$avatar_url = null;

	// Check if the WP User Avatar is available
	if( function_exists('get_wp_user_avatar_src' ) ) {
		$avatar_url = get_wp_user_avatar_src( $id_or_email, $size );
	} else {

		$args = array(
			'size' => 512,
			'default' => 'mm',
			'force_default' => true
		);

		$avatar_url = get_avatar_url( 0, $args );
	}

	if( ! $avatar_url ) {
		return null;
	}

	return esc_url( $avatar_url );

}

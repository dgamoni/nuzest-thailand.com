<?php

// add social contact methods
function nz_add_new_contactmethods($contactmethods)
{
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['facebook'] = 'Facebook';
	return $contactmethods;
}
add_filter('user_contactmethods', 'nz_add_new_contactmethods', 10, 1);

//remove the bio (we're doing it in ACF instead)
function nz_remove_plain_bio($buffer) {
	$titles = array('#<h3>'.__('About Yourself').'</h3>#','#<h3>'.__('About the user').'</h3>#');
	$buffer=preg_replace($titles,'<h3>'.__('Password').'</h3>',$buffer,1);
	$biotable='#<h3>'.__('Password').'</h3>.+?<table.+?/tr>#s';
	$buffer=preg_replace($biotable,'<h3>'.__('Password').'</h3> <table class="form-table">',$buffer,1);
	return $buffer;
}
function profile_admin_buffer_start() { ob_start("nz_remove_plain_bio"); }
function profile_admin_buffer_end() { ob_end_flush(); }
add_action('admin_head', 'profile_admin_buffer_start');
add_action('admin_footer', 'profile_admin_buffer_end');


// remove personal options stuff
function nz_remove_personal_options( $subject ) {
	//strip everything from the options header to the next header
	$subject = preg_replace( '#<h3>'.__('Personal Options').'</h3>.+?/h3>#s', '', $subject, 1 );
	return $subject;
}
function nz_profile_subject_start() { ob_start( 'nz_remove_personal_options' );}
function nz_profile_subject_end() { ob_end_flush(); }
add_action( 'admin_head-user-edit.php', 'nz_profile_subject_start' );
add_action( 'admin_footer-user-edit.php', 'nz_profile_subject_end' );

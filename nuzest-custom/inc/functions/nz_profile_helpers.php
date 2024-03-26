<?php

// Get all team members
// ie. users with a company_role assigned.
//
// params :
// $role : either the role to find, or empty for all users with any role
function nz_get_team($role, $orderMeta = true) {
	global $page;

	$team = array();
	$args = array();

	// Order the team by their "order" metadata field. This can be toggled as
	// some lists (ambassadors) shouldn't b ordered.
	if ($orderMeta) {
		$template = get_post_meta($page->ID, '_wp_page_template', true);

		$args['meta_key']= 'order';
		$args['orderby']= 'meta_value_num';
		$args['order']= 'ASC';
	}

	// custom user query to support limiting `get_users` to multiple roles
	$users = nz_get_users_by_role(array('administrator', 'editor', 'author'), $args);

	foreach ($users as $user)
	{
		$user_role = get_field('company_role', 'user_' . $user->ID);
		if ($user_role) {
			if (
				//role request and correct slug
				($role && $user_role->slug === $role) ||
				//no role request but has role
				(!$role && $user_role)) {
					//add user role to user & store
					$user->company_role = $user_role;
					$team[] = $user;
			}
		}
	}
	return $team;
}


// Get all post authors
function nz_get_blog_authors() {
	$authors = array();

	// custom user query to support limiting `get_users` to multiple roles
	$users = nz_get_users_by_role(array('administrator', 'editor', 'author'));

	foreach ($users as $user)
	{
		$numposts = count_user_posts($user->ID);
		// Skip if has no posts
		if ($numposts < 1) continue;
		$authors[] = $user;
	}

	return $authors;
}

function nz_get_users_by_role($roles, $arguments = array()) {
	$users = array();

	foreach ($roles as $role) {
		$query_args = array(
			'role' =>	$role
		);

		// merge role argument with any passed in arguments
		$query_args = array_merge($query_args, $arguments);

		// create new WP_User_Query with arguments
		$query = new WP_User_Query($query_args);

		// retrieve records matching query
		$result = $query->get_results();

		// merge the resulting records into our result set
		$users = array_merge($result, $users);
	}

	return $users;
}

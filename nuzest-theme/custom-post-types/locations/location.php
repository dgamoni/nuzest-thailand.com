<?php

/* 
 * Depreciated as of v3.0.0
 * Locations Custom Post Type
 */



// register custom post type
if ( ! function_exists( 'custom_post_type_locations' ) ) {
	
	function custom_post_type_locations() {

		$labels = array(
					'name'                => _x( 'Location', 'Post Type General Name', 'nuzest-theme' ),
					'singular_name'       => _x( 'Location', 'Post Type Singular Name', 'nuzest-theme' ),
					'menu_name'           => __( 'Locations', 'nuzest-theme' ),
					'parent_item_colon'   => __( 'Parent Item:', 'nuzest-theme' ),
					'all_items'           => __( 'All Items', 'nuzest-theme' ),
					'view_item'           => __( 'View Item', 'nuzest-theme' ),
					'add_new_item'        => __( 'Add New Location', 'nuzest-theme' ),
					'add_new'             => __( 'Add New', 'nuzest-theme' ),
					'edit_item'           => __( 'Edit Item', 'nuzest-theme' ),
					'update_item'         => __( 'Update Item', 'nuzest-theme' ),
					'search_items'        => __( 'Search Item', 'nuzest-theme' ),
					'not_found'           => __( 'Not found', 'nuzest-theme' ),
					'not_found_in_trash'  => __( 'Not found in Trash', 'nuzest-theme' ),
			);

			// Set other options for Custom Post Type
			$args = array(
					'label' => __('Locations' , 'nuzest-theme' ),
					'description' => __('Locations' , 'nuzest-theme' ),
					'labels' => $labels,
					'supports' => array('title'),
					'hierarchical' => false,
					'menu_icon' => 'dashicons-admin-site',
					'public' => true,
					'show_ui' => true,
					'show_in_menu' => true,
					'show_in_nav_menus' => true,
					'show_in_admin_bar' => true,
					'menu_position' => 5,
					'can_export' => true,
					'exclude_from_search' => true,
					'publicly_queryable' => true,
					'capability_type' => 'page',
					'rewrite' => array('slug' => 'location', 'with_front' => FALSE)
			);
			// Registering your Custom Post Type
			register_post_type('location', $args);
		
		}
	
	add_action('init', 'custom_post_type_locations', 0);
}

require get_template_directory() . '/custom-post-types/locations/meta.php';
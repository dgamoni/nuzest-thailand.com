<?php

// register custom post type
if ( ! function_exists( 'custom_post_type_ingredients' ) ) {
	
		function custom_post_type_ingredients() {
			
						$labels = array(
								'name' 								=> _x('Ingredients', 'Post Type General Name', 'nuzest-theme' ),
								'singular_name' 			=> _x('Ingredients List', 'Post Type Singular Name', 'nuzest-theme' ),
								'add_new' 						=> _x('Add New', 'nuzest-theme' ),
								'all_items' 					=> __('Templates', 'nuzest-theme' ),
								'add_new_item' 				=> __('Add New Ingredient Template', 'nuzest-theme' ),
								'edit_item' 					=> __('Edit Ingredient Template', 'nuzest-theme' ),
								'new_item' 						=> __('New Ingredient Template', 'nuzest-theme' ),
								'view_item' 					=> __('View Ingredient Template', 'nuzest-theme' ),
								'search_items' 				=> __('Search Ingredient Templates', 'nuzest-theme' ),
								'not_found' 					=> __('Nothing found', 'nuzest-theme' ),
								'not_found_in_trash' 	=> __('Nothing found in Trash', 'nuzest-theme' ),
								'featured_image'      => __( 'Panel Image', 'nuzest-theme' ),
								'parent_item_colon' 	=> ''
						);

						$args = array(
								'labels' 								=> $labels,
								'label' 								=> __('Ingredients Panels', 'nuzest-theme' ),
								'supports' 							=> array('title', 'thumbnail', 'excerpt'),
								'taxonomies'          	=> array( 'product_cat' ),
								'hierarchical' 					=> false,
								'public' 								=> true,
								'show_ui' 							=> true,
								'show_in_menu' 					=> true,
								'show_in_nav_menus' 		=> true,
								'show_in_admin_bar' 		=> true,
								'menu_position' 				=> 5,
								'can_export' 						=> true,
								'exclude_from_search' 	=> true,
								'publicly_queryable' 		=> true,
								'capability_type' 			=> 'page'
						);
						register_post_type('ingredient_template', $args);
				}
	
				// hook into the 'init' action
    		add_action( 'init', 'custom_post_type_ingredients', 0 );
	
}
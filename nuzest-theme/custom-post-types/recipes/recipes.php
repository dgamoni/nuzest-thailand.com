<?php

// register custom post type
if ( ! function_exists( 'custom_post_type_recipes' ) ) {
	
		function custom_post_type_recipes()	{

				$labels = array(
						'name' 						=> _x('Recipes', 'Post Type General Name', 'nuzest-theme' ),
						'singular_name' 			=> _x('Recipe', 'Post Type Singular Name', 'nuzest-theme' ),
						'add_new' 					=> _x('Add New', 'nuzest-theme' ),
						'all_items' 				=> __('All Recipes', 'nuzest-theme' ),
						'add_new_item' 				=> __('Add New Recipe', 'nuzest-theme' ),
						'edit_item' 				=> __('Edit Recipe', 'nuzest-theme' ),
						'new_item' 					=> __('New Recipe', 'nuzest-theme' ),
						'view_item' 				=> __('View Recipe', 'nuzest-theme' ),
						'search_items' 				=> __('Search Recipes', 'nuzest-theme' ),
						'not_found' 				=> __('Nothing found', 'nuzest-theme' ),
						'not_found_in_trash'		=> __('Nothing found in Trash', 'nuzest-theme' ),
						'parent_item_colon' 		=> ''
				);

				$args = array(
						'label' 					=> __('recipes', 'nuzest-theme' ),
						'description' 				=> __('Recipes', 'nuzest-theme' ),
						'labels' 					=> $labels,
						'supports' 					=> array('title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'),
						'taxonomies' 				=> array('meal_type', 'dietary', 'product_cat'),
						'hierarchical'				=> false,
						'menu_icon' 				=> 'dashicons-carrot',
						'public' 					=> true,
						'show_ui' 					=> true,
						'show_in_menu' 				=> true,
						'show_in_nav_menus' 		=> true,
						'show_in_admin_bar' 		=> true,
						'menu_position' 			=> 5,
						'can_export' 				=> true,
						'exclude_from_search' 		=> false,
						'publicly_queryable' 		=> true,
						'capability_type' 			=> 'page',
						'rewrite' 					=> array('slug' => 'recipes', 'with_front' => FALSE)
				);
			
				register_post_type('recipes', $args);
		}
	
	  // hook into the 'init' action
    add_action( 'init', 'custom_post_type_recipes', 0 );
}

if ( ! function_exists( 'recipe_taxonomies' ) ) {
		function recipe_taxonomies() {
				
				// Meal Type Taxonomy
				$labels = array(
						'name' 						=> _x('Meal Types', 'taxonomy general name'),
						'singular_name' 			=> _x('Meal Type', 'taxonomy singular name'),
						'search_items' 				=> __('Search Meal Types'),
						'all_items' 				=> __('All Meal Types'),
						'parent_item' 				=> __('Parent Meal Type'),
						'parent_item_colon' 		=> __('Parent Meal Type:'),
						'edit_item' 				=> __('Edit Meal Type'),
						'update_item' 				=> __('Update Meal Type'),
						'add_new_item' 				=> __('Add New Meal Type'),
						'new_item_name' 			=> __('New Meal Type Name'),
						'menu_name' 				=> __('Meal Types'),
				);
				
				$args = array (
						'labels' 				=> $labels,
						'hierarchical' 	=> true,
						'query_var' 		=> true
				);
			
				register_taxonomy( 'meal_type', array( 'recipes' ), $args );

			
				// Dietary Taxonomy
				$labels = array(
						'name' 						=> _x('Diet Types', 'taxonomy general name'),
						'singular_name' 			=> _x('Diet Type', 'taxonomy singular name'),
						'search_items' 				=> __('Search Diet Types'),
						'all_items' 				=> __('All Diet Types'),
						'parent_item' 				=> __('Parent Diet Type'),
						'parent_item_colon' 		=> __('Parent Diet Type:'),
						'edit_item' 				=> __('Edit Diet Type'),
						'update_item' 				=> __('Update Diet Type'),
						'add_new_item' 				=> __('Add New Diet Type'),
						'new_item_name' 			=> __('New Diet Type Name'),
						'menu_name' 				=> __('Diet Types'),
				);
				
				$args = array (
						'labels' 			=> $labels,
						'hierarchical' 		=> true,
						'query_var' 		=> true
				);
			
				register_taxonomy( 'dietary', array( 'recipes' ), $args );
				
		}
	
		// hook into the 'init' action
    add_action( 'init', 'recipe_taxonomies', 0 );
}

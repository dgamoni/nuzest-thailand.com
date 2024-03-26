<?php

// register custom post type
if ( ! function_exists( 'custom_post_type_store' ) ) {
	
		function custom_post_type_store() {
			
				$labels = array(
						'name'                => _x( 'Stores', 'Post Type General Name', 'nuzest-theme' ),
						'singular_name'       => _x( 'Store', 'Post Type Singular Name', 'nuzest-theme' ),
						'menu_name'           => __( 'Stores', 'nuzest-theme' ),
						'parent_item_colon'   => __( 'Parent Item:', 'nuzest-theme' ),
						'all_items'           => __( 'All Items', 'nuzest-theme' ),
						'view_item'           => __( 'View Item', 'nuzest-theme' ),
						'add_new_item'        => __( 'Add New Store Item', 'nuzest-theme' ),
						'add_new'             => __( 'Add New', 'nuzest-theme' ),
						'edit_item'           => __( 'Edit Item', 'nuzest-theme' ),
						'update_item'         => __( 'Update Item', 'nuzest-theme' ),
						'search_items'        => __( 'Search Item', 'nuzest-theme' ),
						'not_found'           => __( 'Not found', 'nuzest-theme' ),
						'not_found_in_trash'  => __( 'Not found in Trash', 'nuzest-theme' ),
				);

				$args = array(
						'labels' 							=> $labels,
						'label' 							=> __('Stores', 'nuzest-theme' ),
						'description' 				=> __('Stores' /*, theme_name */),
						'supports' 						=> array('title'),
						'taxonomies'          => array( 'store_type', 'product_cat' ),
						'hierarchical' 				=> false,
						'menu_icon' 					=> 'dashicons-store',
						'public' 							=> true,
						'show_ui' 						=> true,
						'show_in_menu' 				=> true,
						'show_in_nav_menus' 	=> true,
						'show_in_admin_bar' 	=> true,
						'menu_position' 			=> 5,
						'can_export' 					=> true,
						'exclude_from_search' => true,
						'publicly_queryable' 	=> true,
						'capability_type'			=> 'page',
						'rewrite' 						=> array('slug' => 'store', 'with_front' => FALSE)
				);
	
				register_post_type( 'store', $args );
	
		}

		// hook into the 'init' action
    add_action( 'init', 'custom_post_type_store', 0 );
}


// register faq custom taxonomy
if ( ! function_exists( 'store_taxonomies' ) ) {
	
		function store_taxonomies() {
			
				$labels = array(
						'name' => _x('Store Types', 'taxonomy general name'),
						'singular_name' => _x('Store Type', 'taxonomy singular name'),
						'search_items' => __('Search Store Types'),
						'all_items' => __('All Store Types'),
						'parent_item' => __('Parent Store Type'),
						'parent_item_colon' => __('Parent Store Type:'),
						'edit_item' => __('Edit Store Type'),
						'update_item' => __('Update Store Type'),
						'add_new_item' => __('Add New Store Type'),
						'new_item_name' => __('New Store Type Name'),
						'menu_name' => __('Store Types'),
				);
				
				$args = array(
						'labels' => $labels, 
						'hierarchical' 	=> true, 
						'query_var' => true, 
						'sort' => true,
						'show_admin_column' => true
				);
			
				//register_taxonomy( 'store_type', array( 'store' ), $args );
				register_taxonomy(
				'store_type', // internal name = machine-readable taxonomy name
				'store', // object type = post, page, link, or custom post-type
				array(
					'hierarchical' => true, // true for hierarchical like cats, false for flat like tags
					'labels' => $labels, // the human-readable taxonomy name
					'query_var' => true, // enable taxonomy-specific querying
					'sort' => true,
					'show_admin_column' => true
				));

		}
	
		// hook into the 'init' action
    add_action( 'init', 'store_taxonomies', 0 );
}

require get_template_directory() . '/custom-post-types/stores/meta.php';

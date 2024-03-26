<?php

// register custom post type
if ( ! function_exists( 'custom_post_type_testimonials' ) ) {
		function custom_post_type_testimonials() {

		// Set UI labels for Custom Post Type
				$labels = array(
						'name'            	=> _x( 'Testimonials', 'Post Type General Name', 'nuzest-theme' ),
						'singular_name' 		=> _x( 'Testimonial', 'Post Type Singular Name', 'nuzest-theme' ),
						'add_new' 					=> _x('Add New', 'testimonial item'),
						'all_items' 				=> __('All Testimonials'),
						'add_new_item' 			=> __('Add New Testimonial'),
						'edit_item' 				=> __('Edit Testimonial'),
						'new_item' 					=> __('New Testimonial'),
						'view_item' 				=> __('View Testimonial'),
						'search_items' 			=> __('Search Testimonials'),
						'not_found' 				=>  __('Nothing found'),
						'not_found_in_trash'=> __('Nothing found in Trash'),
						'parent_item_colon' => ''
				);

				$args = array(
						'label'               => __( 'Testimonial', 'nuzest-theme' ),
						'description'         => __( 'Testimonials posts', 'nuzest-theme' ),
						'labels'              => $labels,
						'supports'            => array( 'title', 'editor','thumbnail', 'excerpt' ),
						'taxonomies'          => array( 'testimonial_taxonomy', 'product_cat' ),
						'hierarchical'        => false,
						'menu_icon'           => 'dashicons-editor-quote',
						'public'              => true,
						'show_ui'             => true,
						'show_in_menu'        => true,
						'show_in_nav_menus'   => true,
						'show_in_admin_bar'   => true,
						'menu_position'       => 5,
						'can_export'          => true,
						'exclude_from_search' => false,
						'publicly_queryable'  => true,
						'capability_type'     => 'page',
						'rewrite' 						=> array('slug' => 'testimonials', 'with_front' => FALSE)
				);

			register_post_type( 'testimonials', $args );
		}
	
    // hook into the 'init' action
		add_action( 'init', 'custom_post_type_testimonials', 0 );

}

// testimonial custom taxonomy
if ( ! function_exists( 'testimonial_taxonomies' ) ) {
		function testimonial_taxonomies() {

			$labels = array(
					'name' 							=> _x( 'Testimonial Types', 'Taxonomy General Name', 'nuzest-theme' ),
					'singular_name' 		=> _x( 'Testimonial Type', 'Taxonomy Singular Name', 'nuzest-theme' ),
					'search_items' 			=>  __( 'Search Testimonial Types' ),
					'all_items' 				=> __( 'All Testimonial Types' ),
					'parent_item' 			=> __( 'Parent Testimonial Type' ),
					'parent_item_colon'	=> __( 'Parent Testimonial Type:' ),
					'edit_item' 				=> __( 'Edit Testimonial Type' ),
					'update_item' 			=> __( 'Update Testimonial Type' ),
					'add_new_item' 			=> __( 'Add New Testimonial Type' ),
					'new_item_name' 		=> __( 'New Testimonial Type Name' ),
					'menu_name' 				=> __( 'Testimonial Types' ),
			);

		$args = array(
					'labels'            => $labels,
					'hierarchical' 			=> false,
					'query_var' 				=> true, // enable taxonomy-specific querying
		);

		register_taxonomy( 'testimonial_taxonomy', array( 'testimonials' ), $args );
		}

		add_action('init', 'testimonial_taxonomies', 0);
	
}
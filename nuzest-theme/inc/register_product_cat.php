<?php


// Register product_cat even if WooCommerce is disabled
if ( ! function_exists( 'product_cat_taxonomy' ) ) {
	
		function product_cat_taxonomy() {

			$labels = array(
					'name' 							=> _x( 'Product Categories', 'Taxonomy General Name', 'nuzest-theme' ),
					'singular_name' 		=> _x( 'Product Category', 'Taxonomy Singular Name', 'nuzest-theme' ),
					'search_items' 			=> __( 'Search Categories' ),
					'all_items' 				=> __( 'All Categories' ),
					'parent_item' 			=> __( 'Parent Category' ),
					'parent_item_colon'	=> __( 'Parent Category:' ),
					'edit_item' 				=> __( 'Edit Category' ),
					'update_item' 			=> __( 'Update Category' ),
					'add_new_item' 			=> __( 'Add New Category' ),
					'new_item_name' 		=> __( 'Name' ),
					'menu_name' 				=> __( 'Product Categories' ),
			);

		$args = array(
					'labels'            => $labels,
					'hierarchical' 			=> true,
					'query_var' 				=> true, // enable taxonomy-specific querying
		);

		register_taxonomy( 'product_cat', array( 'product', 'recipes', 'posts', 'testimonials', 'ingredient_template', 'faqs', 'store' ), $args );
		}

		add_action('init', 'product_cat_taxonomy', 5);
	
}


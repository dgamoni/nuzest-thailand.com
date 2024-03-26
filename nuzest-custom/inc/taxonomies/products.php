<?php

register_taxonomy(
    'products',
    array('recipes','post','page'),
    array(
      'hierarchical'          => true,
      'labels'                => array(
        'name'                  => _x('Products', 'taxonomy general name', 'nuzest-custom-admin'),
        'singular_name'         => _x('Product', 'taxonomy singular name', 'nuzest-custom-admin'),
        'search_items'          => __('Search Products', 'nuzest-custom-admin'),
        'all_items'             => __('All Products', 'nuzest-custom-admin'),
        'parent_item'           => null,
        'parent_item_colon'     => null,
        'edit_item'             => __('Edit Product', 'nuzest-custom-admin'),
        'update_item'           => __('Update Product', 'nuzest-custom-admin'),
        'add_new_item'          => __('Add New Product', 'nuzest-custom-admin'),
        'new_item_name'         => __('New Product', 'nuzest-custom-admin'),
        'menu_name'             => __('Products', 'nuzest-custom-admin'),
        ),
        //'capabilities' => array(
        //	'manage_terms' 				=> '',
        //	'edit_terms' 				=> '',
        //	'delete_terms' 				=> '',
        //	'assign_terms' 				=> 'edit_posts'
        //),
      'show_ui'               => true,
      'show_admin_column'     => true,
      'show_in_nav_menus'     => false,
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'products' ),
    )
);

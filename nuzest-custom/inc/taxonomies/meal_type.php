<?php

register_taxonomy(
    'meal_type',
    'recipes',
    array(
      'hierarchical'          => true,
      'labels'                => array(
        'name'                  => _x('Meal Types', 'taxonomy general name', 'nuzest-custom-admin'),
        'singular_name'         => _x('Meal Type', 'taxonomy singular name', 'nuzest-custom-admin'),
        'search_items'          => __('Search Meal Types', 'nuzest-custom-admin'),
        'all_items'             => __('All Meal Types', 'nuzest-custom-admin'),
        'parent_item'           => null,
        'parent_item_colon'     => null,
        'edit_item'             => __('Edit Meal Type', 'nuzest-custom-admin'),
        'update_item'           => __('Update Meal Type', 'nuzest-custom-admin'),
        'add_new_item'          => __('Add New Meal Type', 'nuzest-custom-admin'),
        'new_item_name'         => __('New Meal Type', 'nuzest-custom-admin'),
        'menu_name'             => __('Meal Types', 'nuzest-custom-admin'),
        ),
      //'capabilities' => array(
        //'manage_terms' 				=> '',
        //'edit_terms' 					=> '',
        //'delete_terms' 				=> '',
        //'assign_terms' 				=> 'edit_posts'
        //),
      'show_ui'               => true,
      'show_admin_column'     => true,
      'show_in_nav_menus'     => false,
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'type' ),
    )
);

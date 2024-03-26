<?php

register_taxonomy(
    'dietary',
    'recipes',
    array(
      'hierarchical'          => true,
      'labels'                => array(
        'name'                  => _x('Dietary', 'taxonomy general name', 'nuzest-custom-admin'),
        'singular_name'         => _x('Dietary', 'taxonomy singular name', 'nuzest-custom-admin'),
        'search_items'          => __('Search Dietary', 'nuzest-custom-admin'),
        'all_items'             => __('All Dietary', 'nuzest-custom-admin'),
        'parent_item'           => null,
        'parent_item_colon'     => null,
        'edit_item'             => __('Edit Dietary', 'nuzest-custom-admin'),
        'update_item'           => __('Update Dietary', 'nuzest-custom-admin'),
        'add_new_item'          => __('Add New Dietary', 'nuzest-custom-admin'),
        'new_item_name'         => __('New Dietary', 'nuzest-custom-admin'),
        'menu_name'             => __('Dietary', 'nuzest-custom-admin'),
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
      'rewrite'               => array( 'slug' => 'dietary' ),
    )
);

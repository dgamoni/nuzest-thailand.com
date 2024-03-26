<?php

register_taxonomy(
    'types',
    'stores',
    array(
      'hierarchical'          => true,
      'labels'                => array(
        'name'                  => _x('Store Type', 'taxonomy general name', 'nuzest-custom-admin'),
        'singular_name'         => _x('Type', 'taxonomy singular name', 'nuzest-custom-admin'),
        'search_items'          => __('Search Store Types', 'nuzest-custom-admin'),
        'all_items'             => __('All Store Types', 'nuzest-custom-admin'),
        'parent_item'           => null,
        'parent_item_colon'     => null,
        'edit_item'             => __('Edit Store Type', 'nuzest-custom-admin'),
        'update_item'           => __('Update Store Type', 'nuzest-custom-admin'),
        'add_new_item'          => __('Add New Store Type', 'nuzest-custom-admin'),
        'new_item_name'         => __('New Type', 'nuzest-custom-admin'),
        'menu_name'             => __('Store Types', 'nuzest-custom-admin'),
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
      'rewrite'               => array( 'slug' => 'type' ),
    )
);

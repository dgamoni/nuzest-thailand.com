<?php
register_taxonomy(
    'role',
    array('profiles','post'),
    array(
      'hierarchical'          => true,
      'labels'                => array(
        'name'                  => _x('Role', 'taxonomy general name', 'nuzest-custom-admin'),
        'singular_name'         => _x('Role', 'taxonomy singular name', 'nuzest-custom-admin'),
        'search_items'          => __('Search Roles', 'nuzest-custom-admin'),
        'all_items'             => __('All Roles', 'nuzest-custom-admin'),
        'parent_item'           => null,
        'parent_item_colon'     => null,
        'edit_item'             => __('Edit Role', 'nuzest-custom-admin'),
        'update_item'           => __('Update Role', 'nuzest-custom-admin'),
        'add_new_item'          => __('Add New Role', 'nuzest-custom-admin'),
        'new_item_name'         => __('New Role', 'nuzest-custom-admin'),
        'menu_name'             => __('Roles', 'nuzest-custom-admin'),
        ),
      'show_ui'               => true,
      'show_admin_column'     => true,
      'query_var'             => true,
      'rewrite'               => array('slug' => 'role'),
    )
);

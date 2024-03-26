<?php

register_taxonomy(
    'topics',
    'faqs',
    array(
      'hierarchical'          => true,
      'labels'                => array(
        'name'                  => _x('Topics', 'taxonomy general name', 'nuzest-custom-admin'),
        'singular_name'         => _x('Topic', 'taxonomy singular name', 'nuzest-custom-admin'),
        'search_items'          => __('Search Topics', 'nuzest-custom-admin'),
        'all_items'             => __('All Topics', 'nuzest-custom-admin'),
        'parent_item'           => null,
        'parent_item_colon'     => null,
        'edit_item'             => __('Edit Topic', 'nuzest-custom-admin'),
        'update_item'           => __('Update Topic', 'nuzest-custom-admin'),
        'add_new_item'          => __('Add New Topic', 'nuzest-custom-admin'),
        'new_item_name'         => __('New Topic', 'nuzest-custom-admin'),
        'menu_name'             => __('FAQ Topics', 'nuzest-custom-admin'),
      ),
      'show_ui'               => true,
      'show_admin_column'     => true,
      'query_var'             => true,
    )
);

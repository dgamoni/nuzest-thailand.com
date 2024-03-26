<?php

$labels = array(
  'name' => __('Stockists', 'nuzest-custom-admin'),
  'singular_name' => __('Stockist', 'nuzest-custom-admin'),
  'menu_name' => __('Stockists', 'nuzest-custom-admin'),
  'all_items' => __('All Stockists', 'nuzest-custom-admin'),
  'add_new' => __('Add New', 'nuzest-custom-admin'),
  'add_new_item' => __('Add new Stockist', 'nuzest-custom-admin'),
  'edit_item' => __('Edit Stockist', 'nuzest-custom-admin'),
  'new_item' => __('New Stockist', 'nuzest-custom-admin'),
  'view_item' => __('View Stockist', 'nuzest-custom-admin'),
  'search_items' => __('Search Stockist', 'nuzest-custom-admin'),
  'not_found' => __('No stockists found', 'nuzest-custom-admin'),
  'not_found_in_trash' => __('No stockists found in Trash', 'nuzest-custom-admin')
);

$args = array(
  'labels' => $labels,
  'public' => true,
  'exclude_from_search' => true,
  'publicly_queryable' => false,
  'show_ui' => true,
  'show_in_nav_menus' => false,
  'show_in_menu' => true,
  'capability_type' => 'post',
  'hierarchical' => false,
  'supports' => array( 'title', 'editor', 'thumbnail' ),
  'menu_icon' => 'dashicons-location-alt',
  'has_archive' => false,
  'query_var' => false,
  'can_export' => true,
  'menu_position' => 8
);

register_post_type('stores', $args);
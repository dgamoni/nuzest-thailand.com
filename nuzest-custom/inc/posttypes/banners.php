<?php

$labels = array(
  'name' => __('Banners', 'nuzest-custom-admin'),
  'singular_name' => __('Banner', 'nuzest-custom-admin'),
  'menu_name' => __('Banners', 'nuzest-custom-admin'),
  'all_items' => __('All Banners', 'nuzest-custom-admin'),
  'add_new' => __('Add New', 'nuzest-custom-admin'),
  'add_new_item' => __('Add new Banner', 'nuzest-custom-admin'),
  'edit_item' => __('Edit Banner', 'nuzest-custom-admin'),
  'new_item' => __('New Banner', 'nuzest-custom-admin'),
  'view_item' => __('View Banner', 'nuzest-custom-admin'),
  'search_items' => __('Search Banners', 'nuzest-custom-admin'),
  'not_found' => __('No banners found', 'nuzest-custom-admin'),
  'not_found_in_trash' => __('No banners found in Trash', 'nuzest-custom-admin')
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
  'menu_icon' => 'dashicons-format-gallery',
  'has_archive' => false,
  'query_var' => false,
  'can_export' => true,
  'menu_position' => 7,
);

register_post_type('banners', $args);

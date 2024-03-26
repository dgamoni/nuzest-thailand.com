<?php
register_post_type(
    'media',
    array(
      'labels' => array(
        'name'          => __('Media Coverage', 'nuzest-custom-admin'),
        'singular_name' => __('Media Coverage', 'nuzest-custom-admin'),
      ),
      'has_archive'  => false,
      'hierarchical' => false,
      'menu_icon'    => 'dashicons-list-view',
      'public'       => true,
      'rewrite'      => array('slug' => 'media', 'with_front' => false),
      'supports'     => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
      'menu_position' => 13,
    )
);

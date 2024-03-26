<?php
register_post_type(
    'faqs',
    array(
      'labels' => array(
        'name'          => __('FAQs', 'nuzest-custom-admin'),
        'singular_name' => __('FAQ', 'nuzest-custom-admin'),
      ),
      'has_archive'  => false,
      'hierarchical' => false,
      'menu_icon'    => 'dashicons-list-view',
      'public'       => true,
      'rewrite'      => array('slug' => 'faq', 'with_front' => false),
      'supports'     => array('title', 'editor', 'author'),
      'menu_position' => 8,
    )
);

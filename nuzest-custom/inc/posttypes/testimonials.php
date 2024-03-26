<?php
register_post_type(
		'testimonials',
		array(
			'labels' => array(
				'name'          => __('Testimonials', 'nuzest-custom-admin'),
				'singular_name' => __('Testimonial', 'nuzest-custom-admin'),
			),
			'has_archive'  => false,
			'hierarchical' => false,
			'menu_icon'    => 'dashicons-editor-quote',
			'public'       => true,
			'rewrite'      => array('slug' => 'testimonial', 'with_front' => false),
			'supports'     => array('title', 'editor', 'author', 'thumbnail'),
			'menu_position' => 12,
		)
);

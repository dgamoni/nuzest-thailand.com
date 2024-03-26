<?php
register_post_type(
		'recipes',
		array(
			'labels' => array(
				'name'          => __('Recipes', 'nuzest-custom-admin'),
				'singular_name' => __('Recipe', 'nuzest-custom-admin'),
				'all_items'     => __('All Recipes', 'nuzest-custom-admin'),
				'add_new'       => __('New Recipe', 'nuzest-custom-admin'),
				'add_new_item'  => __('Add New Recipe', 'nuzest-custom-admin'),
				'edit_item'     => __('Edit Recipe', 'nuzest-custom-admin'),
				'new_item'      => __('New Recipe', 'nuzest-custom-admin')
			),
			'has_archive'  => true,
			'hierarchical' => false,
			'menu_icon'    => 'dashicons-carrot',
			'public'       => true,
			'supports'     => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions', 'page-attributes'),
			'menu_position' => 6,
			//'taxonomies'		=> array('dietary', 'category', 'post_tag'),
			'publicly_queryable' => true,
			'rewrite' 		=> array('with_front' => false, 'slug' => 'recipes')
		)
);

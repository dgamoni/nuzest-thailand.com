<?php
if( function_exists('register_field_group') ):

register_field_group(array (
	'key' => 'group_54b4b6e3041df',
	'title' => 'Recipe Posts',
	'fields' => array (
	
		array (
			'key' => 'field_54b4b7a9b2d98',
			'label' => 'Serves',
			'name' => 'serves',
			'prefix' => '',
			'type' => 'number',
			'instructions' => 'Approximate number of serves.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 25,
				'class' => '',
				'id' => '',
			),
			'default_value' => 2,
			'placeholder' => '',
			'prepend' => 'Serves',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_54b4b7d3b2d99',
			'label' => 'Time to Prepare',
			'name' => 'time',
			'prefix' => '',
			'type' => 'number',
			'instructions' => 'Estimated total preparation time.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 25,
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => 'Mins',
			'min' => '',
			'max' => '',
			'step' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55151291806f5',
			'label' => 'Nuzest Product Category To Promote',
			'name' => 'nuzest_product_cat',
			'prefix' => '',
			'type' => 'taxonomy',
			'instructions' => 'Will create a link to the shop product category.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 50,
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'product_cat',
			'field_type' => 'select',
			'allow_null' => 1,
			'load_save_terms' => 0,
			'return_format' => 'object',
			'multiple' => 0,
		),
		array (
			'key' => 'field_54b9a9612525b',
			'label' => 'Ingredients',
			'name' => 'ingredients',
			'prefix' => '',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => 'field-ingredients',
			),
			'min' => '',
			'max' => '',
			'layout' => 'table',
			'button_label' => 'Add Ingredient',
			'sub_fields' => array (
				array (
					'key' => 'field_54b9a9722525c',
					'label' => 'Ingredient',
					'name' => 'ingredient',
					'prefix' => '',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_54b9a9862525d',
					'label' => 'Extra Information',
					'name' => 'extra',
					'prefix' => '',
					'type' => 'text',
					'instructions' => 'Text to be displayed if the visitor hovers over the ingredient',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
			),
		),
		array (
			'key' => 'field_54b4b7fdb2d9a',
			'label' => 'Method',
			'name' => 'method',
			'prefix' => '',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'basic',
			'media_upload' => 0,
		),
	
	
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'recipes',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'permalink',
		1 => 'custom_fields',
		2 => 'discussion',
		3 => 'comments',
		4 => 'revisions',
		5 => 'slug',
		6 => 'author',
		7 => 'format',
		8 => 'page_attributes',
		9 => 'categories',
		10 => 'tags',
		11 => 'send-trackbacks',
	),
));

register_field_group(array (
	'key' => 'group_554c82f49d042',
	'title' => 'Recipe Image Gallery',
	'fields' => array (
		array (
			'key' => 'field_54b84ac305485',
			'label' => 'Image Gallery',
			'name' => 'images',
			'prefix' => '',
			'type' => 'gallery',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => '',
			'max' => '',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => 650,
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'recipes',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

endif;

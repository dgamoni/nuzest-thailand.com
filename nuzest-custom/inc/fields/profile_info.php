<?php
if( function_exists('register_field_group') ):

register_field_group(array (
	'key' => 'group_55b1a0343117c',
	'title' => 'Team Profile',
	'fields' => array (
		array (
			'key' => 'field_551b634dc1a17',
			'label' => 'Company Role',
			'name' => 'company_role',
			'prefix' => '',
			'type' => 'taxonomy',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'taxonomy' => 'role',
			'field_type' => 'select',
			'allow_null' => 1,
			'load_save_terms' => 0,
			'return_format' => 'object',
			'multiple' => 0,
		),
		array (
			'key' => 'field_55b1a03a0f996',
			'label' => 'Display Order',
			'name' => 'order',
			'prefix' => '',
			'type' => 'number',
			'instructions' => 'Order in which to display team member profiles on the website',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => 10,
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'min' => '',
			'max' => '',
			'step' => 1,
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'administrator',
			),
		),
		array (
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'editor',
			),
		),
		array (
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'author',
			),
		),
		array (
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'contributor',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));


register_field_group(array (
	'key' => 'group_551b633605519',
	'title' => 'Profile Info',
	'fields' => array (
		
		array (
			'key' => 'field_551b6479c1a18',
			'label' => 'Byline',
			'name' => 'byline',
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
			'key' => 'field_551b648bc1a19',
			'label' => 'Short Bio',
			'name' => 'short_bio',
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
			'key' => 'field_551b64a6c1a1a',
			'label' => 'Full Bio',
			'name' => 'full_bio',
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
			'toolbar' => 'full',
			'media_upload' => 1,
		),
		array (
			'key' => 'field_5590b6ac1a7d0',
			'label' => 'Photo',
			'name' => 'photo',
			'prefix' => '',
			'type' => 'image',
			'instructions' => 'Upload a square headshot. Minimum size 385px.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => 385,
			'min_height' => 385,
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
				'param' => 'user_form',
				'operator' => '==',
				'value' => 'edit',
			),
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'administrator',
			),
		),
		array (
			array (
				'param' => 'user_form',
				'operator' => '==',
				'value' => 'edit',
			),
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'editor',
			),
		),
		array (
			array (
				'param' => 'user_form',
				'operator' => '==',
				'value' => 'edit',
			),
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'author',
			),
		),
		array (
			array (
				'param' => 'user_form',
				'operator' => '==',
				'value' => 'edit',
			),
			array (
				'param' => 'user_role',
				'operator' => '==',
				'value' => 'contributor',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));




endif;
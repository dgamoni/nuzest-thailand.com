<?php
if( function_exists('register_field_group') ):

register_field_group(array (
	'key' => 'group_54ba10090d317',
	'title' => 'Banner Image',
	'fields' => array (
		array (
			'key' => 'field_54ec100024c34',
			'label' => '',
			'name' => 'banner_image',
			'prefix' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'preview_size' => 'medium',
			'library' => 'all',
			'min_width' => '',
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
				'value' => 'post',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'left',
	'instruction_placement' => 'label',
	'hide_on_screen' => array (
		0 => 'permalink',
		//1 => 'the_content',
		// 2 => 'excerpt',
		3 => 'custom_fields',
		4 => 'discussion',
		5 => 'comments',
		6 => 'revisions',
		// 7 => 'slug',
		// 8 => 'author',
		9 => 'format',
		10 => 'page_attributes',
		//11 => 'categories',
		12 => 'tags',
		13 => 'send-trackbacks',
	),
));

endif;

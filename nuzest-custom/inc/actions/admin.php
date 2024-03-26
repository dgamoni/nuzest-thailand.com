<?php

// Re-order current menu items
function nz_edit_admin_menu()
{
    global $menu;
    $menu[11] = $menu[20]; // Move Pages to below post types
    unset($menu[20]);
}
add_action('admin_menu', 'nz_edit_admin_menu');

//Add theme fonts to admin editor
add_editor_style( 'style.css' );
function nz_admin_editor_styles() {
   add_editor_style( '//cloud.webtype.com/css/8b80ec6f-e85e-4254-bfca-b071627bf8ab.css' );
}
add_action( 'init', 'nz_admin_editor_styles' );

// other styles
function add_admin_styles() {
	//stylesheet
	wp_register_style( 'custom_admin_style', get_stylesheet_directory_uri() . '/css/admin_style.css', '', '1.0.0' );
	wp_enqueue_style( 'custom_admin_style' );
}

add_action( 'admin_enqueue_scripts', 'add_admin_styles' );

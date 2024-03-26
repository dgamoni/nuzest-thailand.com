<?php

// register custom post type
if ( ! function_exists( 'custom_post_type_media' ) ) {
	
    function custom_post_type_media() {

				$labels = array(
            'name'                => _x( 'Media Coverage', 'Post Type General Name', 'nuzest-theme' ),
            'singular_name'       => _x( 'Media Coverage', 'Post Type Singular Name', 'nuzest-theme' ),
            'menu_name'           => __( 'Media Coverage', 'nuzest-theme' ),
            'parent_item_colon'   => __( 'Parent Item:', 'nuzest-theme' ),
            'all_items'           => __( 'All Items', 'nuzest-theme' ),
            'view_item'           => __( 'View Item', 'nuzest-theme' ),
            'add_new_item'        => __( 'Add New Media Item', 'nuzest-theme' ),
            'add_new'             => __( 'Add New', 'nuzest-theme' ),
            'edit_item'           => __( 'Edit Item', 'nuzest-theme' ),
            'update_item'         => __( 'Update Item', 'nuzest-theme' ),
            'search_items'        => __( 'Search Item', 'nuzest-theme' ),
            'not_found'           => __( 'Not found', 'nuzest-theme' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'nuzest-theme' ),
        );
        $args = array(
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'),
            //'taxonomies'          => array( 'media_taxonomy' ),
            'public'              => true,
            'menu_position'       => 20,
            'rewrite'             => array('slug' => 'press', 'with_front' => FALSE),
            'menu_icon'           => 'dashicons-camera',
        );
        register_post_type( 'media', $args );
    }
    // hook into the 'init' action
    add_action( 'init', 'custom_post_type_media', 0 );
}
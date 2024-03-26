<?php

// register custom post type
if ( ! function_exists( 'custom_post_type_faqs' ) ) {

    function custom_post_type_faqs() {

        // these are the labels in the admin interface, edit them as you like
        $labels = array(
            'name'                => _x( 'FAQs', 'Post Type General Name', 'nuzest-theme' ),
            'singular_name'       => _x( 'FAQ', 'Post Type Singular Name', 'nuzest-theme' ),
            'menu_name'           => __( 'FAQs', 'nuzest-theme' ),
            'parent_item_colon'   => __( 'Parent Item:', 'nuzest-theme' ),
            'all_items'           => __( 'All Items', 'nuzest-theme' ),
            'view_item'           => __( 'View Item', 'nuzest-theme' ),
            'add_new_item'        => __( 'Add New FAQ Item', 'nuzest-theme' ),
            'add_new'             => __( 'Add New', 'nuzest-theme' ),
            'edit_item'           => __( 'Edit Item', 'nuzest-theme' ),
            'update_item'         => __( 'Update Item', 'nuzest-theme' ),
            'search_items'        => __( 'Search Item', 'nuzest-theme' ),
            'not_found'           => __( 'Not found', 'nuzest-theme' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'nuzest-theme' ),
        );
        $args = array(
            // use the labels above
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor', 'excerpt', 'page-attributes'),
            'taxonomies'          => array( 'faq_taxonomy', 'product_cat' ),
            'public'              => true,
            'menu_icon'           => 'dashicons-editor-help',
            'menu_position'       => 20,
            'rewrite'             => array('slug' => 'faqs', 'with_front' => FALSE)
        );
        register_post_type( 'faqs', $args );

    }

    // hook into the 'init' action
    add_action( 'init', 'custom_post_type_faqs', 0 );

}


// register faq custom taxonomy
if ( ! function_exists( 'faq_taxonomy' ) ) {

    // register custom taxonomy
    function faq_taxonomy() {

        // again, labels for the admin panel
        $labels = array(
            'name'                       => _x( 'FAQ Categories', 'Taxonomy General Name', 'faqs' ),
            'singular_name'              => _x( 'FAQ Category', 'Taxonomy Singular Name', 'faqs' ),
            'menu_name'                  => __( 'FAQ Categories', 'faqs' ),
            'all_items'                  => __( 'All FAQ Cats', 'faqs' ),
            'parent_item'                => __( 'Parent FAQ Cat', 'faqs' ),
            'parent_item_colon'          => __( 'Parent FAQ Cat:', 'faqs' ),
            'new_item_name'              => __( 'New FAQ Cat', 'faqs' ),
            'add_new_item'               => __( 'Add New FAQ Cat', 'faqs' ),
            'edit_item'                  => __( 'Edit FAQ Cat', 'faqs' ),
            'update_item'                => __( 'Update FAQ Cat', 'faqs' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'faqs' ),
            'search_items'               => __( 'Search Items', 'faqs' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'faqs' ),
            'choose_from_most_used'      => __( 'Choose from the most used items', 'faqs' ),
            'not_found'                  => __( 'Not Found', 'faqs' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
        );
        // the contents of the array below specifies which post types should the taxonomy be linked to
        register_taxonomy( 'faq_taxonomy', array( 'faqs' ), $args );

    }

    // hook into the 'init' action
    add_action( 'init', 'faq_taxonomy', 0 );

}

<?php

if ( ! function_exists( 'custom_post_type_teams' ) ) {

// register custom post type
    function custom_post_type_teams() {

        // these are the labels in the admin interface, edit them as you like
        $labels = array(
            'name'                => _x( 'Team Bios', 'Post Type General Name', 'teams' ),
            'singular_name'       => _x( 'Team Bio', 'Post Type Singular Name', 'teams' ),
            'menu_name'           => __( 'Team Bios', 'teams' ),
            'parent_item_colon'   => __( 'Parent Item:', 'teams' ),
            'all_items'           => __( 'All Items', 'teams' ),
            'view_item'           => __( 'View Item', 'teams' ),
            'add_new_item'        => __( 'Add New Team Item', 'teams' ),
            'add_new'             => __( 'Add New', 'teams' ),
            'edit_item'           => __( 'Edit Item', 'teams' ),
            'update_item'         => __( 'Update Item', 'teams' ),
            'search_items'        => __( 'Search Item', 'teams' ),
            'not_found'           => __( 'Not found', 'teams' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'teams' ),

        );
        $args = array(
            // use the labels above
            'labels'              => $labels,
            // we'll only need the title, the Visual editor and the excerpt fields for our post type
            'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
            // we're going to create this taxonomy in the next section, but we need to link our post type to it now
            'taxonomies'          => array( 'team_taxonomy' ),
            // make it public so we can see it in the admin panel and show it in the front-end
            'public'              => true,
            // show the menu item under the Pages item
            'menu_position'       => 20,
            'menu_icon'           => 'dashicons-businessman',
            'rewrite'             => array('slug' => 'team', 'with_front' => FALSE)
        );
        register_post_type( 'teams', $args );

    }

    // hook into the 'init' action
    add_action( 'init', 'custom_post_type_teams', 0 );

}




// Team custom taxonomy

if ( ! function_exists( 'team_taxonomy' ) ) {

    // register custom taxonomy
    function team_taxonomy() {

        // again, labels for the admin panel
        $labels = array(
            'name'                       => _x( 'Team Roles', 'Taxonomy General Name', 'teams' ),
            'singular_name'              => _x( 'Team Role', 'Taxonomy Singular Name', 'teams' ),
            'menu_name'                  => __( 'Team Roles', 'teams' ),
            'all_items'                  => __( 'All Team Roles', 'teams' ),
            'parent_item'                => __( 'Parent Team Role', 'teams' ),
            'parent_item_colon'          => __( 'Parent Team Role:', 'teams' ),
            'new_item_name'              => __( 'New Team Role', 'teams' ),
            'add_new_item'               => __( 'Add New Team Role', 'teams' ),
            'edit_item'                  => __( 'Edit Team Role', 'teams' ),
            'update_item'                => __( 'Update Team Role', 'teams' ),
            'separate_items_with_commas' => __( 'Separate items with commas', 'teams' ),
            'search_items'               => __( 'Search Items', 'teams' ),
            'add_or_remove_items'        => __( 'Add or remove items', 'teams' ),
            'choose_from_most_used'      => __( 'Choose from the most used items', 'teams' ),
            'not_found'                  => __( 'Not Found', 'teams' ),
        );
        $args = array(
            // use the labels above
            'labels'                     => $labels,
            // taxonomy should be hierarchial so we can display it like a Role section
            'hierarchical'               => true,
            // again, make the taxonomy public (like the post type)
            'public'                     => true,
        );
        // the contents of the array below specifies which post types should the taxonomy be linked to
        register_taxonomy( 'team_taxonomy', array( 'teams' ), $args );

    }

    // hook into the 'init' action
    add_action( 'init', 'team_taxonomy', 0 );

}

// Change Excerpt title to Author Byline

/*
function custom_post_type_boxes(){
    remove_meta_box( 'postexcerpt', 'teams', 'normal' );
    add_meta_box( 'postexcerpt', __( 'Author Byline' ), 'post_excerpt_meta_box', 'teams', 'normal', 'high' );
}
add_action('do_meta_boxes', 'custom_post_type_boxes');



function add_user_meta_boxes() {
	add_meta_box("user_contact_meta", "Contact Details", "add_contact_details_user_meta_box", "teams", "normal", "low");
}

function add_contact_details_user_meta_box()
{
    global $post;
    $custom = get_post_custom( $post->ID );

    ?>
    <style>.width99 {width:50%;}</style>
    <p>
        <label><strong>Website : </strong></label><br />
        <input type="text" name="user_url" value="<?= @$custom["user_url"][0] ?>" class="width99" />
    </p>
    <p>
        <label><strong>Email : </strong></label><br />
        <input type="text" name="user_email" value="<?= @$custom["user_email"][0] ?>" class="width99" />
    </p>
    <p>
        <label><strong>Facebook : </strong></label><br />
        <input type="text" name="facebook" value="<?= @$custom["facebook"][0] ?>" class="width99" />
    </p>
    <p>
        <label><strong>Instagram : </strong></label><br />
        <input type="text" name="instagram" value="<?= @$custom["instagram"][0] ?>" class="width99" />
    </p>
    <p>
        <label><strong>Twitter : </strong></label><br />
        <input type="text" name="twitter" value="<?= @$custom["twitter"][0] ?>" class="width99" />
    </p>
    <p>
        <label><strong>Google+ : </strong></label><br />
        <input type="text" name="googleplus" value="<?= @$custom["googleplus"][0] ?>" class="width99" />
    </p>
    <p>
        <label><strong>Skype : </strong></label><br />
        <input type="text" name="skype" value="<?= @$custom["skype"][0] ?>" class="width99" />
    </p>
    <?php
}
/**
 * Save custom field data when creating/updating posts
 */
/*function save_user_custom_fields(){
    global $post;

    if ( $post )
    {
        update_post_meta($post->ID, "short_bio", @$_POST["short_bio"]);
        update_post_meta($post->ID, "user_url", @$_POST["user_url"]);
        update_post_meta($post->ID, "user_email", @$_POST["user_email"]);
        update_post_meta($post->ID, "user_page_email", @$_POST["user_page_email"]);
        update_post_meta($post->ID, "facebook", @$_POST["facebook"]);
        update_post_meta($post->ID, "instagram", @$_POST["instagram"]);
        update_post_meta($post->ID, "twitter", @$_POST["twitter"]);
        update_post_meta($post->ID, "googleplus", @$_POST["googleplus"]);
        update_post_meta($post->ID, "skype", @$_POST["skype"]);
    }
}
add_action( 'admin_init', 'add_user_meta_boxes' );
add_action( 'save_post', 'save_user_custom_fields' );
*/
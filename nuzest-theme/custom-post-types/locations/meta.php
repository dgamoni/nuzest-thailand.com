<?php

add_action('admin_init', 'locationMetaInit');

function locationMetaInit()
{
    add_meta_box("location_fields", "Location Details", "location_details_meta_box", "location", "normal", "default");

    add_meta_box('location_type', 'Location Type', 'location_type_meta_box', 'location','side');

    add_action('save_post', 'save_location_custom_fields');

    add_action('admin_enqueue_scripts', 'location_admin_assets');
}


/**
 * METABOX CONTENT
 */

function location_details_meta_box($post)
{
    $companyName = get_post_meta($post->ID, 'company_name', true);
    $webSite = get_post_meta($post->ID, 'web_site', true);
    $phone = get_post_meta($post->ID, 'phone', true);
    $address = get_post_meta($post->ID, 'address', true);
    $address_2 = get_post_meta($post->ID, 'address_2', true);
    $address_3 = get_post_meta($post->ID, 'address_3', true);
    $country = get_post_meta($post->ID, 'country', true);
    $location = get_post_meta($post->ID, 'location', true);
    if(!$location || ($location['lat'] == 0 && $location['lng'] == 0)) {
        $location['lat'] = '47.6291351';
        $location['lng'] = '-122.3441147';
    }
    ?>
    <div class="row">
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSCQ_udpx7yD22jSakK9D69WdZUOc-jCQ&libraries=places&callback=initAutocomplete"
                async defer></script>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box" style="margin-top:9px; width:350px;height:31px;"/>
        <label><?= __('Location') ?>: </label><br/>
        <input class="location" name="location" type="hidden"
               value="<?= (float)$location['lat'] ?>,<?= (float)$location['lng'] ?>"/>
        <div id="map_canvas" style="width: 100%;height: 500px;"></div>
    </div>
    <div class="row">
        <label><?= __('Company Name') ?>: </label><br/>
        <input type="text" name="company_name" value="<?= $companyName ?>"
               placeholder="<?= __('e.g.: NuZest Life Pty Ltd') ?>"/>
    </div>
    <div class="row">
        <label><?= __('Web Site') ?>: </label><br/>
        <input type="text" name="web_site" value="<?= $webSite ?>"
               placeholder="<?= __('e.g.: http://www.nuzest.com') ?>"/>
    </div>

    <div class="row">
        <label><?= __('Phone') ?>: </label><br/>
        <input type="text" name="phone" value="<?= $phone ?>"
               placeholder="<?= __('e.g.: +61 (02) 9358 3855') ?>"/>
    </div>

    <div class="row">
        <label><?= __('Address Line 1') ?>: </label><br/>
        <input type="text" name="address" value="<?= $address ?>"
               placeholder="<?= __('e.g.: 405/24-30 Springfield Ave') ?>"/>
    </div>

    <div class="row">
        <label><?= __('Address Line 2') ?>: </label><br/>
        <input type="text" name="address_2" value="<?= $address_2 ?>"
               placeholder="<?= __('e.g.: Potts Point, NSW') ?>"/>
    </div>

    <div class="row">
        <label><?= __('Address Line 3') ?>: </label><br/>
        <input type="text" name="address_3" value="<?= $address_3 ?>"
               placeholder="<?= __('2011') ?>"/>
    </div>

    <div class="row">
        <label><?= __('Country') ?>: </label><br/>
        <input type="text" name="country" value="<?= $country ?>"
               placeholder="<?= __('e.g.: Australia') ?>"/>
    </div>
    <?php
}

function location_type_meta_box( $post ) {
    $value = get_post_meta($post->ID,'type',true ) ? get_post_meta($post->ID,'type',true ) : 'secondary';
    ?>
    <input type="radio" name="type" value="primary" <?php checked( $value, 'primary' ); ?> ><?= __('Primary')?>
    <span style="margin-left: 15px;"></span>
    <input type="radio" name="type" value="secondary" <?php checked( $value, 'secondary' ); ?> ><?= __('Secondary')?><br>
    <?php
}


/**
 * METABOX SAVE
 */

function save_location_custom_fields($post)
{
    global $post;

    if (!$post) {
        return;
    }

    if ($_POST['location']) {
        $location = explode(',', $_POST['location']);
        $location = ['lat' => $location[0], 'lng' => $location[1]];
    }

    $location = isset($location) ? $location : $_POST['location'];

    update_post_meta($post->ID, "company_name", $_POST['company_name']);
    update_post_meta($post->ID, "location", $location);
    update_post_meta($post->ID, "web_site", $_POST['web_site']);
    update_post_meta($post->ID, "phone", $_POST['phone']);
    update_post_meta($post->ID, "address", $_POST['address']);
    update_post_meta($post->ID, "address_2", $_POST['address_2']);
    update_post_meta($post->ID, "address_3", $_POST['address_3']);
    update_post_meta($post->ID, "country", $_POST['country']);
    update_post_meta($post->ID, "type", $_POST['type']);
}


/**
 * METABOX ASSETS AND MISC
 */

function location_admin_assets()
{
    global $post;

    if ('location' != $post->post_type) {
        return;
    }
    wp_register_style('custom_wp_admin_css', get_template_directory_uri() . '/css/admin/custom/recipes.css', false, '1.0.0');
    wp_enqueue_style('custom_wp_admin_css');
    wp_enqueue_script('location', get_template_directory_uri() . '/js/locationCustom.js', array('jquery'));
    //wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyApoJAEaiQ4_IdYYXkMOCsLmoGZjL06-sY&libraries=places&callback=changeLocation&sensor=false&v=3.exp', '', '', false);
    wp_enqueue_script('locations-admin-script', get_template_directory_uri() . '/js/admin/custom/recipes.js');
}

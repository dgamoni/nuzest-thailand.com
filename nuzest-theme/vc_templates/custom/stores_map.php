<?php

add_shortcode("store", "store_shortcode");

add_action('vc_before_init', 'store_shortcode_vc');

function store_shortcode($atts)
{
    extract(
        $attributes = shortcode_atts(
            array(
                'map_lat' => '',
                'map_lng' => '',
            ), $atts
        )
    );

    $lang = get_locale();

    if (preg_match('/(\S{2})_(\S{2})/i', $lang, $match)) {
        $language = $match[1];
        $region = $match[2];
    }

    // Enqueue necessary scripts and styles
//    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&v=3.exp&language=' . $language . '&region=' . $region, '', '', false);
    wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyApoJAEaiQ4_IdYYXkMOCsLmoGZjL06-sY&libraries=geometry&sensor=false&v=3.exp&language=' . $language . '&region=' . $region, '', '', false);
    // Register the script  AIzaSyApoJAEaiQ4_IdYYXkMOCsLmoGZjL06-sY
    wp_enqueue_script('acf-store-locator-js', get_template_directory_uri() . '/js/store-locator.js', array('jquery', 'google-maps'), '', true);
    $translation_array = array(
        'lat' => $attributes['map_lat'],
        'lng' => $attributes['map_lng']
    );
    wp_localize_script('acf-store-locator-js', 'geoData', $translation_array);
//    wp_enqueue_script('acf-store-locator-js');
//    wp_enqueue_style('acf-store-locator-css', plugins_url('css/acf-store-locator.css', __FILE__));
//    wp_enqueue_script('underscore', null, null, null, true);

    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'store',
    );

    if (get_option('theme_options')["default_location"]) {
        $loc_args = array(
            'posts_per_page' => -1,
            'post_type' => 'location',
            'post__not_in' => array(
                get_option('theme_options')["default_location"]
            )
        );

        $posts = get_posts($args);
        $def_loc = get_post(get_option('theme_options')["default_location"]);
        $def_loc_coordinates = get_post_meta($def_loc->ID, 'location', true);
        $url = get_post_meta($def_loc->ID, 'web_site', true);
        $phone = get_post_meta($def_loc->ID, 'phone', true);
        $address = get_post_meta($def_loc->ID, 'address', true);
        $address_2 = get_post_meta($def_loc->ID, 'address_2', true);
        $address_3 = get_post_meta($def_loc->ID, 'address_3', true);
        $country = get_post_meta($def_loc->ID, 'country', true);
        if (!empty(get_post_meta($def_loc->ID, 'address_2', true))) {
          $address .= " ";
          $address .= $address_2;
        }
        if (!empty(get_post_meta($def_loc->ID, 'address_3', true))) {
          $address .= ", ";
          $address .= $address_3;
        }
        if (!empty(get_post_meta($def_loc->ID, 'country', true))) {
          $address .= " ";
          $address .= $country;
        }
        ob_start();
        ?>
        <div class="store-info default-location">
            <h3><?= get_the_title(get_option('theme_options')["default_location"]) ?></h3>
            <span class="details">
                <p><a class="storeLink" href="http://<?= $url ?>" target="_blank"><?= $url ?></a></p>
                <p>
                    <?=$address; ?>
                    <br><?=__('Phone', 'acf-store-locator') . ': <a href="tel:' . $phone . '">' . $phone . '</a>'; ?>
                </p>
            </span>
        </div>
        <?php

        $lat = isset($def_loc_coordinates['lat']) ? $def_loc_coordinates['lat'] : '';
        $lng = isset($def_loc_coordinates['lng']) ? $def_loc_coordinates['lng'] : '';
        $def_loc_arr = array(
            'title' => get_the_title(get_option('theme_options')["default_location"]),
            'lat' => $lat,
            'lng' => $lng,
            'infoWindow' => ob_get_clean()
        );
    }

    $stores = outputStoreList($posts);
    if (get_option('theme_options')["default_location"]) {
        array_unshift($stores['stores'], $def_loc_arr);
    }

    $stores = $stores['stores'];
    $store_data = $stores['store_data'] ? $stores['store_data'] : [];

    $store_data = array_unique($store_data);
    $store_source = json_encode(array_values($store_data));
    $stores = json_encode($stores);

    $store_title = __('Find Stockists', 'acf-store-locator');
    $store_citystatepostcode = __('City, State or Postcode', 'acf-store-locator');
    $store_findstore = __('Search', 'acf-store-locator');
    $store_error = __('Error', 'acf-store-locator');
    $store_errormessage = __('Please enter a city or postcode.', 'acf-store-locator');
    $store_loadingmessage = __('Loading...');

    $store_map_marker_img = get_template_directory_uri() . '/images/icons/map-marker.png';
    $alt_map_marker_img = get_template_directory_uri() . '/images/icons/map-marker.png';

        ?>
<script type="text/javascript">

            <?php if(!$posts):?>

            document.getElementById('h1-stocklist').style.display = 'none';

            <?php endif;?>

            var AcfStoreLocatorInitObject = {
                stores: <?= $stores ?>,
                loadingMessage: '<?= $store_loadingmessage ?>',
                markerIcons: {
                    store: '<?= $store_map_marker_img ?>',
                    alt: '<?= $alt_map_marker_img ?>'
                }
            }

        </script>
    <?php
    if($posts) {
    ?>
<div class="container store-finder" id="acf-store-locator">
            <!-- map -->
            <div class="row">
                <div class="col-sm-12">
                    <div id="acf-map-canvas"></div>
                </div>
            </div>

            <!-- search tools & results -->
            <div class="row store-tools">
                <div class="col-lg-10 col-lg-offset-1 col-xl-8 col-xl-offset-2">
                    <div class="row">
                        <!-- options -->
                        <div class="col-sm-4 col-sm-push-8">
                            <div class="tools" id="acf-form">
                                <h3><?= $store_title ?></h3>
                                <label for="postcode"><?= $store_citystatepostcode ?>:</label>
                                <input autocomplete="off" id="acf-address" class="form-control" type="text"
                                       onkeypress="AcfStoreLocator.onSearchInputKeypress(event);"
                                       data-provide="typeahead"
                                       data-items="4" data-source='<?= $store_source ?>'>
                                <button id="acf-search-store" type="button"
                                        onclick="AcfStoreLocator.onSearchButtonClick()"
                                        class="btn btn-primary"><?= $store_findstore ?></button>
                                <!-- errors -->
                                <div id="acf-error" class="alert alert-error">
                                    <!--<h4><?= $store_error ?></h4>-->
                                    <p><?= $store_errormessage ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-8 col-sm-pull-4">
                            <ul class="store-list"></ul>
                            <div class="btn btn-primary btn-next-page" onclick="AcfStoreLocator.nextPage()">More...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    return ob_get_clean();

}

function outputStoreList($posts)
{
    ob_start();
    ?>

        <?php foreach ($posts as $post) {
    //                echo outputStore($post, 'primary');
        $title = $post->post_title;
        $image = get_the_post_thumbnail($post->ID, 'thumbnail', array('class' => 'alignleft'));
        $address = get_post_meta($post->ID, 'street_address', true);
        $location = get_post_meta($post->ID, 'location', true);
        $city = get_post_meta($post->ID, 'city', true);
        $state = get_post_meta($post->ID, 'state', true);
        $zip_code = get_post_meta($post->ID, 'zip_code', true);
        $phone = get_post_meta($post->ID, 'phone', true);
        $fax = get_post_meta($post->ID, 'fax', true);
        $url = get_post_meta($post->ID, 'url', true);
        $mapAddress = implode(', ', array_filter(array($address, $city, $state, $zip_code)));


        $phone_links = array();
        if ($phone) {
            $phone_links[] = __('Phone', 'acf-store-locator') . ': <a href="tel:' . $phone . '">' . $phone . '</a>';
        }
        if ($fax) {
            $phone_links[] = __('Fax', 'acf-store-locator') . ' : <a href="tel:' . $fax . '">' . $fax . '</a>';
        }
        if (count($phone_links)) {
            $phone_links = '<br>' . implode(' | ', $phone_links);
        } else {
            $phone_links = '';
        }

        $directions = urlencode($address . ' ' . $city . ' ' . $state . ' ' . $zip_code);
        $directions_text = __('Get directions', 'acf-store-locator');

        if ($url) {
            $display_url = '<p><a class="storeLink" href="http://' . $url . '" target="_blank">' . $url . '</a></p>';
        } else {
            $display_url = '';
        }

        $lat = isset($location['lat']) ? $location['lat'] : '';
        $lng = isset($location['lng']) ? $location['lng'] : '';

        ob_start();
        ?>
        <div class="store-info">
            <?= $image ?>
            <h3><?= $title ?></h3>
            <span class="details">
                <?= $display_url ?>
                <p>
                    <?=$mapAddress; ?>
                    <?=$phone_links; ?>
                </p>
                <a class="directions" href="https://maps.google.com/maps?daddr=<?=$directions?>" target="_blank"><?=$directions_text?></a>
            </span>
        </div>
        <?php


        $store_data[] = $city;
        $store_data[] = $zip_code;

        $store = array(
            'title' => $title,
            'lat' => $lat,
            'lng' => $lng,
            'infoWindow' => ob_get_clean()
        );
        $stores[] = $store;
    }

    return ['stores' => $stores, 'store_data' => $store_data];
}

function store_shortcode_vc()
{
    $store_taxonomies = get_terms("store_taxonomy");

    $store_groups = array('Select Option' => '');

    foreach ($store_taxonomies as $store_taxonomy) {
        $store_groups[$store_taxonomy->name] = $store_taxonomy->slug;
    }

    vc_map(
        array(
            'name' => __('Stores Map', 'custom_elements'),
            'base' => 'store',
            'description' => __('Contact page – display stockists map', 'custom_elements'),
            'category' => 'Nuzest Custom',
            'icon' => 'stores-map-vc-icon',
            'content_element' => true,
//            'params' => array(
//                array(
//                    "type" => "textfield",
//                    "heading" => __("Map Center Lat", 'custom_elements'),
//                    "param_name" => "map_lat",
//                    'holder' => 'div'
//                ),
//                array(
//                    "type" => "textfield",
//                    "heading" => __("Map Center Lng", 'custom_elements'),
//                    "param_name" => "map_lng",
//                    'holder' => 'div'
//                )
//            )
        )
    );
}

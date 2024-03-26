<?php

add_shortcode("location", "location_shortcode");

add_action('vc_before_init', 'location_shortcode_vc');

function location_shortcode($atts) {
    extract(
        $attributes = shortcode_atts(
            array(
				'contact_form_plugin' => '',
                'contact_form_id' => '',
            ), $atts
        )
    );

    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'location',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'meta_key' => 'type',
        'meta_value' => 'primary',
    );

    $primary = get_posts($args);
    $args['meta_value'] = 'secondary';
    $secondary = get_posts($args);

    return outputLocationList($attributes, $primary, $secondary);
}

function outputLocationList($attributes, $primary, $secondary) {
    ob_start();
    ?>
    <div class="container">
    <div class="row">
        <div class="col-md-4 primary-location">
            <?php
                if (get_option('theme_options')["default_location"])
                    echo outputLocation(get_post(get_option('theme_options')["default_location"]), 'primary');
                else {
                    foreach ($primary as $post) {
                        echo outputLocation($post, 'primary');
                    }
                }
            ?>
            <?php if ($attributes['contact_form_id']) : ?>
                <div class="col-xs-12 text-center">
                    <a id="contactFormBtn" data-toggle="modal" data-target="#contactFormModal"
                       class="btn btn-primary"><?= _('Email Us'); ?></a>
                </div>
                <div class="modal fade" id="contactFormModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span
                                        aria-hidden="true">&times;</span><span
                                        class="sr-only"><?php echo _('close'); ?></span></button>
                                <h4 class="modal-title"><?php echo _('Email Us'); ?></h4>
                            </div>
                            <div class="modal-body">

                                <?php 
								if ($attributes['contact_form_plugin'] == 'cf7') {
									echo do_shortcode( '[contact-form-7 id="'.$attributes['contact_form_id'].'"]' ); 
								} else {
                                	Ninja_Forms()->display( $attributes['contact_form_id'] ); 
								}
								?>
								
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
            <?php endif; ?>
        </div>
        <div class="col-md-8 secondary-location">

            <?php
                if (get_option('theme_options')["default_location"]) {
                    foreach ($primary as $post) {
                        echo outputLocation($post, 'secondary');
                    }
                }
                foreach ($secondary as $post) {
                    echo outputLocation($post, 'secondary');
                }
            ?>
        </div>
    </div>

    </div>

    <?php
    return ob_get_clean();
}

function outputLocation($post, $type) {
    $companyName = get_post_meta($post->ID, 'company_name', true);
    $webSite = get_post_meta($post->ID, 'web_site', true);
    $phone = get_post_meta($post->ID, 'phone', true);
    $address = get_post_meta($post->ID, 'address', true);
    $address_2 = get_post_meta($post->ID, 'address_2', true);
    $address_3 = get_post_meta($post->ID, 'address_3', true);
    $country = get_post_meta($post->ID, 'country', true);

    if (!empty(get_post_meta($post->ID, 'address_2', true))) {
      $address .= "<br>";
      $address .= $address_2;
    }
    if (!empty(get_post_meta($post->ID, 'address_3', true))) {
      $address .= "<br>";
      $address .= $address_3;
    }
    if (!empty(get_post_meta($post->ID, 'country', true))) {
      $address .= "<br>";
      $address .= $country;
    }
    ob_start();
    ?>

    <div class="<?= ($type == 'secondary') ? 'col-md-6' : '' ?> location">
        <h4><?= $post->post_title; ?></h4>
        <p class="lighter">(<?= $companyName; ?>)</p>
        <p><?= $webSite; ?></p>
        <?php if ($type == 'secondary'): ?>
        <p class="expand">Details <span class="glyphicon glyphicon-chevron-down"></span></p>
        <div class="details" style="display: none;">
            <?php endif;
            ?>
                <?php if($phone != ""):?>
                    <p>Phone<br><span class="lighter"><?= $phone; ?></span></p>
                <?php endif;?>
                <?php if($address != ""):?>
                    <p>Address<br><span class="lighter"><?= $address; ?></span></p>
                <?php endif;?>
            <div class="clearfix"></div>
            <?php if ($type == 'secondary'): ?>
        </div>
    <?php endif;
    ?>
    </div>
    <?php
    return ob_get_clean();
}

function location_shortcode_vc() {
    $location_taxonomies = get_terms("location_taxonomy");

    $location_groups = array('Select Option' => '');

    foreach ($location_taxonomies as $location_taxonomy) {
        $location_groups[$location_taxonomy->name] = $location_taxonomy->slug;
    }

    vc_map(
        array(
            'name' => __('Nuzest Locations', 'custom_elements'),
            'base' => 'location',
            'description' => __('Contact page – display global offices', 'custom_elements'),
            'category' => 'Nuzest (Deprecated)',
            'icon' => 'nuzest-locations-vc-icon',
            'content_element' => true,
            'params' => array(
				array(
					"type" => "dropdown",
					"value" => [__('Ninja Forms') => 'ninja_forms', __('Contact Form 7') => 'cf7'],
					"heading" => __("Contact Form Plugin", 'custom_elements'),
					"param_name" => "contact_form_plugin",
					'holder' => 'div'
				),
                array(
                    "type" => "textfield",
                    "heading" => __("Contact Form Id", 'custom_elements'),
                    "param_name" => "contact_form_id",
                    'holder' => 'div'
                )
				
            )
        )
    );
}

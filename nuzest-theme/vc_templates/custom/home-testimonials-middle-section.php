<?php

function home_testimonials_middle_section_shortcode($atts)
{

    extract(
        $attributes = shortcode_atts(
            array(
                'contact_title' => 'Need a little help?',
                'contact_description' => 'Looking for answers? Get in touch with us or check our FAQ database.',
                'contact_button_text' => 'Contact Us',
                'contact_url' => '',
                'faq_button_text' => 'FAQs',
                'faq_url' => '',
                'testimonials_title' => 'Testimonials',
                'testimonials_description' => 'See what other people have to say',
                'testimonials_button_text' => 'View All',
                'testimonials_url' => '',
                'fb_page_url' => 'https://www.facebook.com/nuzest/',
                'fb_page_title' => 'Nuzest',
            ), $atts
        )
    );

    ob_start();
    ?>
        <div class="contact-block padd-30">
            <div class="upper">
                <h2><?= $attributes['contact_title'] ?></h2>
                <?= $attributes['contact_description'] ?>
                <div>
                    <a class="btn btn-primary" href="<?= $attributes['contact_url']?>"><?= $attributes['contact_button_text']?></a>
                    <a class="btn btn-primary" href="<?= $attributes['faq_url']?>"><?= $attributes['faq_button_text']?></a>
                </div>
                <hr>
                <h2><?= $attributes['testimonials_title']?></h2>
                <?= $attributes['testimonials_description'] ?>
                <div>
                    <a class="btn btn-primary" href="<?= $attributes['testimonials_url']?>"><?= $attributes['testimonials_button_text']?></a>
                </div>
            </div>
            <div class="lower">
                <div class="fb-page" data-href="<?= $attributes['fb_page_url']?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true">
                  <blockquote cite="<?= $attributes['fb_page_url']?>" class="fb-xfbml-parse-ignore">
                    <a href="<?= $attributes['fb_page_url']?>"><?= $attributes['fb_page_title']?></a>
                  </blockquote>
                </div>
            </div>
        </div>

    <?php
    return ob_get_clean();

}

add_shortcode("home_testimonials_middle_section", "home_testimonials_middle_section_shortcode");


function home_testimonials_middle_section_shortcode_vc()
{
    $pageList = [__('Select') => ''];
    $args = array(
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'post_type' => 'page',
        'post_status' => 'publish'
    );
    $pages = get_pages();

    foreach($pages as $page) {
        $pageList[get_the_title($page->ID)] = get_page_link($page->ID);
    }

    vc_map(
        array(
            'name' => __('Home Contact Block', 'custom_elements'),
            'base' => 'home_testimonials_middle_section',
            'description' => __('Home page – contact block', 'custom_elements'),
            "category" => 'Nuzest Custom',
            'icon' => 'home-contact-block-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Contact Title", 'custom_elements'),
                    "param_name" => "contact_title",
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Contact Description", 'custom_elements'),
                    "param_name" => "contact_description",
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Contact Button Text", 'custom_elements'),
                    "param_name" => "contact_button_text"
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Contact Button Url", 'custom_elements'),
                    "param_name" => "contact_url",
                    "value" => $pageList,
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("FAQ Button Text", 'custom_elements'),
                    "param_name" => "faq_button_text"
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("FAQ Url", 'custom_elements'),
                    "param_name" => "faq_url",
                    "value" => $pageList,
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Testimonials Title", 'custom_elements'),
                    "param_name" => "testimonials_title",
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Testimonials Description", 'custom_elements'),
                    "param_name" => "testimonials_description",
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Testimonials Button Text", 'custom_elements'),
                    "param_name" => "testimonials_button_text",
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Testimonials Button Url", 'custom_elements'),
                    "param_name" => "testimonials_url",
                    "value" => $pageList,
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Facebook Page Url", 'custom_elements'),
                    "param_name" => "fb_page_url"
                ),array(
                    "type" => "textfield",
                    "heading" => __("Facebook Page Title", 'custom_elements'),
                    "param_name" => "fb_page_title",
                ),
            )
        )
    );
}

add_action('vc_before_init', 'home_testimonials_middle_section_shortcode_vc');

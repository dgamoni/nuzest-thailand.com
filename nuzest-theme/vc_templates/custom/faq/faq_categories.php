<?php

function faq_categories_shortcode($atts)
{
	$getTaxonomy = get_terms('faq_taxonomy', array(
		'hide_empty' => true,
	));
	$custom_terms = array_filter($getTaxonomy , function ($t) {
					    # This term has a parent, but its parent does not.
		return $t->parent != 0 && get_term($t->parent, 'faq_taxonomy')->parent == 0;
	});
    ob_start();
    ?>
    <div class="row">


    <section class="container">
        <div class="row">
            <div class="faq-item">
                <div class="row">
                    <?php foreach ($custom_terms as $custom_term) { ?>
                        <div class="topic-list col-sm-6 col-md-6 col-lg-3">
                            <a class="btn btn-square" href="#<?= $custom_term->term_id ?>" style="width: 100%;"><?= $custom_term->name ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section></div>
    <?php
    return ob_get_clean();

}

add_shortcode("faq_categories", "faq_categories_shortcode");


function faq_categories_shortcode_vc()
{
    vc_map(
        array(
            'name' => __('FAQ Categories (v1)', 'custom_elements'),
            'base' => 'faq_categories',
            'description' => __('Display FAQ category buttons', 'custom_elements'),
            "category" => 'Nuzest (Deprecated)',
            'icon' => 'faq-categories-vc-icon',
            'content_element' => true
        )
    );
}

add_action('vc_before_init', 'faq_categories_shortcode_vc');

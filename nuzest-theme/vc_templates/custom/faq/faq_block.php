<?php

const COLUMN_TYPE_SINGLE = 1;
const COLUMN_TYPE_DOUBLE = 2;

function faq_block_shortcodeV1($atts)
{
    $getTaxonomy = get_terms('faq_taxonomy', array(
		'hide_empty' => true,
	));
	$custom_terms = array_filter($getTaxonomy , function ($t) {
					    # This term has a parent, but its parent does not.
		return $t->parent != 0 && get_term($t->parent, 'faq_taxonomy')->parent == 0;
	});
    // Show only selected checkboxes.
    if (array_key_exists('categories', $atts) && $atts['categories']) {
        $showOnly = explode(',', $atts['categories']);
        if(!in_array(0, $showOnly)) {
            $custom_terms = array_filter($custom_terms, function (WP_Term $customTerm) use ($showOnly) {
                return in_array($customTerm->term_id, $showOnly);
            });
        }
    }

    ob_start();
    ?>
    <section class="container">
        <div class="row">
            <?php if (array_key_exists('column_type', $atts) && $atts['column_type'] == COLUMN_TYPE_DOUBLE):
            ?>
				
                <div class="col-md-12 col-lg-12">
                    <?php foreach ($custom_terms as $custom_term):
                        outputFaqArticleV1($custom_term, true);
                        endforeach;
                    ?>
                </div>
            <?php
                else:
                    foreach ($custom_terms as $custom_term):
                        outputFaqArticleV1($custom_term, false);
                    endforeach;
                endif;
            ?>
        </div>
    </section>
    <?php
    return ob_get_clean();

}

add_shortcode("faq_block", "faq_block_shortcodeV1");

function outputFaqArticleV1($faqArticle, $twoColumns = false)
{
    ?>

    <article class="row main-topic" id="<?= $faqArticle->term_id ?>">
        <div class="faq-item">
            <header class="row"><h2 class="col-md-12"><?= $faqArticle->name ?></h2></header>
            <?php outputSubCategoriesV1($faqArticle->term_id, $twoColumns ? 'col-md-6' : 'col-md-12') ?>
        </div>
    </article>

    <?php
}

function outputSubCategoriesV1($customTermID, $quickListClass = 'col-md-6')
{
    $termchildren = get_term_children($customTermID, 'faq_taxonomy');
    $args = array(
        'post_type' => 'faqs',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => -1,
        'tax_query' =>
            array('relation' => 'AND',
                array('taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => array($customTermID),
                    'operator' => 'IN'
                ),
                array('taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => $termchildren,
                    'operator' => 'NOT IN'
                )
            )
    );
    $posts = get_posts($args);
    ?>

    <div class="row sub-topic">
        <div class="quick-list faq-list <?= $quickListClass; ?>" >
            <ul class="list-unstyled faq-list">
                <?php outputFAQPostV1($posts); ?>
            </ul>
        </div>
    </div>

    <?php
    $subs = get_terms('faq_taxonomy', array(
        'parent' => $customTermID,
        'hide_empty' => 1
    ));

    foreach ($subs as $sub) :
        $subID = $sub->term_id;
        $args = array(
            'post_type' => 'faqs',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'tax_query' => array(
                array(
                    'taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => $subID,
                )));
        $posts = get_posts($args);
        ?>
        <div class="row sub-topic">
            <h3 class="col-md-12"><?= $sub->name ?></h3>
            <div class="quick-list <?= $quickListClass; ?>">
                <ul class="list-unstyled faq-list">
                    <?php outputFAQPostV1($posts); ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>

    <?php
}

function outputFAQPostV1($posts)
{
    foreach ($posts as $post):
        ?>
        <li class="faq-list-item">
            <h4><?= $post->post_title ?></h4>
            <div class="detail"><?= $post->post_content; ?></div>
            <p class="quick-arrow"></p>
            <hr>
        </li>
    <?php endforeach;
}

function faq_block_shortcode_vc_v1()
{
    // Get faq categories and transform them to value list.
    $faqCategories = get_terms('faq_taxonomy', array(
        //'parent' => 0,
        'hide_empty' => 1
    ));
    $categories = array_reduce($faqCategories, function (array $categoriesList, WP_Term $category) {
        return array_merge($categoriesList, [
            $category->name => $category->term_id
        ]);
    }, []);

    $parameters[] = array(
        "type" => "dropdown",
        "admin_label" => true,
        "class" => "hideContent",
        "heading" => __("1 Column / 2 Columns", 'custom_elements'),
        "param_name" => "column_type",
        "value" => array(
            '1 Column' => COLUMN_TYPE_SINGLE,
            '2 Columns' => COLUMN_TYPE_DOUBLE,
        ),
        'holder' => 'div'
    );
    $isFirst = true;

    // All elements
    $all = array(
        "type" => "checkbox",
        "heading" => __("FAQ Categories", 'custom_elements'),
        "param_name" => "categories",
        "value" => [__("All", 'custom_elements') => 0],
    );

    $parameters[] = $all;

    foreach ($categories as $title => $id) {
        $parameter = array(
            "type" => "checkbox",
            "param_name" => "categories",
            "value" => [$title => $id],
        );

        $parameters[] = $parameter;
    }

    vc_map(
        array(
            'name' => __('FAQ List (v1)', 'custom_elements'),
            'base' => 'faq_block',
            'description' => __('Display list of FAQs', 'custom_elements'),
            "category" => 'Nuzest (Deprecated)',
            'icon' => 'faq-list-vc-icon',
            'admin_enqueue_css' => array( get_template_directory_uri() . '/css/admin/custom/vc-icons.css' ),
            'content_element' => true,
            'params' => $parameters
        )
    );
}

add_action('vc_before_init', 'faq_block_shortcode_vc_v1');

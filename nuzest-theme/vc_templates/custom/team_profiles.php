<?php

add_shortcode("team", "team_shortcode");

add_action('vc_before_init', 'team_shortcode_vc');

function team_shortcode($atts)
{
    wp_enqueue_script('display_team', get_template_directory_uri() . '/js/display_team.js', array(), '3.7.3');

    extract(
        $attributes = shortcode_atts(
            array(
                'team_type' => '',
                'item_count' => -1,
                'display_type' => 'asc',
                'button_text' => ''
            ), $atts
        )
    );

    $args = array(
        'posts_per_page' => $attributes['item_count'],
        'post_type' => 'teams',
        'tax_query' => array(
            array(
                'taxonomy' => 'team_taxonomy',
                'field' => 'slug',
                'terms' => $attributes['team_type']
            )
        )
    );

    if ($attributes['display_type'] == "rand") {
        $args['orderby'] = "rand";
    } else {
        $args['order'] = "ASC";
        $args['orderby'] = "menu_order";
    }

    $posts = get_posts($args);

    return outputTeamList($attributes, $posts);
}

function outputTeamList($attributes, $posts)
{
    ob_start();
    $chunked = array_chunk($posts, 4);
    ?>
    <div class="team-group snippets">
        <?php
        foreach ($chunked as $posts):
            $postsCount = count($posts);
            switch ($postsCount) {
                case 3:
                    $colClass = 'col-md-4';
                    break;
                case 2:
                    $colClass = 'col-md-6 col-sm-6';
                    break;
                case 1:
                    $colClass = 'col-md-12';
                    break;
                default:
                    $colClass = 'col-md-3 col-sm-6';
                    break;
            }
            ?>
            <div class="row padd-30">
                <?php foreach ($posts as $index => $post) {
                    echo outputTeam($post, $attributes, $colClass);
                } ?>
            </div>
        <?php endforeach; ?>

    </div>

    <?php
    return ob_get_clean();
}

function outputTeam($post, $attributes, $colClass)
{
    $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'full'));
    ob_start();
    ?>
    <div class="user-profile snippet <?= $colClass; ?> UID<?= $post->ID ?>">
        <div class="img-circle img-profile" style="background-image: url(<?= $featuredImage; ?>);"
             alt="<?= $post->post_title; ?>"></div>
        <h2><?= $post->post_title; ?></h2>
        <h4><?= $post->post_excerpt; ?></h4>
        <a class="<?php if($post->post_content == ""):?>disabled<?php endif; ?> btn btn-primary biography" href="" data-show-modal="biography"
           data-profile-id="<?= $post->ID ?>" data-author-id="<?= $post->ID ?>">
            <?= $attributes['button_text']; ?>
        </a>
    </div>
    <?php
    return ob_get_clean();
}

function team_shortcode_vc()
{
    $team_taxonomies = get_terms("team_taxonomy");

    $team_groups = array('Select Option' => '');

    foreach ($team_taxonomies as $team_taxonomy) {
        $team_groups[$team_taxonomy->name] = $team_taxonomy->slug;
    }

    vc_map(
        array(
            'name' => __('People', 'custom_elements'),
            'base' => 'team',
            'description' => __('Display team members with bios', 'custom_elements'),
            "category" => 'Nuzest Custom',
            'icon' => 'people-vc-icon',
            'content_element' => true,
            'admin_enqueue_css' => array(get_template_directory_uri() . '/vc_extend/team.css'),
            'front_enqueue_js' => array(get_template_directory_uri() . '/js/display_team.js'),
            'params' => array(
                array(
                    "type" => "dropdown",
                    "admin_label" => true,
                    "class" => "hideContent",
                    "heading" => __("Team Role", 'custom_elements'),
                    "param_name" => "team_type",
                    "value" => $team_groups,
                    'holder' => 'div'
                ),
                array(
                    "type" => "textfield",
                    "admin_label" => true,
                    "class" => "hideContent",
                    "heading" => __("Display Items", 'custom_elements'),
                    "param_name" => "item_count",
                    'description' => "Number of items to display (will display all items if left blank)."
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Display Type", 'custom_elements'),
                    "param_name" => "display_type",
                    "value" => array(
                        'Recently Added' => 'asc',
                        'Random' => 'rand',
                    )
                ),
                array(
                    "type" => "textfield",
                    "admin_label" => true,
                    "class" => "hideContent",
                    "heading" => __("Button Text", 'custom_elements'),
                    "param_name" => "button_text",
                    'description' => "If button text not set, button will not show."
                ),
            ),
        )
    );
}

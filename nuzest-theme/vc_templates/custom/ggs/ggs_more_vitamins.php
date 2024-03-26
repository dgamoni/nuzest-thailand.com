<?php
/**
 * The Shortcode
 */
function vitamin_menu_shortcode($atts)
{

    extract(
        $attributes = shortcode_atts(
            array(
                'title' => '',
                'subtitle' => '',
                'vitamins' => '',
            ), $atts
        )
    );


    $vitamin_vars = vc_param_group_parse_atts($attributes['vitamins']);

    ob_start();
    ?>

    <!-- Vitamins and Minerals infographic section -->
    <p class="anchor" id="effective-1"></p>
    <section class="effective-1 fill-bg-alt text-center good-green-stuff">
        <div class="container">
            <div class="row">
                <div class="vitamins col-lg-10 col-lg-offset-1">

                    <div class="rsArrow rsArrowLeft">
                        <div class="rsArrowIcn"></div>
                    </div>
                    <div class="rsArrow rsArrowRight">
                        <div class="rsArrowIcn"></div>
                    </div>

                    <ul class="vitamins__menu list-unstyled">
                        <?php if (count($vitamin_vars) > 0): ?>
                            <?php for ($x = 0; $x < count($vitamin_vars); $x++): ?>
                                <li>
                                    <a href="#"
                                       class="vitamins__link"
                                       data-title="<?php echo wp_strip_all_tags($vitamin_vars[$x]["vitamin_name"]); ?>"
                                       data-heading="<?php echo wp_strip_all_tags($vitamin_vars[$x]["heading"]); ?>"
                                       data-description="<?php echo wp_strip_all_tags($vitamin_vars[$x]["description"]); ?>"
                                       data-nz-bar-value="<?php echo wp_strip_all_tags($vitamin_vars[$x]["nz_val"]); ?>"
                                       data-other-bar-value="<?php echo wp_strip_all_tags($vitamin_vars[$x]["comp_val"]); ?>"
                                       data-nz-pct-more="<?php echo wp_strip_all_tags($vitamin_vars[$x]["percentage"]); ?>"
                                    >
                                    <?php echo $vitamin_vars[$x]["vitamin_name"]; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        <?php endif; ?>
                    </ul>
                    <div class="vitamins__bubble">
                        <a href="#" class="close">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </a>

                        <h2 class="more visible-xs visible-sm"></h2>
                        <h2 class="heading hidden-xs hidden-sm"></h2>
                        <h3 class="heading visible-xs visible-sm"></h3>
                        <div><p class="description"></p></div>
                    </div>

                    <div class="btmBar">
                        <div class="bar-graph">
                            <!-- NuZest bar -->
                            <div class="barNuZest">
                                <div class="barDetails">
                                    <div class="percent"></div>
                                    <span class="moreOf"></span>
                                </div>
                            </div>
                            <!-- Competitor bar -->
                            <div class="barCompet"></div>

                            <div class="bubble-link-wrapper">
                                <a href="#" class="bubble-link">?</a>
                            </div>
                        </div>

                        <div class="logo">Nuzest</div>
												<p class="other-logo"><?php _e('Comparison Brands', 'nuzest-theme'); ?></p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

add_shortcode('vitamin_menu_skills_content', 'vitamin_menu_shortcode');


// Nested Element
function vc_vitamin_menu_shortcode()
{
    vc_map(
        array(
            'name' => __('GGS More Vitamins', 'custom_elements'),
            'base' => 'vitamin_menu_skills_content',
            'description' => __('GGS page – display more vitamins graph', 'custom_elements'),
            'category' => 'Nuzest Custom',
            'icon' => 'ggs-more-vitamins-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "param_group",
                    "heading" => __("Vitamins", "my-text-domain"),
                    "param_name" => "vitamins", // Important: Only one textarea_html param per content element allowed and it should have "content" as a "param_name"
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Vitamin Name',
                            'param_name' => 'vitamin_name',
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Heading',
                            'param_name' => 'heading',
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Description',
                            'param_name' => 'description',
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Val(%)',
                            'param_name' => 'nz_val',
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Comparison',
                            'param_name' => 'comp_val',
                        ),
                        array(
                            'type' => 'textfield',
                            'value' => '',
                            'heading' => 'Percentage',
                            'param_name' => 'percentage',
                        )
                    )
                ),
            ),
        )
    );
}

add_action('vc_before_init', 'vc_vitamin_menu_shortcode');

<?php

function register_theme_menus()
{
    register_nav_menus(
        array(
          'main-menu'   => __('Main Menu', 'nuzest-custom-admin'),
          'header-menu' => __('Header Menu', 'nuzest-custom-admin'),
          'footer-menu' => __('Footer Menu', 'nuzest-custom-admin'),
          'mobile-menu' => __('Mobile Menu', 'nuzest-custom-admin'),
          'social-menu' => __('Social Menu', 'nuzest-custom-admin')
        )
    );
}
add_action('init', 'register_theme_menus');

// Create Custom Post Types
function add_custom_post_types()
{
    require(get_template_directory() . '/inc/posttypes/recipes.php');
    require(get_template_directory() . '/inc/posttypes/faqs.php');
    require(get_template_directory() . '/inc/posttypes/stores.php');
    require(get_template_directory() . '/inc/posttypes/banners.php');
	require(get_template_directory() . '/inc/posttypes/testimonials.php');
	require(get_template_directory() . '/inc/posttypes/media.php');
}
add_action('init', 'add_custom_post_types');

// Create Custom Taxonomies
function add_custom_taxonomies()
{
    require(get_template_directory() . '/inc/taxonomies/dietary.php');
    require(get_template_directory() . '/inc/taxonomies/products.php');
    require(get_template_directory() . '/inc/taxonomies/meal_type.php');
    require(get_template_directory() . '/inc/taxonomies/role.php');
    require(get_template_directory() . '/inc/taxonomies/topics.php');
	require(get_template_directory() . '/inc/taxonomies/store_type.php');
}
add_action('init', 'add_custom_taxonomies', 0);

// Create ACF fields
function add_acf_fields()
{
    require(get_template_directory() . '/inc/fields/ing_panels.php');
	require(get_template_directory() . '/inc/fields/options_page.php');
	require(get_template_directory() . '/inc/fields/page_about.php');
    require(get_template_directory() . '/inc/fields/page_clp.php');
    require(get_template_directory() . '/inc/fields/page_ggs.php');
    require(get_template_directory() . '/inc/fields/page_home.php');
    require(get_template_directory() . '/inc/fields/page_kgs.php');
    require(get_template_directory() . '/inc/fields/page_products.php');
    require(get_template_directory() . '/inc/fields/post_banners.php');
    require(get_template_directory() . '/inc/fields/post_blog.php');
    require(get_template_directory() . '/inc/fields/post_faq.php');
    require(get_template_directory() . '/inc/fields/post_media.php');
    require(get_template_directory() . '/inc/fields/post_recipes.php');
    require(get_template_directory() . '/inc/fields/post_stores.php');
	require(get_template_directory() . '/inc/fields/post_testimonials.php');
    require(get_template_directory() . '/inc/fields/profile_info.php');
}
add_action('init', 'add_acf_fields', 0);

//Change base URL of authors pages
function change_author_permalinks() {
    global $wp_rewrite;
    $wp_rewrite->author_base = 'profiles';
    $wp_rewrite->author_structure = '/' . $wp_rewrite->author_base. '/%author%';
}
add_action('init','change_author_permalinks');
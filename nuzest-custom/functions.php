<?php

//load translations
load_theme_textdomain('nuzest-custom', get_template_directory() . '/languages');
load_theme_textdomain('nuzest-custom-admin', get_template_directory() . '/languages');

$tpl_dir = get_template_directory();

// Actions
require($tpl_dir . '/inc/actions/init.php');
require($tpl_dir . '/inc/actions/wp_enqueue_scripts.php');
require($tpl_dir . '/inc/actions/body_class.php');
require($tpl_dir . '/inc/actions/pre_get_posts.php');
require($tpl_dir . '/inc/actions/admin.php');

// Filters
require($tpl_dir . '/inc/filters/wp_nav_menu_items.php');
require($tpl_dir . '/inc/filters/pre_get_posts.php');
require($tpl_dir . '/inc/filters/user_contactmethods.php');

// Add theme support for modules
add_theme_support('menus');
add_theme_support('woocommerce');
add_theme_support('post-thumbnails');
add_theme_support('html5', array('search-form'));

// Widgets
require($tpl_dir . '/inc/widgets/setup-widgets.php');
require($tpl_dir . '/inc/widgets/social-widget.php');

// Misc Functions
require($tpl_dir . '/inc/functions/nz_numeric_pagination.php');
require($tpl_dir . '/inc/functions/nz_profile_helpers.php');
require($tpl_dir . '/inc/functions/register_ajax.php');
require($tpl_dir . '/inc/functions/options_page.php');
require($tpl_dir . '/inc/functions/ajax_get_profile.php');
require($tpl_dir . '/inc/functions/ajax_get_faqs.php');
require($tpl_dir . '/inc/functions/allow_svg_uploads.php');

//Woocommerce
require($tpl_dir . '/woocommerce/functions.php');


/* This Content Is A Custom Field For Order Customer Roles */
add_filter('manage_edit-shop_order_columns', 'add_column_heading', 20, 1);
add_action('manage_posts_custom_column', 'add_column_data', 20, 2);
//add_filter('manage_edit-shop_order_sortable_columns', 'add_sortable_column');
function shop_order_user_role_filter() {
    global $typenow, $wp_query;

    if (in_array($typenow, wc_get_order_types('order-meta-boxes'))) :
        $user_role = '';
        // Get all user roles
        $user_roles = array();
        foreach (get_editable_roles() as $key => $values) :
            $user_roles[$key] = $values['name'];
        endforeach;
        // Set a selected user role
        if (!empty($_GET['_user_role'])) {
            $user_role = sanitize_text_field($_GET['_user_role']);
        }
        // Display drop down
        ?><select name='_user_role'>
        <option value=''><?php _e('Select a user role', 'woocommerce'); ?></option><?php
        foreach ($user_roles as $key => $value) :
            ?>
            <option <?php selected($user_role, $key); ?> value='<?php echo $key; ?>'><?php echo $value; ?></option><?php
        endforeach;
        ?></select><?php
    endif;
}

function shop_order_user_role_posts_where($query) {
    if (!$query->is_main_query() || !isset($_GET['_user_role'])) {
        return;
    }
    $ids = get_users(array('role' => sanitize_text_field($_GET['_user_role']), 'fields' => 'ID'));
    $ids = array_map('absint', $ids);
    $query->set('meta_query', array(
        array(
            'key' => '_customer_user',
            'compare' => 'IN',
            'value' => $ids,
        )
    ));
    if (empty($ids)) {
        $query->set('posts_per_page', 0);
    }
}

function add_column_heading($array) {
    $res = array_slice($array, 0, 2, true) +
        array("customer_role" => "Customer Role") +
        array_slice($array, 2, count($array) - 1, true);

    if (array_key_exists('customer_role', $array)) {
        add_action('restrict_manage_posts', 'shop_order_user_role_filter');
        add_filter('pre_get_posts', 'shop_order_user_role_posts_where');
    }

    return $res;
}

function add_column_data($column_key, $order_id) {
    // exit early if this is not the column we want
    if ('customer_role' != $column_key) {
        return;
    }

    $customer = new WC_Order($order_id);
    if ($customer->user_id != '') {
        $user = new WP_User($customer->user_id);
        if (!empty($user->roles) && is_array($user->roles)) {
		echo implode(", ",$user->roles);
        }
    }
}

function add_sortable_column($columns) {
    $columns['customer_role'] = 'customer_role';

    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
    return $columns;
}
/* End of customer Role field */

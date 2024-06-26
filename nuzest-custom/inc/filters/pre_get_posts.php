<?php

// Make category and tag pages display custom post types
function namespace_add_custom_types($query)
{
    if (is_category() || is_tag() && empty($query->query_vars['suppress_filters'])) {
        $query->set('post_type', array(
          'post', 'nav_menu_item', 'recipes'
        ));
        return $query;
    }
}
add_filter('pre_get_posts', 'namespace_add_custom_types');

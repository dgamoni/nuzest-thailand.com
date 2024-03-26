<?php

// advanced search functionality
function advanced_search_query($query)
{
    if ($query -> is_search()) {
        if (isset($_GET['dietlist']) && is_array($_GET['dietlist'])) {
            $dietlist = $_GET['dietlist'];
            $dietarray = array(
              'taxonomy' => 'dietary',
              'field'    => 'slug',
              'terms'    => $dietlist
            );
            $taxquery = array( $dietarray );
        }
        if (isset($_GET['meallist']) && is_array($_GET['meallist'])) {
            $meallist = $_GET['meallist'];
            $mealarray = array(
              'taxonomy' => 'meal_type',
              'field'    => 'slug',
              'terms'    => $meallist
            );
            $taxquery = array( $mealarray );
        }
        if (isset($dietarray) && isset($mealarray)) {
            $taxquery = array(
              'relation' => 'AND',
              $dietarray,
              $mealarray,
            );
        }
        if (isset($tax_query)) {
          $query->set('tax_query', $taxquery);
        }
        return $query;
    }
}
add_action('pre_get_posts', 'advanced_search_query', 1000);

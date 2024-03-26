<?php
function display_testimonial($atts) {

	wp_enqueue_script('display_team', get_template_directory_uri() . '/js/display_team.js', array(), '3.7.3');
	
	wp_enqueue_style('owl.carousel', get_template_directory_uri() . '/css/owl-carousel/owl.carousel.css');
    wp_enqueue_style('owl.theme', get_template_directory_uri() . '/css/owl-carousel/owl.theme.css');
    wp_enqueue_style('owl.transitions', get_template_directory_uri() . '/css/owl-carousel/owl.transitions.css');
	wp_enqueue_script('owl.carousel', get_template_directory_uri() . '/js/owl-carousel/owl.carousel.js', array('jquery'), '1.5.0', true);
	
    extract(
        $arguments = shortcode_atts(
            array(
                'testimonial_type' => '',
                'testimonial_group' => '',
                'testimonials_count' => '',
                'display_order' => 'asc'
            ), $atts
        )
    );

    return get_testimonial_template($arguments);
}

add_filter( 'manage_edit-testimonials_columns', 'testimonialsMetaColumns' ) ;

function testimonialsMetaColumns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'featured_image' => __( 'Featured Image' ),
        'title' => __( 'Title' ),
        'exc' => __( 'Excerpt' ),
        'test_type' => __( 'Testimonial Type' ),
        'date' => __( 'Date' )
    );

    return $columns;
}

add_filter( 'manage_edit-testimonials_sortable_columns', 'testimonialsSortableColumns' );

function testimonialsSortableColumns( $columns ) {

    $columns['title'] = 'title';
    $columns['test_type'] = 'test_type';
    $columns['date'] = 'date';
    return $columns;
}

add_action( 'manage_testimonials_posts_custom_column', 'testimonialsManageColumns', 10, 2 );

function testimonialsManageColumns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        case 'featured_image' :

            printf(get_the_post_thumbnail( $post_id, array( 60, 60 ) ));

            break;

        case 'exc' :

            printf($post->post_excerpt);

            break;

        case 'test_type' :

            $test_type = wp_get_post_terms( $post_id, 'testimonial_taxonomy' );
            print_r($test_type[0]->name);

            break;

        /* Just break out of the switch statement for everything else. */
        default :
            break;
    }
}

function testimonial_orderby_test_type_clauses( $clauses, $wp_query ) {
    global $wpdb;

    if ( isset( $wp_query->query['orderby'] ) && 'test_type' == $wp_query->query['orderby'] ) {

        $clauses['join'] .= <<<SQL
LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;

        $clauses['where'] .= " AND (taxonomy = 'testimonial_taxonomy' OR taxonomy IS NULL)";
        $clauses['groupby'] = "object_id";
        $clauses['orderby']  = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
        $clauses['orderby'] .= ( 'ASC' == strtoupper( $wp_query->get('order') ) ) ? 'ASC' : 'DESC';
    }

    return $clauses;
}

add_filter( 'posts_clauses', 'testimonial_orderby_test_type_clauses', 10, 2 );


function get_testimonial_template($arguments) {

    $testimonial_type = $arguments['testimonial_type'];
    $testimonial_group = $arguments['testimonial_group'];

    $args = array(
        'post_type' => 'testimonials',
        'testimonial_taxonomy' => $testimonial_group,
        '&paged' => true,
    );

    if ($arguments['display_order'] == "rand") {
        $args['orderby'] = "rand";
    } else {
        $args['order'] = "ASC";
        $args['orderby'] = "date";
    }

    if ($arguments['testimonials_count']) {
      $args['posts_per_page'] = $arguments['testimonials_count'];
    }

    $custom_query = new WP_Query($args);

    $result = '';

    if ($testimonial_type == "third_divided") {

        $result = one_third_page_theme($custom_query);

    } elseif ($testimonial_type == "one_per_row") {

        $result = one_per_row_theme($custom_query);

    } elseif ($testimonial_type == "two_side_by_side") {

        $result = two_side_by_side_theme($custom_query,$arguments['contact_form_id']);

    }

    return $result;
}

function one_third_page_theme($custom_query) {

    $testimonials = $custom_query->posts;

    $home_page_result = '';

    $randomID = 'testimonial' . rand(1000, 2000);
    $home_page_result .= '<div id="' . $randomID . '" class="padd-30 owl-carousel testimonial-slide text-center one_third_page_testimonial_slide">';

    if ($testimonials) {
        $rownum = 0;

        foreach ($testimonials as $post) {
            $rownum++;

            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');

            $home_page_result .= '<div class="rsContent_testimonials">';

            $home_page_result .= '<div class="img-circle img-profile" style="background-image: url(' . $image[0] . '); backgroun" alt="' . $post->post_title . '"></div>
                        <h4>' . $post->post_title . '</h4>
                        <p class="byline">' . $post->post_excerpt . '</p>
                        <p class="testimonial-content">' . $post->post_content . '</p>
                    </div>';

        } // end while have_rows
    } // end if have_rows


    $home_page_result .= '</div>';

    $autoPlay = 'false';
    if ($rownum > 1) {
        $autoPlay = 5000;
    }
    $home_page_result .= '

    <script>
        jQuery(document).ready(function() {
            jQuery("#' . $randomID . '").owlCarousel({
              //autoPlay:' . $autoPlay . ',
              navigation : false,
			  dots: true,
              autoHeight:false,
              slideSpeed : 300,
              stopOnHover : true,
              paginationSpeed : 400,
              singleItem : true,
              transitionStyle:"fade",
			  items: 1,
			 margin:20,
			 nav:false,
			 loop:true,
			 autoplay:true
          });
        });
    </script>';

	//$home_page_result .= testimonial_css();

    return $home_page_result;

}


function one_per_row_theme($custom_query) {

    $about_page_result = '
        
		<div id="testimonial_slides" class="padd-60 owl-carousel">';
    $results = '';
    foreach ($custom_query->posts as $post) {

        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
        $results .= '<div class="item text-left">
                        <div class="testimonialContent">
                            <div class="user-profile">
								<div class="img-circle img-profile img-profile-sm"
									 style="background-image:url(' . $image[0] . ');"
									 alt="' . $post->post_title . '">
								</div>
								<h3>' . $post->post_title . '</h3>
								<h4 class="byline">' . $post->post_excerpt . '</h4>
								<p class="quote">' . $post->post_content . '</p>
                            </div>
                        </div>
                    </div>';
    }


    $about_page_result .= $results;
    $about_page_result .= '</div>';

    $about_page_result .= '<script>
		jQuery(document).ready(function ($) {
			$("#testimonial_slides").owlCarousel({
				loop:true,
				navigation : false,
				autoplay:true,
				stopOnHover : true,
				dots: false,
				items: 1,
			    margin:20,
			    nav:false,
			});
		});
		</script>
 	';
    $about_page_result .= testimonial_css();
	
    return $about_page_result;

}


function two_side_by_side_theme($custom_query,$contactFormId) {

    ob_start();
    ?>

    <section>
        <div class="container testimonials">

            <?php if ($custom_query->posts): ?>

                <div class="row padd-30">

                <?php
                foreach ($custom_query->posts as $row => $post):
                    $evenRow = $row % 2;
                    $pushClass = $evenRow ? 'col-md-push-3' : 'col-md-push-1';
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');

                    $test_quote = $post->post_content;
                    $trim_quote = wp_trim_words($test_quote, $num_words = 30, $more = '&hellip; ');
                    ?>
                    <div class="col-md-4 <?php echo $pushClass; ?> user-profile text-center">
                        <div class="img-circle img-profile" alt="<?php echo $post->post_title; ?>"
                             style="background-image: url('<?php echo $image[0]; ?>');"></div>
                        <h4><?php echo $post->post_title; ?></h4>
                        <p class="byline"><?php echo $post->post_excerpt; ?></p>
                        <ul class="list-unstyled quick-list">
                            <li class="">
                                <blockquote class="short-content blockquote-sm"><?php echo $trim_quote; ?></blockquote>
                                <div class="detail">
                                    <blockquote class="blockquote-sm"><?php echo $post->post_content; ?></blockquote>
                                </div>
                                <p class="quick-arrow"></p>
                            </li>
                        </ul>
                    </div><!-- end col -->

                    <?php
                    if ($evenRow):
                        ?>
                        </div>
                        <div class="row padd-30">
                        <?php
                    endif;
                endforeach;
                ?>

                </div><!-- end row -->

            <?php else: ?>

                <div class="row padd-30">
                    <div class="col-md-12">
                        <?php echo __('No testimonials found', 'nuzest-theme'); ?>
                    </div>
                </div>

            <?php endif ?>

        </div>
    </section>

   
    <?php
    return ob_get_clean();
}


function testimonial_css() {

    return '
        <style>

        </style>
		<script>
			/*jQuery(document).ready(function ($) {
			$(".owl-carousel").owlCarousel({
			 items: 1,
			 margin:20,
			 nav:false,
			 loop:true,
			 autoplay:true
			});
			});*/
		</script>
        ';
}

function get_page_slug() {

    global $wp_query;
    $post_id = $wp_query->post->ID;

    $wp_post = get_post($post_id);
    return $wp_post->post_name;

}

add_shortcode('testimonial', 'display_testimonial');


// Nested Element
function testimonial_shortcode_vc() {

    $testimonial_taxonomies = get_terms("testimonial_taxonomy");

	$testimonial_groups = array('All' => '');

    foreach ($testimonial_taxonomies as $testimonial_taxonomy) {
        $testimonial_groups[$testimonial_taxonomy->name] = $testimonial_taxonomy->slug;
    }

    vc_map(
        array(
            'name' => __('Testimonials', 'custom_elements'),
            'base' => 'testimonial',
            'description' => __('Display testimonial posts', 'custom_elements'),
            "category" => 'Nuzest Custom',
            'icon' => 'testimonials-vc-icon',
            'content_element' => true,
            'admin_enqueue_js' => array(get_template_directory_uri() . '/js/testimonials/testimonials_admin.js'),
            'params' => array(
                array(
                    "type" => "dropdown",
                    "heading" => __("Testimonial Type", 'custom_elements'),
                    "param_name" => "testimonial_type",
                    "value" => array(
                        'Select Option' => '',
                        'Small slider' => 'third_divided',
                        'Full width slider' => 'one_per_row',
                        'Two column display' => 'two_side_by_side',
                    ),
                    'holder' => 'div'
                ),
                /*array(
                    "type" => "textfield",
                    "heading" => __("Testimonial Form: Contact Form 7 ID", 'custom_elements'),
                    "param_name" => "contact_form_id",
                    "edit_field_class" => "vc_edit_form_elements vc_column vc_column vc_col-xs-12 contact_form_id_holder"
                ),*/
                array(
                    "type" => "dropdown",
                    "heading" => __("Testimonial Group", 'custom_elements'),
                    "param_name" => "testimonial_group",
                    "value" => $testimonial_groups,
                    'holder' => 'div'
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Number of Testimonials to Display", 'custom_elements'),
                    "param_name" => "testimonials_count"
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Display Order", 'custom_elements'),
                    "param_name" => "display_order",
                    "value" => array(
                        'Recently Added' => 'asc',
                        'Random' => 'rand',
                    )
                ),
            ),
        )
    );

//    add_action( 'admin_enqueue_scripts', 'my_enqueue' );
}


add_action('vc_before_init', 'testimonial_shortcode_vc');

//function my_enqueue($hook) {
//    wp_enqueue_script( 'my_custom_script', get_template_directory_uri() . '/js/testimonials/testimonials_admin.js' );
//}

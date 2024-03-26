<?php

/**
 * The Shortcode
 */
function post_snippet_content_shortcode($atts) 
{
    extract(
        $attributes = shortcode_atts(
            array(
                'snippet_title' 			=>  __('Recent Posts'),
                'snippet_description' => __('Check out all the latest articles and recipes to keep you healthy and motivated!'),
                'snippet_type' 				=> '',
                'post_category' 			=> '',
                'meal_type' 					=> '',
                'dietary' 						=> '',
                'product_cat' 				=> '',
            ), $atts
        )
    );

    $postType = $attributes['snippet_type'] ? $attributes['snippet_type'] : array("post", "recipes");

    $search = array(
        'post_type' 			=> $postType,
        'post_status' 		=> 'publish',
        'posts_per_page' 	=> 4,
        'orderby' 				=> 'date',
        'order' 					=> 'DESC',
        'meta_query' 			=> array()
    );

    $tax_query = array('relation' => 'AND');

    if($postType == 'post'){
        if ($attributes['post_category']) {
            $tax_query[] = array('relation' => 'AND',
                array(
                    'taxonomy' 	=> 'category',
                    'field' 		=> 'slug',
                    'terms' 		=> $attributes['post_category'],
                )
            );
        }
    }

    if($postType == 'recipes'){
        if ($attributes['meal_type']) {
            $tax_query[] = array('relation' => 'AND',
                array(
                    'taxonomy' 	=> 'meal_type',
                    'field' 		=> 'slug',
                    'terms' 		=> $attributes['meal_type'],
                )
            );
        }

        if ($attributes['dietary']) {
            $tax_query[] = array('relation' => 'AND',
                array(
                    'taxonomy' 	=> 'dietary',
                    'field' 		=> 'slug',
                    'terms' 		=> $attributes['dietary'],
                )
            );
        }
    }

    if ($attributes['product_cat']) {
        $tax_query[] = array('relation' => 'AND',
            array(
                'taxonomy' 	=> 'product_cat',
                'field' 		=> 'slug',
                'terms' 		=> $attributes['product_cat'],
            )
        );
    }

    $search['tax_query'] = $tax_query;
    $search['suppress_filters'] = 0;

    $posts = get_posts($search);

    outputPostSnippet($attributes, $posts);

}

function outputPostSnippet($attributes, $posts) 
{
	
    ob_start();
    ?>

    <section class="snippets container posts_snippets">
		
            <div class="row section-header text-center">
                <div class="col-md-12">
                    <h1><?= $attributes['snippet_title'] ?></h1>
                    <span><?= $attributes['snippet_description'] ?></span>
                </div>
            </div>

            <div class="row">
                <?php 
					global $i; $i = 1;
					foreach ($posts as $post) {
						outputPost($post);
						$i++;
                	} 
				?>
            </div>
    </section>

    <?php
    echo ob_get_clean();
}



function outputPost($post) {
    global $wpdb;
	
    $title = get_the_title($post->ID);
	$permalink = get_permalink($post->ID);
	$desc = get_the_excerpt($post->ID);
	$img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium', true );
    $avatarUrl = nuzest_avatar( $post->post_author );
	
	
    ob_start();
		global $i;
    ?>
    
    <div class="col-sm-6 col-md-4 col-lg-3 <?php if( $i==4 ){ echo( 'hidden-md' ); } ?>">
        <article class="snippet <?php echo $post->post_type; ?>-snippet">
            <a href="<?= $permalink ?>" title="<?= $title ?>" class="snippet-image">
        		<img width="100%" src="<?= $img[0] ?>" alt="<?= $title ?>">
        	</a>

          	
           	<!-- RECIPE POSTS -->
            <?php if ($post->post_type == 'recipes'): $terms = get_the_terms($post->ID, 'dietary'); ?>

                <div class="recipe-tags clearfix">
                    <?php if (is_array($terms)): ?>
                        <?php foreach (array_slice($terms, 0, 3) as $term) : ?>
                            <p class="snip-tag"><span><?= $term->name ?></span></p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

          
           <!-- BLOG POSTS -->
            <?php elseif ($post->post_type == 'post'): ?>

                <div class="author-info">
                    <?php
                    $author_name = get_the_author_meta('display_name', $post->post_author);
                    $author_description = get_the_author_meta('description', $post->post_author);

                    $author_id = $post->post_author;
                    $has_profile = get_field('has_profile', 'user_'.$author_id);
                    $has_profile_object = get_field('profile_link', 'user_'.$author_id);

                    if($has_profile) {
                        $author_description = get_the_excerpt($has_profile_object->ID);
                        $avatarUrl = get_the_post_thumbnail($has_profile_object->ID);
                        $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $has_profile_object->ID ), "thumbnail" );

                        if(isset($thumbnail[0]))
                            $avatarUrl = $thumbnail[0];
                    }
                    ?>

                    <div class="img-circle img-profile" alt="<?=$author_name; ?>"
                        <?php if ($avatarUrl) { echo 'style="background-image: url(' . $avatarUrl . ')"';} ?>
                    >
                        <a href="<?php echo get_author_posts_url( get_the_author_meta('ID', $post->post_author) ); ?>"
                           class="blockLink">
                        </a>
                    </div>
                    <p class="authName"><?=$author_name; ?></p>
                    <p class="authByline hidden-xs hidden-sm"><?=$author_description;?></p>
                </div><!-- .author-info -->

            <?php endif; ?>

            <div class="info">
				<h5 class="title">
					<a target="_self" href="<?= $permalink ?>" onclick="location.reload()">
						<?= $title ?>
					</a>
				</h5>
				<p class="hidden-xs hidden-sm">
					<?= wp_trim_words($desc, 24); ?>
				</p>
			
			<a class="text-link" target="_self" href="<?= $permalink ?>" onclick="location.reload()">
				<?php _e('View More', 'nuzest-theme') ?>
			</a>
       		</div>
        </article><!-- .snippet -->
    </div><!-- .col-sm-6.col-md-4.col-lg-3 -->
    
    <?php
    echo ob_get_clean();
}

add_shortcode('post_snippet', 'post_snippet_content_shortcode');



function post_snippet_content_shortcode_vc() {

    $dietaryValues = [__('Select')=>''];
    $dietaryTerms = get_terms( 'dietary', array(
        'orderby'    => 'count',
        'hide_empty' => 0
    ));

    foreach ($dietaryTerms as $dietaryTerm){
        $dietaryValues[$dietaryTerm->name] = $dietaryTerm->slug;
    }


    $mealTypeValues = [__('Select')=>''];
    $mealTypeTerms = get_terms( 'meal_type', array(
        'orderby'    => 'count',
        'hide_empty' => 0
    ));

    foreach ($mealTypeTerms as $mealTypeTerm){
        $mealTypeValues[$mealTypeTerm->name] = $mealTypeTerm->slug;
    }

    $postCategoryValues = [__('Select')=>''];
    $postCategoryTerms = get_terms( 'category', array(
        'orderby'    => 'count',
        'hide_empty' => 0
    ));

    foreach ($postCategoryTerms as $postCategoryTerm){
        $postCategoryValues[$postCategoryTerm->name] = $postCategoryTerm->slug;
    }

    $productCategoryValues = [__('Select')=>''];
    $productCategoryTerms = get_terms( 'product_cat', array(
        'orderby'    => 'count',
        'hide_empty' => 0
    ));

    foreach ($productCategoryTerms as $productCategoryTerm){
        $productCategoryValues[$productCategoryTerm->name] = $productCategoryTerm->slug;
    }


    vc_map(
        array(
            'name' => __('Post Snippets', 'custom_elements'),
            'base' => 'post_snippet',
            'description' => __('Display related Blog and Recipe snippets', 'custom_elements'),
            'admin_enqueue_js' => array(get_template_directory_uri() . '/js/admin/custom/post_snippet.js'),
            'category' => 'Nuzest Custom',
            'icon' => 'post-snippets-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "textfield",
                    "heading" => __("Title", 'custom_elements'),
                    "param_name" => "snippet_title",
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Description", 'custom_elements'),
                    "param_name" => "snippet_description",
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Type", 'custom_elements'),
                    "param_name" => "snippet_type",
                    "value" => [__('Posts and Recipes') => '', __('Posts') => 'post', __('Recipes') => 'recipes'],
                    'holder' => 'div'
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Category", 'custom_elements'),
                    "param_name" => "post_category",
                    "value" => $postCategoryValues,
                    'holder' => 'div',
                    "edit_field_class" => "vc_edit_form_elements vc_column vc_column vc_col-xs-12 post_category_holder category_holder hidden"
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Meal Type", 'custom_elements'),
                    "param_name" => "meal_type",
                    "value" => $mealTypeValues,
                    'holder' => 'div',
                    "edit_field_class" => "vc_edit_form_elements vc_column vc_column vc_col-xs-12 recipes_category_holder category_holder hidden"
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Dietary Type", 'custom_elements'),
                    "param_name" => "dietary",
                    "value" => $dietaryValues,
                    'holder' => 'div',
                    "edit_field_class" => "vc_edit_form_elements vc_column vc_column vc_col-xs-12 recipes_category_holder category_holder hidden"
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Associated With", 'custom_elements'),
                    "param_name" => "product_cat",
                    "value" => $productCategoryValues,
                    'holder' => 'div'
                )
            ),
        )
    );

}

add_action('vc_before_init', 'post_snippet_content_shortcode_vc');



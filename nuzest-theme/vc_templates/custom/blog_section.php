<?php


add_filter( 'manage_edit-post_columns', 'postMetaColumns' ) ;

function postMetaColumns( $columns ) {

    $columns = array(
        'cb' => '<input type="checkbox" />',
        'featured_image' => __( 'Featured Image' ),
        'title' => __( 'Title' ),
        'author' => __( 'Author' ),
        'product_cat' => __( 'Product Category' ),
		'category' => __( 'Category' ),
        'date' => __( 'Date' )
    );

    return $columns;
}

add_filter( 'manage_edit-post_sortable_columns', 'postSortableColumns' );

function postSortableColumns( $columns ) {

    $columns['title'] = 'title';
    $columns['author'] = 'author';
    $columns['product_cat'] = 'product_cat';
	$columns['category'] = 'category';
    $columns['date'] = 'date';
    return $columns;
}

add_action( 'manage_post_posts_custom_column', 'postManageColumns', 10, 2 );

function postManageColumns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        case 'featured_image' :

            printf(get_the_post_thumbnail( $post_id, array( 60, 60 ) ));

            break;

        case 'product_cat' :

            $product_cat = wp_get_post_terms( $post_id, 'product_cat' );
            print_r($product_cat[0]->name);

            break;

		case 'category' :

            $category = wp_get_post_terms( $post_id, 'category' );
            print_r($category[0]->name);

            break;
        /* Just break out of the switch statement for everything else. */
        default :
            break;
    }
}

function display_blog_filter_options($slug)
{

    if ($slug == 'category') {
        $terms = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => false,
            'order' => 'ASC',
        ));

        foreach ($terms as $term):

            ?>
            <li>
            <span class="checkbox">
                <input type="checkbox" data-taxonomy-type="<?= $slug ?>" name="<?= $slug ?>"
                       id="<?= $term->slug ?>" value="<?= $term->slug ?>">
                <label for="<?= $term->slug ?>"><?= $term->name ?></label>
            </span>
            </li>
            <?php
        endforeach;
    } else {
        $args = array(
            'role' => 'author',
            'order' => 'ASC',
        );
        $terms = get_users($args);
        foreach ($terms as $term):

            ?>
            <li>
            <span class="checkbox">
                <input type="checkbox" data-taxonomy-type="<?= $slug ?>" name="<?= $slug ?>"
                       id="<?= $term->ID ?>" value="<?= $term->ID ?>">
                <label for="<?= $term->ID ?>"><?= $term->display_name ?></label>
            </span>
            </li>
            <?php
        endforeach;
    }
}

function display_blog_block($atts)
{
	extract(
        $attributes = shortcode_atts(
            array(
				'per_page' => '',
				'pagination_infinite' => '',
				'categories' => '',
				'clear_all_btn' => '',
				'button_text' => '',
            ), $atts
        )
    );
	$posts = $attributes['per_page'];
	$categories = $attributes['categories'];
	$clear_all_btn = $attributes['clear_all_btn'];
	$button_text = $attributes['button_text'];
	if(empty($button_text)){
		$button_text = "Reset All";
	}
	wp_enqueue_script('blog_js', get_template_directory_uri() . '/js/blog.jquery.js', array('jquery'), '', true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('blog.jquery.search', get_template_directory_uri() . '/js/blog.jquery.js', array(), '1.0.0', true);
    wp_localize_script('blog.jquery.search', 'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php') . '?action=search_blog'
        )
    );

    if ($banner == '0')
      displayFeaturedPostsSlider();

    ob_start();
    ?>

	<div id="posts_num" style="display: none"><?php echo $posts; ?></div>
    <section class="overflow-visible" id="blog">
        <div class="container">
            <div class="row margin-bottom-md blog-search-inputs">
                <style>
                    .filter-controller h3 {
                        width: 100%;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }
                </style>
                <input type="hidden" value="<?php print_r(get_permalink()); ?>" class="permalink-value">

                <div class="col-md-3">
                    <div class="filter-controller activeToggle">
                        <h3><?php echo __('Author'); ?>: 
                            <span id="selected-author"
                             data-default-text="<?php _e('All', 'nuzest-theme'); ?>"><?php _e('All', 'nuzest-theme'); ?>
                             </span>
                        </h3>
                        <ul>
                            <?php display_blog_filter_options('author'); ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-controller activeToggle">
                        <h3><?php echo __('Category'); ?>: 
                        	<span id="selected-category"
                            data-default-text="<?php _e('All', 'nuzest-theme'); ?>"><?php _e('All', 'nuzest-theme'); ?>
                            </span>
                        </h3>
                            <ul>
                            <?php //display_recipe_filter_options('product_cat'); 
								$terms = get_terms(array(
								'taxonomy' => 'category',
								'hide_empty' => false,
								'order' => 'ASC',
							));
							$categories_arr = explode(',', $categories);
							foreach ($terms as $term):
							foreach ($categories_arr as $value){
								if($term->slug == $value){
							?>
								
								<li>
									<span class="checkbox">
										<input type="checkbox" data-taxonomy-type="category" name="category"
											   id="<?= $term->slug ?>" value="<?= $term->slug ?>">
										<label for="<?= $term->slug ?>"><?= $term->name ?></label>
									</span>
								</li>

								<?php
								}
							}
							endforeach;
								?>
                        </ul>
                    </div>
                </div>
                <!--<div class="col-md-3">
                    <div class="filter-controller activeToggle">
                        <h3>
                            <?php echo __('Date'); ?>: <span id="selected-order"
                                                             data-default-text="<?php echo __('DESC'); ?>"><?php echo __('Descending'); ?></span>
                        </h3>
                        <ul>
                            <li>
							<span class="radio">
								<input class="" name="order" id="order_asc" value="ASC" type="radio">
								<label for="order_asc"><?php echo __('Ascending'); ?></label>
							</span>
                            </li>
                            <li>
							<span class="radio">
								<input class="" name="order" id="order_desc" value="DESC" type="radio" checked>
								<label for="order_desc"><?php echo __('Descending'); ?></label>
							</span>
                            </li>
                        </ul>
                    </div>

                </div>-->

                <div class="col-xs-10 col-md-5">
                    <div class="field-icon">
                        <input maxlength="150" type="text" class="txt" placeholder="<?php _e('Search', 'nuzest-theme'); ?>">

                        <button id="searchsubmit" class="btn">
                            <span class="fa fa-spinner fa-spin" id="loadingProgress"></span>
                            <span class="glyphicon glyphicon-search" id="searchIcon"></span>
                        </button>
                    </div>
                </div>
                
                <div class="col-xs-2 col-md-1">
            <?php if(!empty($clear_all_btn)){ ?>
						<a class="btn btn-primary glyphicon glyphicon-refresh" id="clear_fields" target="_self" value=""  title="<?php _e('Clear filters', 'nuzest-theme'); ?>" onClick="window.location.reload()" style="min-width: 80px; color:#666 !important; float: right;"></a>
					<?php } ?>
			</div>
            </div>
            

            <div id="blog-load-area">
                <div id="loadingContent">
                    <div class="col-xs-12 text-center">
                        <h3>
                            <span class="fa fa-spinner fa-spin col-xs-12 text-center" id="loadingProcessContent"></span>
                        </h3>
                    </div>

                    <div class="col-xs-12 text-center"><h3><?= __('Loading') ?></h3></div>
                </div>
				<?php if($attributes['pagination_infinite'] == "pagination_style"){ ?>
                <div class="uninfinite_scroll content row">
                  <?php
                    do_action('execute_blog_search', $posts, true );
                  ?>
                </div>
				
				<?php
					}
					else{
				?>
				
				<div class="infinite_scroll content row">
					<div class="scrollContent">	
						<section class="dynamicContent">
							<div id="content">
								  <?php
									do_action('execute_blog_search', $posts, true );
								  ?>
								<div id="loader" class="">
									<img src="<?php echo get_template_directory_uri();?>/images/ring.svg" width="40">
									<?php _e('Loading ...', 'nuzest-theme'); ?>
								</div>
								
					<script>
						// init controller
						var controller = new ScrollMagic.Controller();

						// build scene
						var scene = new ScrollMagic.Scene({triggerElement: ".dynamicContent #loader", triggerHook: "onEnter"})
										.addTo(controller)
										.on("enter", function (e) {
											if (!$("#loader").hasClass("active")) {
												$("#loader").addClass("active");
												// simulate ajax call to add content using the function below
												setTimeout(addBoxes, 1000, 9);
											}
										});

						// pseudo function to add new content. In real life it would be done through an ajax request.
						var pagenum = 2;
						var searchParams = {
								keyword: "",
								perpage: "8",
								taxonomies: {}
							};
						function addBoxes () {
								searchParams.page = pagenum;
								//$("<div>" + searchParams.page + "</div>").appendTo(".snippets");
								$('#searchIcon').hide();
								$('#loadingProgress').show();
								$('#loadingContent').show();

								var ajax_url = document.location.origin + "/wp-admin/admin-ajax.php?action=search_blog";
								$.post(ajax_url, searchParams).success(function (result) {
									$(result).appendTo(".snippets:last");
									//applySnippetHeights();
								}).always(function () {
									$('#searchIcon').show();
									$('#loadingProgress').hide();
									$('#loadingContent').hide();
								});
								pagenum ++;
							// "loading" done -> revert to normal state
							scene.update(); // make sure the scene gets the new start position
							$("#loader").removeClass("active");
						}

						// add some boxes to start with.
						addBoxes();
					</script>
						</section>
					</div>
                </div>
				
				<?php
					}
				?>
				
				
            </div>
        </div>
    </section>
		<div class="text-center no_results" id="no_results"><h2><?php echo __('Sorry, no results found.'); ?></h2></div>
    <?php
}

function display_blog_taxonomy_tag($slug, $displayName, $post = null)
{
    $post = get_post($post);

    if ((!function_exists('icl_object_id') && has_term($slug, 'blog_taxonomy', $post)) || (function_exists('icl_object_id') && has_term(icl_object_id( get_term_by('slug', $slug, 'blog_taxonomy')->term_id, 'blog_taxonomy', true), 'blog_taxonomy', $post))) {
        echo '<p class="snip-tag"><span>' . $displayName . '</span></p>';
    }
}

function display_blog_search_results( $post, $flag = false)
{	
	if (!empty($_POST['perpage'])){
		$post = $_POST['perpage'];
	}
    $search = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $post,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $search['s'] = $_POST['keyword'];
    }

    if (isset($_POST['order']) && !empty($_POST['order'])) {
//        $search['orderby'] = 'date';
        $search['order'] = $_POST['order'];
    }

    if (isset($_POST['author']) && !empty($_POST['author'])) {
        $search['post_author'] = $_POST['author'];
    }

    if (isset($_POST['taxonomies']) && is_array($_POST['taxonomies'])) {

        if (isset($_POST['taxonomies']['author']) && is_array($_POST['taxonomies']['author'])) {
            $search['author__in'] = $_POST['taxonomies']['author'];
        }

        if (isset($_POST['taxonomies']['category']) && is_array($_POST['taxonomies']['category'])) {
            $tax_query = array('relation' => 'AND');
            $tax_query[] = array('relation' => 'AND',
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $_POST['taxonomies']['category'],
                )
            );
            $search['tax_query'] = $tax_query;
        }
    }

    if (isset($_POST['page'])) {
        $search['paged'] = $_POST['page'];
    }

    $query = new WP_Query($search);


//    print_r($query);
    ?>
    <div class="snippets">
        <div class="container-fluid">
            <div class="row">
                <?php if ($query->have_posts()): ?>
                    <?php while ($query->have_posts()):
//                        print_r($query->the_post());
                        $query->the_post();

						$title = get_the_title($post->ID);
						$permalink = get_permalink($post->ID);
						$img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium', true );
						$desc = get_the_excerpt();
                        $avatarUrl = nuzest_avatar( get_the_author_meta('ID') );
                        ?>
                        <div class="col-sm-6 col-md-3 col-lg-3 blog">

                            <article class="snippet active">
                                <a target="_self" href="<?= $permalink ?>" title="<?= $title ?>"
                                   class="snippet-image" onclick="location.reload()">
									<?php
										if (strpos($thumb_url, 'default.png') !== false) {
											$thumb_url = get_template_directory_uri().'/images/default.jpg';
										}
									?>
									
                                    <img  width="100%" src="<?= $img[0] ?>" alt="<?= $title ?>">
                                </a>

                                <?php
                                set_query_var( 'avatarUrl', $avatarUrl);
                                ?>
								<div class="author-info">
									<?php

									$author_name = get_the_author_meta('display_name');
									$author_description = get_the_author_meta('description');

									$user_id = get_the_author_meta('ID');

									$has_profile = get_field('has_profile', 'user_'.$user_id);
									$has_profile_object = get_field('profile_link', 'user_'.$user_id);

									if($has_profile) {

										$author_description = get_the_excerpt($has_profile_object->ID);
										$avatarUrl = get_the_post_thumbnail($has_profile_object->ID);
										$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $has_profile_object->ID ), "thumbnail" );

										if(isset($thumbnail[0]))
											$avatarUrl = $thumbnail[0];
									}
									?>

									<div class="img-circle img-profile" alt="<?=$author_name; ?>"
										<?php if ($avatarUrl) {
											echo 'style="background-image: url(' . $avatarUrl . ')"';
										} ?>
									>
										<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"
										   class="blockLink"></a>
									</div>
									<p class="authName"><?=$author_name; ?></p>
									<p class="authByline hidden-xs hidden-sm"><?=$author_description;?></p>
								</div>

                                <div class="blog-tags clearfix">
                                    <?php display_blog_taxonomy_tag('dairy-free', 'Dairy Free'); ?>
                                    <?php display_blog_taxonomy_tag('gluten-free', 'Gluten Free'); ?>
                                    <?php display_blog_taxonomy_tag('vegan', 'Vegan'); ?>
                                    <?php display_blog_taxonomy_tag('sugar-free', 'Sugar Free'); ?>
                                </div>

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
                            </article>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div id="end_results"> </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
	<div class="row row-pagination">
        <div class="pagination">
            <?php
            echo paginate_links(array(
                'base' => '%_%',
                'format' => '?paged=%#%',
                'current' => max(1, @$_POST['page']),
                'total' => $query->max_num_pages,
                'type' => 'list'
            ));
            ?>
        </div>
    </div>
	<script>
		if ($('.scrollContent').length > 0){
			$('.pagination').css('display','none');
		}
		if($("#end_results").length > 0){
			$("#loader").css('display','none');
			$("#no_results").css("display", "block");
		}
		$(".filter-controller ul li").each(function(){
            if($(this).find(".checkbox input").prop('checked')){
				$("#blog-load-area > .infinite_scroll > .snippets > .snippets").css("display", "none");
				$("#blog-load-area > .infinite_scroll > .snippets > .row-pagination").css("display", "none");
				
			}
        });
		if($(".blog-search-inputs input.txt").val()){
			$("#blog-load-area > .infinite_scroll > .snippets > .snippets").css("display", "none");
			$("#blog-load-area > .infinite_scroll > .snippets > .row-pagination").css("display", "none");
		}
	</script>
    <?php

    //if (!$flag)
    //  die();
}

function blog_page_shortcode_vc()
{
	$categories_array = array();
    $categories = get_categories(array('taxonomy' => 'category',));
    foreach( $categories as $category ) {
        $categories_array[$category->name] = $category->slug;
    }
  vc_map(
    array(
      'name' => __('Blog Section', 'custom_elements'),
      'base' => 'blog_page',
      'description' => __('Blog page - display sortable list', 'custom_elements'),
      'category' => 'Nuzest Custom',
      'icon' => 'blog-section-vc-icon',
		'content_element' => true,
			'params' => array(
					array(
					  'type'        => 'dropdown',
					  'heading'     => __('Recipes show on the page', 'custom_elements'),
					  'param_name'  => 'per_page',
					  //'admin_label' => true,
					  'value'       => array(
						'12'   => 12,
						'16'   => 16,
						'20'   => 20,
						'24'   => 24
					  ),
						'std'         => '12', // Your default value
					  'description' => __('Control how many posts showing on one page')
					  ),
					array(
					  'type'        => 'dropdown',
					  'heading'     => __('Pagination / Infinite scroll'),
					  'param_name'  => 'pagination_infinite',
					  //'admin_label' => true,
					  'value'       => array(
						"Pagination"   => "pagination_style",
						"Infinite scroll"   => "infinite_style"
					  ),
						'std'         => 'pagination style', // Your default value
					  'description' => __('The description')
					  ),
					array(
					  "type" => "checkbox",
					  "heading" => __( "Products", "nuzest-theme" ),
					  "param_name" => "categories",
					  "value" => $categories_array,
					  "description" => __( "Choose which products are showing on the filter bar", "nuzest-theme" )
					),
					array(
					  "type"        => 'checkbox',
					  "heading" => __( "Clear button", "nuzest-theme" ),
					  "param_name" => "clear_all_btn",
					  "description" => __( "Show or hide the clear all button", "nuzest-theme" )
					)
			)
    )
  );
}

add_shortcode('blog_page', 'display_blog_block');
add_action('vc_before_init', 'blog_page_shortcode_vc');
add_action('execute_blog_search', 'display_blog_search_results');
add_action('wp_ajax_search_blog', 'display_blog_search_results');
add_action('wp_ajax_nopriv_search_blog', 'display_blog_search_results');
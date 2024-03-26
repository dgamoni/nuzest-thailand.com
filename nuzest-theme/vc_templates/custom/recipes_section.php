<?php

// Display the filters
function display_recipe_filter_options($taxonomy) {
	
    $terms = get_terms(array(
        'taxonomy' => $taxonomy,
        'hide_empty' => false,
        'order' => 'ASC',
    ));
    foreach ($terms as $term):
    ?>
	
        <li>
            <span class="checkbox">
                <input type="checkbox" data-taxonomy-type="<?= $taxonomy ?>" name="<?= $taxonomy ?>"
                       id="<?= $term->slug ?>" value="<?= $term->slug ?>">
                <label for="<?= $term->slug ?>"><?= $term->name ?></label>
            </span>
        </li>

        <?php
    endforeach;
}

function display_recipe_block($atts) {

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
	
    ob_start();
	 wp_enqueue_script('recipes_js', get_template_directory_uri() . '/js/recipes.jquery.js', array('jquery'), '', true);
	 wp_register_script('recipes.jquery.search', get_template_directory_uri() . '/js/recipes.jquery.js', array(), '1.0.0', true);
     wp_enqueue_script('recipes.jquery.search');
     wp_localize_script('recipes.jquery.search', 'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php') . '?action=search_recipes'
        )
     );

    ?>

	<div id="posts_num" style="display: none"><?php echo $posts; ?></div>
    <section class="overflow-visible" id="recipe">
        <div class="container">
            <div class="row margin-bottom-md recipe-search-inputs">
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
                        <h3><?php _e('Meal Type', 'nuzest-theme'); ?>: 
													<span id="selected-meal_type" data-default-text="<?php echo __('All'); ?>">
														<?php echo __('All'); ?>
													</span>
                        </h3>
                        <ul>
                            <?php display_recipe_filter_options('meal_type'); ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="filter-controller activeToggle">
                        <h3><?php _e('Product Type', 'nuzest-theme'); ?>: 
                        	<span id="selected-product_cat" data-default-text="<?php echo __('All'); ?>">
                        		<?php echo __('All'); ?>
                        	</span>
                        </h3>
                        <ul>
                            <?php //display_recipe_filter_options('product_cat'); 
								$terms = get_terms(array(
								'taxonomy' => 'product_cat',
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
										<input type="checkbox" data-taxonomy-type="product_cat" name="product_cat"
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
                        <h3><?php _e('Diet Type', 'nuzest-theme'); ?>: 
                        	<span id="selected-dietary" data-default-text="<?php echo __('All'); ?>">
                          	<?php echo __('All'); ?>
                          </span>
                        </h3>
                        <ul>
                            <?php display_recipe_filter_options('dietary'); ?>
                        </ul>
                    </div>

                </div>-->
				<div class="col-xs-10 col-md-5">
                    <div class="field-icon" style="padding:0;">
                        <input maxlength="150" type="text" class="txt" placeholder="<?php _e('Search', 'nuzest-theme'); ?>">

                        <button id="searchsubmit" class="btn">
                            <span class="fa fa-spinner fa-spin" id="loadingProgress"></span>
                            <span class="glyphicon glyphicon-search" id="searchIcon"></span>
                        </button>
					
                    </div>
                </div>
                <div class="col-xs-2 col-md-1">
                <?php if(!empty($clear_all_btn)){ ?>
				
						<a class="btn btn-primary glyphicon glyphicon-refresh" id="clear_fields" target="_self" value="" title="<?php _e('Clear filters', 'nuzest-theme'); ?>" onClick="window.location.reload()" style="min-width: 40px; color:#666 !important; float: right;"></a>
					<?php } ?>
				</div>
            </div>

            <div id="recipe-load-area">
                <div id="loadingContent">
                    <div class="col-xs-12 text-center">
                        <h3>
                            <span class="fa fa-spinner fa-spin col-xs-12 text-center" id="loadingProcessContent"></span>
                        </h3>
                    </div>
                    <div class="col-xs-12 text-center"><h3><?= __('Loading') ?></h3></div>
                </div>
				<?php if($attributes['pagination_infinite'] == "pagination_style"){
					?>
				<div class="uninfinite_scroll content row">
					<?php
						do_action('execute_recipe_search', $posts, true );
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
									do_action('execute_recipe_search', $posts, true );
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
								var ajax_url = document.location.origin + "/wp-admin/admin-ajax.php?action=search_recipes";
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


function display_recipe_taxonomy_tag( $slug, $displayName, $recipe = null ) {
    $recipe = get_post($recipe);

    if (has_term($slug, 'recipe_taxonomy', $recipe)) {
        echo '<p class="snip-tag"><span>' . $displayName . '</span></p>';
    }
}

function display_recipe_search_results( $post, $flag = false) {
	
	if (!empty($_POST['perpage'])){
		$post = $_POST['perpage'];
	}
    $search = array(
        'post_type' => 'recipes',
        'post_status' => 'publish',
        'posts_per_page' => $post,
        'orderby' => 'date',
        'order' => 'DESC',
    );
    if (isset($_POST['keyword']) && !empty($_POST['keyword'])) {
        $search['s'] = $_POST['keyword'];
    }

    if (isset($_POST['taxonomies']) && is_array($_POST['taxonomies'])) {
        //print_r($_POST['taxonomies']);
        foreach ($_POST['taxonomies'] as $taxonomyName => $taxonomyValue) {
            if ($taxonomyName && $taxonomyValue) {
                $tax_query = array('relation' => 'AND');
                $tax_query[] = array('relation' => 'AND',
                    array(
                        'taxonomy' => $taxonomyName,
                        'field' => 'slug',
                        'terms' => $taxonomyValue,
                        'operator' => 'AND',
                    )
                );
                $search['tax_query'] = $tax_query;
            }
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
//                        print_r($query->the_recipe());
                        $query->the_post();
	
						$title = get_the_title($post->ID);
						$permalink = get_permalink($post->ID);
						$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium', true );
						$desc = get_the_excerpt();
	
                        $terms = get_the_terms( $query->post->ID, 'dietary' );
                        ?>
                        <div class="col-sm-6 col-md-3 col-lg-3 recipe">

                            <article class="snippet active">
                                <a target="_self" href="<?= $permalink ?>" title="<?= $title ?>"
                                   class="snippet-image">

                                    <img  width="100%" src="<?= $img[0] ?>" alt="<?= $title ?>">
                                </a>


                                <div class="recipe-tags clearfix">
                                    <?php
                                    if (is_array($terms)) {
                                        foreach ( array_slice($terms, 0, 3) as $term ) {
                                            $diet = $term->name;
                                            ?>
                                            <p class="snip-tag"><span><?php echo $diet ?></span></p>
                                            <?php
                                        }
                                    } ?>
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
				$("#recipe-load-area > .infinite_scroll > .snippets > .snippets").css("display", "none");
				$("#recipe-load-area > .infinite_scroll > .snippets > .row-pagination").css("display", "none");
				
			}
        });
		if($(".recipe-search-inputs input.txt").val()){
			$("#recipe-load-area > .infinite_scroll > .snippets > .snippets").css("display", "none");
			$("#recipe-load-area > .infinite_scroll > .snippets > .row-pagination").css("display", "none");
		}
	</script>
    <?php
    //if (!$flag)
      //die();
}


function recipes_page_shortcode_vc() {
	
	$categories_array = array();
    $categories = get_categories(array('taxonomy' => 'product_cat',));
    foreach( $categories as $category ) {
        $categories_array[$category->name] = $category->slug;
    }

    vc_map(
        array(
            'name' => __('Recipes Section', 'custom_elements'),
            'base' => 'recipes_page',
            'description' => __('Recipes page - display sortable list', 'custom_elements'),
            'category' => 'Nuzest Custom',
            'icon' => 'recipes-section-vc-icon',
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
add_shortcode('recipes_page', 'display_recipe_block');
add_action('vc_before_init', 'recipes_page_shortcode_vc');
add_action('execute_recipe_search', 'display_recipe_search_results');
add_action('wp_ajax_search_recipes', 'display_recipe_search_results');
add_action('wp_ajax_nopriv_search_recipes', 'display_recipe_search_results');
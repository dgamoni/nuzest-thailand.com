<?php
const COLUMN_TYPE_SINGLE = 1;
const COLUMN_TYPE_DOUBLE = 2;

function faq_v2_shortcode($atts)
{
    $getTaxonomy = get_terms('faq_taxonomy', array(
		'hide_empty' => true,
	));
	$custom_terms = array_filter($getTaxonomy , function ($t) {
					    # This term has a parent, but its parent does not.
		return $t->parent != 0 && get_term($t->parent, 'faq_taxonomy')->parent == 0;
	});
	extract(
        $attributes = shortcode_atts(
            array(
				'faqs_version_option_v2' => '',
				'hide_categories' => '',
            ), $atts
        )
    );
	$varFaqsVersion = $attributes['faqs_version_option_v2'];
	$hideCategories = $attributes['hide_categories'];

    // Show only selected checkboxes.
    if (array_key_exists('categories', $atts) && $atts['categories']) {
        $showOnly = explode(',', $atts['categories']);
        if(!in_array(0, $showOnly)) {
            $custom_terms = array_filter($custom_terms, function (WP_Term $customTerm) use ($showOnly) {
                return in_array($customTerm->term_id, $showOnly);
            });
        }
    }

    ob_start();
	wp_register_script('faq.jquery.search', get_template_directory_uri() . '/js/faq.jquery.js', array(), '1.0.0', true);
	wp_enqueue_script('faq.jquery.search');
	
	if($varFaqsVersion == "old_version"){
		if($hideCategories != '0'){ 
    ?>
		<div class="row">
			<section class="container" style="text-align: center; text-align: -webkit-center">
				<div class="row">
					<div class="faq-item-v2" style="padding:50px 0 100px 0; width:67%">
						<div class="row margin-top-lg">
							<?php foreach ($custom_terms as $custom_term) { ?>
								<div class="topic-list col-md-6 col-lg-3">
									<a class="btn btn-square" href="#<?= $custom_term->term_id ?>" style="width: 100%;"><?= $custom_term->name ?></a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</section>
		</div>
    <?php
		}
	}
	
	if($varFaqsVersion == "new_version"){
	?>
	<div class="container v2_newVersion">
	<div id="faqs_products_cat" class="wpb_column column col-sm-3">
				<div id="by_product" class="faq_category">
					<h3><?php _e('Filter by Product', 'nuzest-theme') ?></h3><br>
				<?php
					// get term of product catgories, get term id and name and push into new array
					$objProductTaxonomys = get_terms(array(
						'taxonomy' => 'product_cat',
						'hide_empty' => true,
					));
					$arrayProductCat = []; 
					foreach ($objProductTaxonomys as $value){
						$arrayProductCat[$value -> term_id] = $value -> name;
					}
					// get term of faq taxonomy, get use term id and name and push into new array
					$objFaqTaxonomys = get_terms(array(
						'taxonomy' => 'faq_taxonomy',
						'hide_empty' => true,
						'parent' => 0,
					));
					$arrayFaqTaxonomys_parent = []; 
					foreach ($custom_terms as $value){
						$arrayFaqTaxonomys_parent[$value -> term_id] = $value -> name;
					}
					// find the duplicate value of new product cat and faq taxonomy
					$arrayIntersectFaqTaxProdCat = array_intersect($arrayFaqTaxonomys_parent, $arrayProductCat);
					// put duplicate values into new array(values are from faq taxonomy), make keys become values in new array
					$arrayIntersectFaqTaxProdCat_key = [];
					foreach($arrayIntersectFaqTaxProdCat as $key => $value){
						array_push($arrayIntersectFaqTaxProdCat_key, $key);
					}
					// get term of faq taxonomy, only appare the product cats
					$objFaqTaxonomys_includeProdCat = get_terms(array(
						'taxonomy' => 'faq_taxonomy',
						'hide_empty' => true,
						'parent' => 0,
						'include' => $arrayIntersectFaqTaxProdCat_key,
					));
					$FaqTaxonomys_FirstLevel = get_terms('faq_taxonomy', array(
						'hide_empty' => true,
						'parent' => 0,
					));
					$FaqTaxonomys_SecondLevel = get_terms('faq_taxonomy', array(
						'hide_empty' => true,
					));
					$secondLevel = array_filter($FaqTaxonomys_SecondLevel , function ($t) {
					    # This term has a parent, but its parent does not.
					    return $t->parent != 0 && get_term($t->parent, 'faq_taxonomy')->parent == 0;
					});
					$firstLevel_id = []; 
					foreach ($FaqTaxonomys_FirstLevel as $firstLevel){
						$firstLevel_id[] = $firstLevel -> term_id;
					}	
					foreach ($secondLevel as $value){
						if($value -> parent == $firstLevel_id[0]){
							echo "<div class='faqs-cat-input faqs_v2'>";
							echo "<input id='".$value ->term_id."' type='radio' data-taxonomy-type='product_cat' name ='product_cat' value = '".$value ->term_id."'> <label for='".$value ->term_id."'>".$value ->name."</label><br>";
							echo "</div>";
						}
					}
					
				?>
				</div>
				<div id="by_category" class="faq_category">
					<h3><?php _e('Filter by Topic', 'nuzest-theme') ?></h3><br>
				<?php
					// get term of faq taxonomy, only appare the terms are not product cats
					$objFaqTaxonomys_excludeProdCat = get_terms(array(
						'taxonomy' => 'faq_taxonomy',
						'hide_empty' => true,
						'parent' => 0,
						'exclude'  => $arrayIntersectFaqTaxProdCat_key,
					));
					$FaqTaxonomys_top1 = [];
					foreach ($objFaqTaxonomys_excludeProdCat as $value){
						$FaqTaxonomys_top1[$value -> term_id] = $value -> name;
					}
					$FaqTaxonomys_top2 = [];
					foreach ($custom_terms as $value){
						$FaqTaxonomys_top2[$value -> term_id] = $value -> name;
					}
					
					$arrayIntersectFaqTaxTopCat = array_intersect($FaqTaxonomys_top1, $FaqTaxonomys_top2);
					
					foreach ($secondLevel as $key=>$value){
						if($value -> parent == $firstLevel_id[1]){
							echo "<div class='faqs-cat-input'>";
							echo "<input id='".$value ->term_id."' type='radio' data-taxonomy-type='product_cat' name ='product_cat' value = '".$value ->term_id."'> <label for='".$value ->term_id."'>".$value ->name."</label><br>";
							echo "</div>";
						}
					}
				?>
			</div>
		</div>
		<div id="faq_content" class="faq_category wpb_column column col-sm-9">
			<div id="pop_questions">
				<h3>Popular Questions</h3><br>
			</div>
				<?php
					$arrPopQuestions = array();
					foreach ($custom_terms as $custom_term):
							$args = array(
							'post_type' => 'faqs',
							'order' => 'ASC',
							'orderby' => 'menu_order',
							'posts_per_page' => -1,
							'tax_query' =>
								array('relation' => 'AND',
									array('taxonomy' => 'faq_taxonomy',
										'field' => 'term_id',
										'terms' => $custom_term,
										'operator' => 'IN'
									)
								)
							);
							$posts = get_posts($args);
							foreach ($posts as $post){
								$varGetPost = get_post( $post->ID);
								if(!empty($varGetPost)){
									$arrPopQuestions[$varGetPost->ID] = $varGetPost->menu_order;
								}
							}
							
					endforeach;
							$arrPopQuestions_numControl = array();
							arsort($arrPopQuestions);
							$arrPopQuestions_numControl = array_slice($arrPopQuestions, 0, 11, true);
							//print_r($arrPopQuestions);
							//print_r($arrPopQuestions_numControl);
						?>
						
						<div class="row sub-topic">
							<div class="quick-list-pop faq-list col-md-12" >
								<ul class="list-unstyled faq-list">
									<?php
									foreach($arrPopQuestions_numControl as $key=>$value){
										$post = wp_get_single_post($key);
										?>
										
										<li id="<?= $post->ID ?>" class="faq-list-item-pop">
											<h4><?= $post->post_title ?></h4>
											<div class="details"><?= $post->post_content; ?></div>
											<p class="quick-arrow"></p>
										</li>
									<?php
									}
									?>
								</ul>
							</div>
						</div>

		</div>
	</div>
	<?php
	}	
	?>
	<div class="container">
		<div class="row">
            <?php if (array_key_exists('column_type', $atts) && $atts['column_type'] == COLUMN_TYPE_DOUBLE):
                $articles = [];			
				$custom_terms = array_values( $custom_terms);
                for ($i = 0; $i < count($custom_terms); $i++) {
                    $articles[] = $custom_terms[$i];
                }
            ?>
                <div class="col-md-12">
                    <?php foreach ($articles as $article):
                        outputFaqV2Article($article, true);
                        endforeach;
                    ?>
                </div>
            <?php
                else:
                    foreach ($custom_terms as $custom_term):
                        outputFaqV2Article($custom_term, false);
                    endforeach;
                endif;
            ?>
        </div>
		</div>
	<?php
	return ob_get_clean();
}


function outputFaqV2Article(WP_Term $faqArticle, $twoColumns = false) {
    ?>

    <article class="row main-topic" id="<?= $faqArticle->term_id ?>">
        <div class="faq-item">
            <header class="row"><h2 class="col-md-12"><?= $faqArticle->name ?></h2></header>
            <?php outputSubCategoriesV2($faqArticle->term_id, $twoColumns ? 'col-md-6' : 'col-md-12') ?>
        </div>
    </article>

    <?php
}

function outputSubCategoriesV2($customTermID, $quickListClass = 'col-md-6') {
    $varFaqTermChildren = get_term_children($customTermID, 'faq_taxonomy');
    $args = array(
        'post_type' => 'faqs',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => -1,
        'tax_query' =>
            array('relation' => 'AND',
                array('taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => array($customTermID),
                    'operator' => 'IN'
                ),
                array('taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => $varFaqTermChildren,
                    'operator' => 'NOT IN'
                )
            )
    );
    $posts = get_posts($args);
    ?>

    <div class="row sub-topic">
        <div class="quick-list faq-list <?= $quickListClass; ?>" >
            <ul class="list-unstyled faq-list">
                <?php outputFAQPost_v2($posts); ?>
            </ul>
        </div>
    </div>

    <?php
    $subs = get_terms('faq_taxonomy', array(
        'parent' => $customTermID,
        'hide_empty' => 1
    ));

    foreach ($subs as $sub) :
        $subID = $sub->term_id;
        $args = array(
            'post_type' => 'faqs',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'tax_query' => array(
                array(
                    'taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => $subID,
                )));
        $posts = get_posts($args);
        ?>
        <div class="row sub-topic">
            <h3 class="col-md-12"><?= $sub->name ?></h3>
            <div class="quick-list <?= $quickListClass; ?>">
                <ul class="list-unstyled faq-list">
                    <?php outputFAQPost_v2($posts); ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>

    <?php
}

add_shortcode("faq_v2", "faq_v2_shortcode");

function display_faq_search_results_v2($atts){	
	if (isset($_POST['taxonomies'])) { 
		$varCustomTermID = $_POST['taxonomies']['product_cat'][0];
		$objFaqTaxonomys = get_terms(array(
			'taxonomy' => 'faq_taxonomy',
			'hide_empty' => true,
		));
		$arrayFaqTaxonomys_parent = [];
		foreach ($objFaqTaxonomys as $value){
			array_push($arrayFaqTaxonomys_parent, $value -> term_id);
		}
		$term = get_term($varCustomTermID, 'faq_taxonomy');
		$name = $term->name;
		echo '<h2><strong>';
			_e('FAQs', 'nuzest-theme');
		echo ' - '.$name.'</strong></h2>';
		if (in_array($varCustomTermID, $arrayFaqTaxonomys_parent)){
			outputSubCategories_v2($varCustomTermID, $twoColumns ? 'col-md-6' : 'col-md-12');
			wp_die(); 
		}
		/*else{		
			$arrayFaqTaxonomy_child_multi_id = [];
			$arrayFaqsTaxonomy_child = [];
			$arrayFaqTaxonomy_child_KeyValue = [];
			$child_cat_id_array =[];
			foreach ($objFaqTaxonomys as $value){
				$varFaqTermChildren = get_term_children($value ->term_id, 'faq_taxonomy');
				array_push($arrayFaqTaxonomy_child_multi_id, array_filter($varFaqTermChildren));
			}
			$arrayFaqsTaxonomy_child = call_user_func_array('array_merge', $arrayFaqTaxonomy_child_multi_id);
			foreach ($arrayFaqsTaxonomy_child as $value){
				$term = get_term( $value, 'faq_taxonomy' );
				$arrayFaqTaxonomy_child_KeyValue[$term->term_id] = $term->name;
			}
			foreach ($arrayFaqTaxonomy_child_KeyValue as $key => $value){
				if($key == $varCustomTermID){
					$child_cat_name = $value;
				}
			}
			foreach ($arrayFaqTaxonomy_child_KeyValue as $key => $value){
				if ($child_cat_name == $value){
					 array_push($child_cat_id_array, $key);
				}
			}
			foreach ($child_cat_id_array as $customTermID){
				outputSubCategories($customTermID, $twoColumns ? 'col-md-6' : 'col-md-12');
			}
		}*/
	}
}


function outputFaqArticle_v2(WP_Term $faqArticle, $twoColumns = false) {
    ?>

    <article class="row main-topic" id="<?= $faqArticle->term_id ?>">
        <div class="faq-item">
            <header class="row"><h2 class="col-md-12"><?= $faqArticle->name ?></h2></header>
            <?php outputSubCategories_v2($faqArticle->term_id, $twoColumns ? 'col-md-6' : 'col-md-12') ?>
        </div>
    </article>

    <?php
}

function outputSubCategories_v2($customTermID, $quickListClass = 'col-md-6') {
    $varFaqTermChildren = get_term_children($customTermID, 'faq_taxonomy');
    $args = array(
        'post_type' => 'faqs',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'posts_per_page' => -1,
        'tax_query' =>
            array('relation' => 'AND',
                array('taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => array($customTermID),
                    'operator' => 'IN'
                ),
                array('taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => $varFaqTermChildren,
                    'operator' => 'NOT IN'
                )
            )
    );
    $posts = get_posts($args);
    ?>

    <div class="row sub-topic">
        <div class="quick-list faq-list <?= $quickListClass; ?>" >
            <ul class="list-unstyled faq-list">
                <?php outputFAQPost_v2($posts); ?>
            </ul>
        </div>
    </div>

    <?php
    $subs = get_terms('faq_taxonomy', array(
        'parent' => $customTermID,
        'hide_empty' => 1
    ));

    foreach ($subs as $sub) :
        $subID = $sub->term_id;
        $args = array(
            'post_type' => 'faqs',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'tax_query' => array(
                array(
                    'taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => $subID,
                )));
        $posts = get_posts($args);
        ?>
        <div class="row sub-topic">
            <h3 class="col-md-12"><?= $sub->name ?></h3>
            <div class="quick-list <?= $quickListClass; ?>">
                <ul class="list-unstyled faq-list">
                    <?php outputFAQPost_v2($posts); ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>

    <?php
}

function outputFAQPost_v2($posts) {
    foreach ($posts as $post):
        ?>
        <li id="<?= $post->ID ?>" class="faq-list-item">
            <h4><?= $post->post_title ?></h4>
            <div class="detail"><?= $post->post_content; ?></div>
            <p class="quick-arrow"></p>
            <hr>
        </li>
    <?php endforeach;
}


function faq_v2_shortcode_vc()
{
	// Get faq categories and transform them to value list.
    $faqCategories = get_terms('faq_taxonomy', array(
        'hide_empty' => 1
    ));
	
	$parameters[] =array(
		"type"        => 'dropdown',
		"heading" => __( 'Page layout', "nuzest-theme" ),
		"param_name" => "faqs_version_option_v2",
		"value" => array(
			'v1'   => "old_version",
			'v2'   => "new_version"
		),
		"std"         => "v1",
		"description" => __( "Choose a module layout style", "nuzest-theme" )
	);
	$parameters[] = array(
		"type" => "dropdown",
		"admin_label" => true,
		"class" => "hideContent",
		"heading" => __("1 Column / 2 Columns", 'custom_elements'),
		"param_name" => "column_type",
		"value" => array(
			'1 Column' => COLUMN_TYPE_SINGLE,
			'2 Columns' => COLUMN_TYPE_DOUBLE,
		),
		'holder' => 'div'
	);
	$parameters[] = array(
		"type" => "checkbox",
		"heading" => __("Hide FAQs categories", 'custom_elements'),
		"param_name" => "hide_categories",
		"value" => [__("Hide", 'custom_elements') => 0],
	);
	$parameters[] = array(
		"type" => "checkbox",
		"heading" => __("FAQs categories", 'custom_elements'),
		"param_name" => "categories",
		"value" => [__("All", 'custom_elements') => 0],
	);
	
    $categories = array_reduce($faqCategories, function (array $categoriesList, WP_Term $category) {
        return array_merge($categoriesList, [
            $category->name => $category->term_id
        ]);
    }, []);
	foreach ($categories as $title => $id) {
        $parameter = array(
            "type" => "checkbox",
            "param_name" => "categories",
            "value" => [$title => $id],
        );
		$parameters[] = $parameter;
    }
	//print_r($parameters);
    vc_map(
        array(
            'name' => __('FAQ v2', 'nuzest-theme'),
            'base' => 'faq_v2',
            'description' => __('Display FAQ category buttons', 'nuzest-theme'),
            'category' => 'Nuzest Custom',
            'icon' => 'faq-categories-vc-icon',
            'content_element' => true,
			'params' => $parameters
        )
    );
}

add_action('vc_before_init', 'faq_v2_shortcode_vc');
add_action('vc_before_init', 'faq_block_shortcode_vc_v2');
add_action('execute_faq_search', 'display_faq_search_results_v2');
add_action('wp_ajax_search_faq', 'display_faq_search_results_v2');
add_action('wp_ajax_nopriv_search_faq', 'display_faq_search_results_v2');


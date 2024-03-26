<?php
/**
 * Template part for displaying single recipe posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nuzest_Theme
 */

?>

<?php
	// Get post thumbnail
	$thumbnail_id = get_post_thumbnail_id();
	$thumbnail_url = wp_get_attachment_image_src($thumbnail_id, 'thumbnail-size', true);
	$thumbnail_meta = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope"  itemtype ="http://schema.org/Recipe">
<section>	
	<div class="container">
		<div class="row">
		
			<div id="recipe-right" class="col-md-6 col-md-push-5 col-lg-5 col-lg-push-6 recipe-right-col">
				
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' ); ?>
					
					<!-- recipe description -->
					<div itemprop="description"><?php the_content(); ?></div>
				
					<?php
					$terms = get_the_terms( $post->ID, 'meal_type' );
					foreach ( $terms as $term ) {
							$tag = $term->name;
							echo '<link itemprop="recipeCategory" content="'.$tag.'">';
					}
					?>
					
					
					<!-- recipe meta data -->
					<div class="recipe-info clearfix">
						<p class="cooking-meta">
								<?php
									$postMeta = get_post_meta(get_the_ID());
								?>
								<?php if (isset($postMeta['prep_time']) && $postMeta['prep_time'][0]) { ?>
										<span class="info" itemprop="prepTime" content="PT<?= $postMeta['prep_time'][0]?>M">
										<img src="<?php bloginfo('template_directory'); ?>/images/icons/CookingTime-green.svg"><?= $postMeta['prep_time'][0]._e('mins', 'nuzest-theme') ?>
										</span>
								<?php }; ?>
								<?php if (isset($postMeta['servings']) && $postMeta['servings']) { ?>
							<span class="info"><img src="<?php bloginfo('template_directory'); ?>/images/icons/Servings-green.svg"><span itemprop="recipeYield"><?= $postMeta['servings'][0]; ?></span>
										</span>
								<?php }; ?>
						 </p>
						 <ul class="dietary-class">
								<?php
 
								if ((!function_exists('icl_object_id') && has_term('gluten-free', 'dietary', get_post())) || (function_exists('icl_object_id') && has_term(icl_object_id( get_term_by('slug', 'gluten-free', 'dietary')->term_id, 'dietary', true), 'dietary', get_post()))) { ?>
										<li class="gluten-free" title="<?php _e('Gluten Free recipe', 'nuzest-theme') ?>">
											<link itemprop="suitableForDiet" href="http://schema.org/GlutenFreeDiet" />
											<span></span>
										</li>
								<?php };
								if ((!function_exists('icl_object_id') && has_term('sugar-free', 'dietary', get_post())) || (function_exists('icl_object_id') &&  has_term(icl_object_id( get_term_by('slug', 'sugar-free', 'dietary')->term_id, 'dietary', true), 'dietary', get_post()))) { ?>
										<li class="sugar-free" title="<?php _e('Sugar Free recipe', 'nuzest-theme') ?>">
											<span></span>
										</li>
								<?php };
								if ((!function_exists('icl_object_id') && has_term('dairy-free', 'dietary', get_post())) || (function_exists('icl_object_id') &&  has_term(icl_object_id( get_term_by('slug', 'dairy-free', 'dietary')->term_id, 'dietary', true), 'dietary', get_post()))) { ?>
										<li class="dairy-free" title="<?php _e('Dairy Free recipe', 'nuzest-theme') ?>">
											<link itemprop="suitableForDiet" href="http://schema.org/LowLactoseDiet">
											<span></span>
										</li>
								<?php };
								if ((!function_exists('icl_object_id') && has_term('vegan', 'dietary', get_post())) || (function_exists('icl_object_id') && has_term(icl_object_id( get_term_by('slug', 'vegan', 'dietary')->term_id, 'dietary', true), 'dietary', get_post()))) { ?>
										<li class="vegan" title="<?php _e('Vegan recipe', 'nuzest-theme') ?>">
											<link itemprop="suitableForDiet" href="http://schema.org/VeganDiet">
											<span></span>
										</li>
								<?php }
								?>
						 </ul>
					</div>
					
				</header><!-- .entry-header -->
				
				
				
				<!-- post featured image on mobile devices -->
				<div class="mobile-image visible-xs-block visible-sm-block">
           <img class="img-responsive" width="100%" src="<?php echo $thumbnail_url[0]; ?>" itemprop="image"
           alt="<?php echo $thumbnail_meta; ?>">
        </div>
        
        <!-- ingredients list -->
        <?php
        	if (have_rows( 'ingredients')): ?>
				<div class="rec-ingredients">
					<div class="bubble">
						<h3><?php _e('Ingredients', 'nuzest-theme') ?></h3>
						<ul>
						<?php while( have_rows('ingredients') ): the_row(); ?>
							<li itemprop="recipeIngredient">
								<?php the_sub_field('ingredient'); ?>
								<?php $extra = get_sub_field( 'ingredient_info' ) ?>
								<?php if( $extra ): ?>
									<img src="<?php bloginfo('template_directory'); ?>/images/icons/question.svg"
									data-toggle="tooltip" data-placement="bottom" title="<?php echo $extra ?>">
								<?php endif; ?>
							</li>
						<?php endwhile; ?>
						</ul>
					</div>
				</div>
        	<?php endif; ?>
				
				<!-- cooking method -->
				<div class="rec-method">
          			<h3><?php _e('Method', 'nuzest-theme') ?></h3>
          			<div itemprop="recipeInstructions">
           				<?php the_field( 'method');?>
					</div>
        		</div>
			
				
					<div class="share-use-col">
                    
                    <!---- Social Share Section ---->
                    <div class="share social-links">
						<h3><?php _e('Share', 'nuzest-theme') ?></h3>
                        <?php echo social_sharing_buttons(); ?>
                    </div>
                   
                    <!---- Product Reference Section ---->
                    <?php
                    $productCats = wp_get_post_terms($post->ID, 'product_cat');
                    if (isset($productCats) && count($productCats)):?>
                        <div class="nz-prod clearfix">
                            <h3><?php _e('This recipe uses', 'nuzest-theme') ?>:</h3>
                            <?php
                            foreach ($productCats as $index => $productCat):
                                $thumbnail_id = get_woocommerce_term_meta($productCat->term_id, 'thumbnail_id', true);
                                $image = wp_get_attachment_url($thumbnail_id);
                                ?>
                                <hr>
                                <div class="featured-product">
                                    <h4><?= $productCat->name ?></h4>
                                    <div class="nz-prod-image"><img class="" src="<?= $image ?>"></div>
                                    <p><?= $productCat->description ?></p>
                                    <a class="btn btn-primary"
                                       href="<?= get_term_link($productCat->slug, 'product_cat') ?>">
                                        <?php _e('Buy Now', 'nuzest-theme') ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Schema.org Publisher information -->
					<?php get_template_part('template-parts/content', 'schema-publisher'); ?>
            </div><!-- / .row  -->
            
            		
			</div> <!-- / #recipe-right -->
			
			
			<div id="recipe-left" class="col-md-4 col-md-pull-5 col-lg-5 col-lg-pull-4 recipe-left-col">
			
				<!-- post featured image on larger screens-->
				<?php if ( has_post_thumbnail() ) { ?>
					<div class="item hidden-xs hidden-sm">
						<img class="img-responsive" width="100%" itemprop="image" src="<?php echo $thumbnail_url[0]; ?>" alt="<?php the_title(); ?>"/>
					</div>
				<?php } ?>
				
				<!-- (optional) post video -->
				<?php if ( get_field('recipe_video') ) { ?>
					<div class="embed-container recipe-video" itemprop="video">
						<?php the_field('recipe_video'); ?>
					</div>
				<?php } ?>
				
				<!-- (optional) additional image gallery -->
				<?php
				$images = get_field('image_gallery');
				if( $images ):
					foreach( $images as $image ): ?>
					<div class="item">
						<img class="img-responsive" itemprop="image" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
					</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div> <!-- #recipe-left -->
			
		</div><!-- .row -->
		
		
		
	</div><!-- / .container -->
	</section>
	
	<aside class="snippets">
     <div class="container">
        <div class="row section-header">
            <div class="col-md-12">
                <h3 class="h1"><?php _e('Related Recipes', 'nuzest-theme') ?></h3>
            </div>
         </div>
         <?php get_template_part('template-parts/content', 'related-snippets'); ?>
     </aside>
  </section>
  	
</article><!-- #post-<?php the_ID(); ?> -->
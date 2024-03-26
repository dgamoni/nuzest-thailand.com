<?php /* Template Name: Home Page Template */ ?>

<?php get_header(); ?>
<!-- start #page-content in header.php -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<!-- Generate banners -->
	<?php
        $flush_banner = true;
        include(locate_template('inc/content-banners.php'));
    ?>

	<!-- Page intro -->
	<?php get_template_part( 'inc/content', 'intro' ); ?>

	<!-- Product blocks > collect detail page ID and use it to pull in product quick list -->
	<?php if( have_rows( 'product_block' ) ): while( have_rows( 'product_block' ) ): the_row(); ?>
	<?php // set variables
	$related_id = get_sub_field( 'detail_page' );
	$post_data = get_post($related_id, ARRAY_A, 'post_name');
	$related_product = '';
	$products = get_the_terms( $post_data['ID'], 'products' );
	if (count($products)) {
		$related_product = $products[0];
	}
	?>

	<section class="usp-sec <?php echo($related_product->slug); ?>">
		<div class="img-wrap <?php if ( get_sub_field( 'text_position' ) == 'left' ){ echo 'image-right'; } ?>" style="background-image: url(<?php the_sub_field( 'background_image' ); ?>);"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-lg-7 col-xl-5 <?php if ( get_sub_field( 'text_position' ) == 'right' ){ echo 'col-md-offset-4 col-lg-offset-5 col-xl-offset-7'; } ?> ">
					<div class="usp-bubble <?php the_sub_field( 'text_position' ); ?>">
						<h2><?php the_sub_field( 'product_name' ); ?></h2>
						<?php if( have_rows('quick_list') ): ?>
						<ul class="list-unstyled">
							<?php while( have_rows('quick_list') ): the_row(); ?>
							<li>
								<h4><?php the_sub_field( 'item_heading' ); ?></h4>
								<p><?php the_sub_field( 'item_detail' ); ?></p>
							</li>
							<?php endwhile; ?>
						</ul>
						<div class="usp-buttons">
							<?php $detail_page = get_sub_field( 'detail_page' ); if ($detail_page) : ?>
							<a class="btn btn-primary solid btn-<?php echo $related_product->slug ?>" href="<?php echo get_the_permalink($detail_page) ?>"><?php _e('Product Info','nuzest-custom') ?></a>
							<?php endif; ?>
							<?php $product_category = get_sub_field('product_category'); if ($product_category) : ?>
							<a class="btn btn-primary btn-<?php echo $product_category->slug ?>" href="/product-category/<?php echo $product_category->slug ?>"><?php _e('Shop Now','nuzest-custom') ?></a>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
	   </div>

	</section>
	<?php endwhile; endif; //end product block loop ?>


<!-- Testimonial sliders and contact block -->
<section class="testimonial-sec">
	<div class="container">
		<div class="row">
        
			<?php // count the number of compliant testimonials to find to figure out where to split the list
            $totalcount = count( get_field( 'testimonials' ) ); 
			if ( $totalcount < 6) { // work out where to split if less than 6 returned
                $splitrow = ceil($totalcount / 2);
			} else { // else just split at 3
                $splitrow = 3;
            };?>
        
        	<div class="hidden-sm col-md-3">
				<div class="royalSlider rsDefault testimonial-slider text-center">
        
				<?php if( have_rows( 'testimonials' )) { 
                    $rownum = 0; ?>
                    
                <?php while ( have_rows( 'testimonials' )) {
                    the_row(); $rownum++; ?>
                    
                    <div class="rsContent">
                        <?php $test_object = get_sub_field( 'testimonial' );
                            if( $test_object ){
                                $test_quote = get_field( 'testimonial', $test_object->ID );
                                $test_img = wp_get_attachment_image_src( get_post_thumbnail_id($test_object->ID), 'thumbnail_size' );
                                $img_url = $test_img[0];
                                $test_name = get_field( 'name', $test_object->ID );
                                $test_byline = get_field( 'byline', $test_object->ID );
                        } ?>
                    
                        <div class="img-circle img-profile" style="background-image: url(<?php echo $img_url; ?>);" alt="<?php echo $test_name; ?>"></div>
                        <h4><?php echo $test_name; ?></h4>
                        <p class="byline"><?php echo $test_byline; ?></p>
                        <p><?php echo $test_quote; ?></p>
                    </div>
                    
                    <?php if ( $totalcount > 1 && $rownum == $splitrow ) {
                        // split the list into two separate siders
                        echo '</div></div><div class="hidden-xs col-md-3 col-md-push-6"><div class="royalSlider rsDefault testimonial-slider text-center">';
                    }; ?>
                <?php } // end while have_rows ?>
        		<?php } // end if have_rows ?>        
 				
                </div>
			</div>  
            
            <!-- Contact block -->
			<?php if ( $totalcount <= 1 ) {
				echo '<div class="col-xs-12 col-md-6 ">';
				} else {
				echo '<div class="col-xs-12 col-md-6 col-md-pull-3">';
			} ?>
				<div class="contact-block">
					<div class="upper">
						<h1><?php _e('Need a little help?', 'nuzest-custom') ?></h1>
						<?php _e('Looking for answers? Get in touch with us or check our FAQ database.', 'nuzest-custom') ?>
                        <div>
							<a class="btn btn-primary" href="/contact"><?php _e('Contact Us', 'nuzest-custom') ?></a>
                        	<a class="btn btn-primary" href="/faqs"><?php _e('FAQs', 'nuzest-custom') ?></a>
						</div>
                        <?php if( have_rows( 'testimonials' )) { ?>
							<hr />
							<h1><?php _e('Testimonials', 'nuzest-custom') ?></h1>
							<?php _e('See what other people have to say', 'nuzest-custom') ?>
							<div>
								<a class="btn btn-primary" href="/testimonials"><?php _e('View All', 'nuzest-custom') ?></a>
							</div>
                        <?php }; ?>
					</div>
					<div class="lower">
                    	<?php if( get_field( 'facebook_url', 'option' ) ){
							$fb_link = get_field( 'facebook_url', 'option' );}
							else { $fb_link = 'nuzest'; }
						?>
						<div class="fb-plugin-container">
							<div class="fb-page" data-href="https://www.facebook.com/<?php echo $fb_link; ?>" data-width="500" data-hide-cover="true" data-show-facepile="true" data-show-posts="false"></div>
						</div>
					</div>
				</div>
			</div>
            
                            
		</div>
	</div>
</section>


<section class="snippets">
    <div class="container">
		<div class="row section-header">
			<div class="col-md-12">
				<h1><?php _e('Recent Posts', 'nuzest-custom') ?></h1>
				<?php _e('Check out all the latest articles and recipes to keep you healthy and motivated!', 'nuzest-custom') ?>
			</div>
		</div>

		<div class="row">
			<?php
				$post_types = array( 'post', 'recipes' );
				global $postcountnum;
				$postcountnum = 1;

				foreach( $post_types as $post_type) {
					$args = array(
						'post_type' => $post_type,
						'posts_per_page' => '2',
						'post__not_in' => array( $post->ID ),
					);
					$snippet_query = new WP_Query( $args );
					while ($snippet_query->have_posts()) {
						$snippet_query->the_post();
						get_template_part( 'inc/content', 'snippets' );
						$postcountnum++;
					}
					wp_reset_query();
				}
			?>
		</div>
	</div>
</section>





<?php endwhile; endif; //end main loop ?>

<!-- // end #page-content in footer.php -->
<?php get_footer(); ?>

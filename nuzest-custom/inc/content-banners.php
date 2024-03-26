<?php
//// Generate page banners from Custom Post Type ////
?>

<?php

global $post;

$template = get_post_meta( $post->ID, '_wp_page_template', true );
$template = str_replace("page_"," ","$template");
$template = str_replace(".php"," ","$template");

$banner_query = new WP_Query( array(
	'post_type' => 'banners',
	'meta_key' => 'location',
	'meta_value' => $template,
	'posts_per_page' => 1,
	));

// set banner height based on page template
$classes = array();

if ($flush_banner) {
    $classes[] = 'feature-banner--flush';
}

if ($post) {
	if ( is_page_template( 'page_products.php' ) || is_page_template( 'page_clean-lean-protein.php' ) || is_page_template( 'page_good-green-stuff.php' ) || is_page_template( 'page_kids-good-stuff.php' ) ) {
		//$classes[] = 'taller'; only Home page should need this class
		$classes[] = 'product-banner';
	}
	
	if ( is_front_page() ) {
		$classes[] = 'taller';
	}
}
$classes = implode($classes,' ');

//Display static banner or slideshow -->
if( $banner_query->have_posts() ) : while( $banner_query->have_posts() ): $banner_query->the_post(); ?>
	<?php if( have_rows( 'wide_banners' ) ): 
	
		$bnCount = count( get_field( 'wide_banners' ) ); ?>
    
    <section id="feature-banner" class=" <?php echo $classes; if( $bnCount > 1 ){ echo ' royalSlider rsDefault'; } ?> ">
		
		<?php while ( have_rows( 'wide_banners' ) ) : the_row(); 
		// Create slides out of the repeater rows ?>
        <!-- Start individual slide content --> 
        <?php 	
		if( get_sub_field( 'active' )) :
				$banner_image = get_sub_field( 'banner_image' );
				$link_field = get_sub_field( 'button_link' );
				$link = post_permalink( $link_field->ID );
				$banner_image = get_sub_field( 'banner_image' ); 
				$image_crop = get_sub_field( 'image_crop' );  ?>
        
        
            <div class="rsContent <?php echo get_sub_field( 'image_crop_mobile' ); ?>" data-location="<?php echo get_field( 'location' ) ?>" style="background-image: url('<?php echo $banner_image['url'] ?>'); background-position: <?php echo $image_crop; ?>% 0;"> 
            	<div class="container banner-content<?php if( get_sub_field( 'hide_text' )) { echo ' hidden-xs'; } ?> ">
                    <div class="row"> 
                    	<?php
						  if( get_sub_field( 'text_placement' ) == 'left' ) {
							  echo '<div class="col-xs-6 col-sm-5">';
						  }
						  else if ( get_sub_field( 'text_placement' ) == 'right' ){
							  echo '<div class="col-xs-6 col-xs-offset-6 col-sm-5 col-sm-offset-6 col-md-5 col-md-offset-6 col-lg-5 col-lg-offset-7">';
						  }
						  else if ( get_sub_field( 'text_placement' ) == 'custom' ){
							  if( have_rows( 'custom_scaling' ) ): 
								  echo '<div class="';
								  while ( have_rows( 'custom_scaling' ) ) : the_row();
									  $device_size = get_sub_field( 'device_size' );
									  $width = get_sub_field( 'width' );
									  $offset = get_sub_field( 'offset' );
									  echo 'col-' . $device_size . '-' . $width . ' col-' . $device_size . '-offset-' . $offset . ' ';
								  endwhile;
								  echo '">'; 
							  endif;
						  }
						  else {
							  echo '<div class="col-md-6">';
						  }  
						?>        
                            <div class="bnText">
                                <h1><?php the_sub_field( 'banner_heading' ); ?></h1>
                                <p><?php the_sub_field( 'banner_content' ); ?></p>
                            </div>
                            <a class="btn btn-<?php the_sub_field( 'button_colour' ) ?>" href="<?php echo $link ?>"><?php the_sub_field( 'button_text' ) ?></a>
                        </div>
             		</div>
                </div>
             </div>           
           
            
        <!-- End individual slide content -->        
		<?php endif; endwhile;  ?>
            
       </section>     
	<?php endif; 
	endwhile; ?>
	

<?php else :  //if no banners present, show an error message ?>
	<section id="feature-banner">
		<div class="container">
			<div class="row">
				<div class="col-sm-9 col-md-7 col-lg-6 col-xl-5 text-left">
					<h1><?php _e('No Banners to display', 'nuzest-custom') ?></h1>
				</div>
			</div>
		</div>
	</section>
<?php endif;

wp_reset_query();

?>


<?php /* Template Name: Products Template */ ?>

<?php get_header(); ?>
<!-- start #page-content in header.php -->

<!-- Generate banners -->
<?php
    $flush_banner = true;
    include(locate_template('inc/content-banners.php'));
?>

<!-- Page intro -->
<?php get_template_part( 'inc/content', 'intro' ); ?>

<!-- Product blocks -->
<?php
// collect detail page ID and use it to pull in product quick list
if( have_rows( 'product_block' ) ): while( have_rows( 'product_block' ) ):
	the_row();

	$product = get_sub_field( 'product_category' );
	$related_id = get_sub_field( 'detail_page' );
	$product_category = get_sub_field('product_category');
?>
	<section class="usp-sec <?php $product->slug ?>">
	<div class="img-wrap <?php if ( get_sub_field( 'text_position' ) == 'left' ){ echo 'image-right'; } ?>" style="background-image: url(<?php the_sub_field( 'background_image' ); ?>);"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-5 col-lg-5 <?php if ( get_sub_field( 'text_position' ) == 'right' ){ echo 'col-md-offset-7 col-lg-offset-7'; } ?> ">

					<h1><?php echo $product->name ?></h1>
					<?php if( have_rows('quick_list', $related_id) ): ?>
					<ul class="scroller">
						<?php while( have_rows('quick_list', $related_id) ): the_row(); ?>
						<li>
							<div class="row">
								<div class="col-xs-2">
									<?php echo wp_get_attachment_image( get_sub_field('icon'), 'thumbnail', false, array('class'=>'img-responsive float-right')); ?>
								</div>
								<div class="col-xs-10">
									<h3><?php the_sub_field( 'item_heading' ); ?></h3>
									<p><?php the_sub_field( 'item_sub_head' ); ?></p>
								</div>
							</div>
						</li>
						<?php endwhile; ?>
					</ul>
					<?php endif; ?>

					<div class="usp-buttons">
						<a class="btn btn-primary btn-<?php echo $product_category->slug ?> solid" href="<?php echo get_page_link($related_id) ?>"><?php _e('More info', 'nuzest-custom') ?></a>
						<a class="btn btn-primary btn-<?php echo $product_category->slug ?>" href="/shop"><?php _e('Shop now', 'nuzest-custom') ?></a>
					</div>
			 </div>
			</div>
		</div>
	</section>

	<?php
		global $product;
		get_template_part( 'inc/block', 'recent-product-posts' );
	?>

<?php endwhile; endif; //end product block loop ?>

<!-- // end #page-content in footer.php -->
<?php get_footer(); ?>

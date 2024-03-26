<div class="container" id="in-slide">

	<button class="close" type="button">
		<span aria-hidden="true">×</span>
		<span class="sr-only"><?php _e('Close') ?></span>
	</button>

	<div class="in-image" style="background-image: url('<?php bloginfo('template_directory'); ?>/images/ing-panels/ing-ggs.jpg');"></div>

    <?php
		$prodPage = get_page_by_path( 'good-green-stuff' );
		 if (function_exists('icl_object_id')) {
    		$prodPage = get_page(icl_object_id($prodPage->ID, 'page', ICL_LANGUAGE_CODE));
		}
	?>

	<div class="row">
		<div class="col-md-12 text-center">
			<h1><?php the_field( 'ing_heading' ); ?></h1>
			<p><?php the_field( 'ing_description' ); ?></p>
		</div>
	</div>


	<div class="row in-content">
		<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

		<?php
			if ( have_rows( 'categories', $prodPage->ID ) ) :
            	$catNum = 0;

    		while ( have_rows( 'categories', $prodPage->ID ) ) : the_row();
				$catNum++;
		?>

			<div class="in-group ggs-<?php echo $catNum; ?>">
				<a id="ingredientsHeading<?php echo $catNum; ?>" class="panel-heading panel-title collapsed" role="tab" aria-controls="ingredients<?php echo $catNum; ?>" aria-expanded="false" href="#ingredients<?php echo $catNum; ?>" data-toggle="collapse"><?php the_sub_field( 'category') ?></a>
				<div id="ingredients<?php echo $catNum; ?>" class="panel-collapse collapse" aria-labelledby="ingredientsHeading<?php echo $catNum; ?>" role="tabpanel" aria-expanded="false">
                    <ul>

                    <?php if( have_rows( 'items' ) ) : while ( have_rows( 'items' ) ) : the_row(); ?>

                        <?php if( get_sub_field( 'sub-head' ) ) : ?>
                            <li class="ing-head">
                                <?php the_sub_field( 'name' ); ?>
                            </li>
                        <?php else : ?>
                            <li>
                            	<?php if( get_sub_field( 'description' ) ) : ?>
                                	<span data-toggle="tooltip" data-placement="top" title="<?php echo get_sub_field( 'description' ); ?>"><?php the_sub_field( 'name' ); ?></span>
                                <?php else : ?>
                                	<span><?php the_sub_field( 'name' ); ?></span>
                                <?php endif; ?>
                                <?php if( get_sub_field( 'nrv' ) ) : ?>
                                	<span data-toggle="tooltip" data-placement="top" title="<?php echo get_sub_field( 'nrv' ) . '% NRV'; ?>"><?php the_sub_field( 'amount' ); ?></span>
                                <?php else : ?>
                                	<span><?php the_sub_field( 'amount' ); ?></span>
                                <?php endif; ?>    
                            </li>
                        <?php endif; ?>

                    <?php endwhile; endif; ?>

                    </ul>
				</div>
			</div>

		<?php endwhile; endif; ?>

		</div>
	</div>

	<div class="row share">
		<div class="col-sm-5 col-md-4">
			<p><a class="btn btn-primary"><?php _e('Download PDF', 'nuzest-custom') ?></a></p>
		</div>
		<div class="hidden-xs hidden-sm col-md-2">
			<h4><?php _e('Share:', 'nuzest-custom') ?></h4>
		</div>
		<div class="col-sm-7 col-md-6">
			<?php echo do_shortcode( '[easy-social-share]' ) ?>
		</div>
	</div>

</div>

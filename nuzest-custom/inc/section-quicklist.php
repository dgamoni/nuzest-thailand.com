<section class="quick-list fill-bg-alt padd-xs">
    <div class="container">
        <div class="row">
			<?php if( have_rows('quick_list') ):
                $row = 0; ?>
                <div class="col-md-5 col-md-push-1 col-lg-4 col-lg-push-2">
                    <ul class="list-unstyled">
                    	<?php while( have_rows('quick_list') ): the_row();
                   		$row++; ?>
                        <li>
                            <div class="row">
                                <div class="col-xs-3 col-sm-2">
                                    <?php echo wp_get_attachment_image( get_sub_field('icon'), 'thumbnail', false, array('class'=>'img-responsive')); ?>
                                </div>

                                <div class="col-xs-9 col-sm-10">
                                    <h3><?php the_sub_field('item_heading'); ?></h3>
                                    <p><?php the_sub_field('item_sub_head'); ?></p>
                                    <p class="detail"><?php the_sub_field('item_detail'); ?></p>
                                    <p class="quick-arrow"></p>
                                </div>
                            </div>

                            <hr class="clear">
                        </li>
                    <?php if ( $row == 4 ) {
					echo '</ul></div><div class="col-md-5 col-md-push-1 col-lg-4 col-lg-push-2"><ul class="list-unstyled">'; }
					?>
                    <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

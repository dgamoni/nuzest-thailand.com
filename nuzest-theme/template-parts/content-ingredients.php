<?php

    $ilc_id = 0;

    $ing_query_args = array (
        'post_type' => 'ingredient_template',
        'post_status' => 'publish',
        'numberposts' => 1,
        'tax_query' => array(
            array(
                'taxonomy'  => 'product_cat',
                'field'     => 'term_id',
                'terms'     => $ingredient_list_category,
            )
        ),
    );

    $ingredient_post = get_posts($ing_query_args);

    foreach( $ingredient_post as $ipost ) {
        $ilc_id = $ipost->ID;
    }

    $fi_url = wp_get_attachment_url( get_post_thumbnail_id($ilc_id) );

    switch ($ingredient_list_category) {
        case 'good-green-stuff':
            $ingredientClass = 'ggs-';
            break;
        case 'clean-lean-protein':
            $ingredientClass = 'clp-';
            break;
        case 'kids-good-stuff':
            $ingredientClass = 'kgs-';
            break;
        default:
            $ingredientClass = 'ggs-';
            break;
    }

?>

<div class="container ingredients-list ingredients-list-container" id="in-slide" style="right: -100%;">

    <button class="close no-print" type="button">
        <span aria-hidden="true">x</span>
        <span class="sr-only">Close</span>
    </button>

    <div class="in-image" style="background-image: url('<?php echo $fi_url; ?>');"></div>

    <div class="hidden">
        <img src="<?php echo $fi_url; ?>" alt="">
    </div>

    <div style="height: 0px;overflow: hidden;">
        <img id="imageId" src="<?php echo $fi_url; ?>" alt="">
        <canvas id="imgCanvas"></canvas>
    </div>

    <div class="row">
        <div class="col-md-12 text-center no-print">
            <h1 class="ingredient-list-title" data-print-title="whats-in-good-green-stuff"><?php echo esc_html( get_the_title($ilc_id) ); ?></h1>
            <p><?php echo esc_html( get_the_excerpt($ilc_id) ); ?></p>
        </div>
		<div class="col-md-12 text-center hidden">
            <h1 class="ingredient-list-title" data-print-title="whats-in-good-green-stuff"><?php echo esc_html( get_the_title($ilc_id) ); ?></h1>
            <p><?php echo esc_html( get_the_excerpt($ilc_id) ); ?></p>
        </div>
    </div>

    <div class="row in-content">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 ing-test">

            <?php if( get_field('use_ingredients_posts', $ilc_id) == 'false' ): ?>
                <div class="no-print"><?php the_field('content', $ilc_id); ?></div>

                <!--<h3>PRINT BELOW</h3>-->

                <table class="in-group hidden ingredient-table it-custom">
                	<tr>
                		<td><?php the_field('content', $ilc_id); ?></td>
                	</tr>
                </table>

            <?php else: ?>

                <?php if( have_rows('ing_cat', $ilc_id) ):

                    $count = 1;

                    while ( have_rows('ing_cat', $ilc_id) ) : the_row(); ?>

                        <div class="in-group <?= $ingredientClass.$count; ?> no-print">
                        <span class="in-group-color-tab" style="background-color: <?php the_sub_field('colour'); ?>"></span>
                        <a id="ingredientsHeading<?= $count; ?>" class="panel-heading panel-title collapsed" role="tab" aria-controls="ingredients1" aria-expanded="false" href="#ingredients<?= $count; ?>" data-toggle="collapse"><?php the_sub_field('category'); ?></a>
                        <div id="ingredients<?= $count; ?>" class="panel-collapse collapse" aria-labelledby="ingredientsHeading1" role="tabpanel" aria-expanded="false" style="">
                            <?php if( have_rows('ingredients') ): ?>
                                <ul>
                                    <?php while( have_rows('ingredients') ): the_row(); ?>
                                        <?php if (get_sub_field('ingredient')): ?>
                                            <?php if (get_sub_field('sub_heading')) { ?>
                                                <li class="ing-head">
                                                    <?php the_sub_field('ingredient'); ?>
                                                </li>
                                            <?php } else { ?>
                                                <li>
                                                    <span data-title="<?php the_sub_field('description'); ?>" data-toggle="tooltip" data-placement="top"><?php the_sub_field('ingredient'); ?></span><?php } ?><span><?php the_sub_field('amount'); ?><?php if (get_sub_field('dv')) { ?> <small>(<?php the_sub_field('dv'); ?>% DV)</small></span>
                                                </li>
                                            <?php } ?>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        </div>
                        <span class="<?= $ingredientClass.$count; ?>-color hidden no-print"></span>

                        <table class="in-group <?= $ingredientClass.$count; ?> hidden ingredient-table">
                            <tr>
                                <th colspan="2"><?php the_sub_field('category'); ?></th>
                            </tr>
                            <?php if(have_rows('ingredients')): ?>
                                <?php while( have_rows('ingredients') ): the_row(); ?>
                                    <tr>
                                        <?php if(get_sub_field('sub_heading')) { ?>
                                            <td colspan="3"><?php the_sub_field('ingredient'); ?></td>
                                        <?php } else { ?>
                                            <td><?php the_sub_field('ingredient'); ?></td>
                                            <td><?php the_sub_field('amount'); ?></td>
                                            <td><?php the_sub_field('dv'); ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </table>

                        <?php $count++;

                    endwhile;

                    else :

                        // no rows found

                    endif; ?>

            <?php endif; ?>

        </div>
    </div>

    <div class="row no-print" style="margin-bottom: 45px;">
        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <div class="row">
                <!--<div class="col-xs-4 col-xs-offset-4"><a class="btn btn-primary print-ingredients" data-stylesheet-url="<?= get_template_directory_uri() . '/css/print/ingredients.css' ?>">-->
				<div class="col-xs-4 col-xs-offset-4"><a class="btn btn-primary print-ingredients" data-stylesheet-url="<?= get_template_directory_uri() . '/css/print/ingredients.css' ?>">
						<?php echo __('Print', 'nuzest-theme'); ?></a></div>
                <style>
                    .in-group-color-tab {
                        background-color: #d7df3a;
                        border: 1px solid #d6d6d6;
                        border-left: transparent;
                        bottom: -1px;
                        content: "";
                        display: block;
                        left: 0;
                        position: absolute;
                        top: -1px;
                        width: 10px;
                    }
                </style>
            </div>
        </div>
    </div>

</div>
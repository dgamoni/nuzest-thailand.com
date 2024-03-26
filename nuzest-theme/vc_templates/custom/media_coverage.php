<?php

add_shortcode("media_coverage", "media_coverage_shortcode");
add_action('vc_before_init', 'media_coverage_shortcode_vc');

function media_coverage_shortcode($atts) {

    extract(
        $attributes = shortcode_atts(
            array(
                'post_count' => -1,
            ), $atts
        )
    );

    $args = array(
        'post_type' => 'media',
        'posts_per_page' => $attributes['post_count'],
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'suppress_filters' => 0,
    );

    $posts = get_posts($args);
    ob_start();
    ?>

    <div id="media" class="snippets container">
        <div class="row">
            <?php
            foreach ($posts as $post) {
                echo outputMediaPost($post);
            }
            ?>
        </div>
        <div class='modal fade' id='viewMedia' tabindex='-1' role='dialog' aria-labelledby='viewMedia' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-label='<?php __('Close', 'nuzest-theme')?>'><span aria-hidden='true'>&times;</span></button>
                    <h5></h5>
                </div>
                <div class='modal-body'>
                    <!-- Moda content generated from /inc/snippet-media.php -->
                </div>
            </div>
        </div>
    </div>
</div>

    <?php
    return ob_get_clean();

}


function outputMediaPost($post) {
    $featuredImage = wp_get_attachment_url(get_post_thumbnail_id($post->ID, 'full'));
    $content = "";

    switch (get_field( 'custom-type' , $post->ID)) {
        case 'online':
            $href = get_field( 'custom-page_link' , $post->ID);
            break;
        case 'print-multi':
            $href = get_field( 'custom-print_multi' , $post->ID);
            break;
        default:
            $href = '#';
            break;
    }

    switch ( get_field( 'custom-type' , $post->ID) ) {
        case 'print-single': $single = get_field( 'custom-print_single' , $post->ID); /*$content .= '<img class="img-responsive" src="' . $single['url'] . '">';*/ break;
        case 'video': $content .= get_field( 'custom-youtube_link' , $post->ID); break;
    }

    ob_start();
    ?>
    <div class="col-sm-6 col-md-3">
        <article class="media-snippet snippet ">
			<?php
				if(empty($featuredImage)){
					$featuredImage = get_template_directory_uri(). "/images/default.jpg";
				}
			?>
            <img class="img-responsive" width="100%" src="<?= $featuredImage; ?>" alt="Nuzest in">
            <div style="display: none;" class="mediaContent">
				<?php 
					if ($content){
						echo $content;
					}
					else{
						echo "<img class='img-responsive' src=" . $featuredImage . " style='display:initial'>";
					}
				?>
                
            </div>
            <div class="info">
                <p><?= $post->date; ?></p>
                <h5 class="title"><?= $post->post_title; ?></h5>
                <p><?= ($post->post_excerpt) ? $post->post_excerpt : substr($post->post_content, 0, 100) . '..'; ?></p>
            </div>

            <a class="btn btn-primary <?= ($href == '#') ? 'mediaToggle' : '' ?>" <?= ($href == '#') ? '' : 'target="_blank"' ?>
               href="<?= $href ?>"><?= __('View') ?></a>
        </article>
    </div>
    <?php
    return ob_get_clean();
}

function media_coverage_shortcode_vc() {
    vc_map(
        array(
            'name' => __('Press Coverage', 'custom_elements'),
            'base' => 'media_coverage',
            'description' => __('Display press coverage snippets', 'custom_elements'),
            'category' => 'Nuzest Custom',
            'icon' => 'press-coverage-vc-icon',
            'content_element' => true,
            'params' => array(
                array(
                    "type" => "textfield",
                    "admin_label" => true,
                    "heading" => __("Display Items", 'custom_elements'),
                    "param_name" => "post_count",
                    'description' => "Number of items to display (will display all items if left blank)."
                )
            )
        )
    );
}


<?php

get_header();

?>
<section>
    <div class="container">
        <div class="row section-header">
            <div class="col-sm-12">
                <h1>Articles by <?= get_the_author(); ?></h1>
                <?php
                    $author_description = get_the_author_meta('description');
                    $author_id = get_the_author_meta('ID');
                    $has_profile = get_field('has_profile', 'user_'.$author_id);
                    $has_profile_object = get_field('profile_link', 'user_'.$author_id);

                    if($has_profile) {
                        $author_description = get_the_excerpt($has_profile_object->ID);
                    }
                ?>
                <h4><?= $author_description; ?></h4>

                <?php if($has_profile): ?>
                    <a data-author-id="<?=intval($has_profile_object->ID);?>" class="btn btn-primary" href="<?= get_author_posts_url(get_the_author_id()); ?>" data-show-modal="bio" data-profile-id="<?= get_the_author_id(); ?>"><?php _e('View Bio', 'nuzest-theme') ?></a>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>

<div class="vc_row wpb_row vc_row-fluid">
  <section class="snippets fill-bg-alt">
      <div class="container">
          <div class="row padd-30">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              <div class="col-md-3">
                  <?php
                      $thumbnail_id = get_post_thumbnail_id();
                      $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail-size', true );
                      $desc = get_the_content();
                      $trim_desc = wp_trim_words( $desc, $num_words = 18, $more = '&hellip; ' );
                  ?>
                  <article class="snippet active" style="height: 613px;">
                      <a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo $thumbnail_url[0]; ?>" alt="<?php the_title();?>"></a>
                      <div class="info">
                          <h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                          <p class="hidden-xs hidden-sm"><?php echo($trim_desc); ?></p>
                      </div>
                      <a class="btn btn-primary" href="<?php the_permalink(); ?>">View</a>
                  </article>
              </div>
          <?php endwhile; endif; ?>

      </div>
      </div>
  </section>
</div>

<?php 
get_footer(); 

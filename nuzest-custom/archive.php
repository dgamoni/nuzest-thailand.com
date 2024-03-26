<?php get_header(); ?>

    <div class="container">

<div class="row">
  <div class="col-md-12">
  <h1><?php _e('Archive Template','nuzest-custom') ?></h1>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="page-header">
      <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
    </div>
    <?php the_excerpt(); ?>
    
   <?php endwhile; endif; ?>
  </div>
</div>
<!-- /END ROW -->
</div>
<!-- /END CONTAINER -->

<?php get_footer(); ?>

<?php get_header(); ?>

<div class="container">
	<div class="row">
  		<div class="col-md-12">
    		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    		<div class="page-header">
      			<h1><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h1>
    		</div>
    		<?php the_content() ?>
    
    		<?php endwhile; else: ?>
    
    		<h1><?php _e('Oh No!', 'nuzest-custom') ?></h1>
    		<p><?php _e("This is embarassing, we can't find what you're looking for.", 'nuzest-custom') ?></p>
    
    		<?php endif; ?>
    
  		</div>
  		<!-- /END COLUMN -->
	</div>
	<!-- /END ROW -->
</div>
<!-- /END CONTAINER -->

<?php get_footer(); ?>

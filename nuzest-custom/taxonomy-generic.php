<?php 
/**
  Generic template for all recipe/post taxonomy archive pages
**/

global $wp_query;
$term = $wp_query->get_queried_object();
$title = sprintf(_x('Viewing All %s Posts', 'Taxonomy Archive Heading'), $term->name);

get_header();
?>
  <div class="container">
  
    <div class="row section-header">
      <div class="col-md-12">
        <h1><?php echo $title ?></h1>
      </div>
    </div>

    <div class="row">
      <?php 
      if ( have_posts() ) {
        while ( have_posts() ) {
          the_post();
          if (in_array(get_post_type(), array('recipes','post') ) ) {
            get_template_part( 'inc/content', 'snippets' );
          }
        }
      }
      ?>
    </div>
    <!-- /END ROW -->

    <div class="row row-pagination">
      <?php nz_numeric_pagination(); ?>
    </div>

  </div>
  <!-- /END CONTAINER -->

<?php get_footer(); ?>
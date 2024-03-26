<?php get_header(); ?>

<?php the_post(); 

$authorID = get_the_id();
$args = array(
	'post_type' => 'post',
	'order' => DESC,
	'posts_per_page' => 3,
	'meta_key' => 'author_profile',
	'meta_value' => $authorID
	);
$wp_query = new WP_Query($args);
?>

<section style="padding-top: 150px;" >
	<div class="container">
    	<div class="row">
        	<div class="col-md-12">
        		<h1><?php the_id(); ?><?php the_title(); ?></h1>
        		<h3 class="text-left" style="border-bottom: 1px solid green;" ><?php the_field( 'byline' ); ?></h3>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-6">
        		<?php the_content(); ?>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-6">
            	<ul class="list-unstyled contact-list">
                	<?php if ( get_field( 'email' ) ) { echo '<li class="email">' . get_field( 'email' ) . '</li>'; } ?>
                	<?php if ( get_field( 'website' ) ) { echo '<li class="website">' . get_field( 'website' ) . '</li>'; } ?>
                    <?php if ( get_field( 'facebook' ) ) { echo '<li class="facebook">' . get_field( 'facebook' ) . '</li>'; } ?>
                    <?php if ( get_field( 'twitter' ) ) { echo '<li class="twitter">' . get_field( 'twitter' ) . '</li>'; } ?>
                    <?php if ( get_field( 'google' ) ) { echo '<li class="google">' . get_field( 'google' ) . '</li>'; } ?>
                </ul>
            </div>
            <div class="col-md-6">
            	<?php if( $wp_query -> have_posts() ) : 
					$name = get_the_title();
					$firstname = strtok($name, " ");
                    echo '<h2>' . sprintf(__('Recent posts by %s', 'nuzest-custom'), $firstname) . '</h2>';
					while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            		<a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>
           		<?php endwhile; endif; wp_reset_query(); ?>
            </div>
        </div>
	</div>
</section>

<?php get_footer(); ?>

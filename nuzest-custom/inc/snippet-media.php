<?php 
	$thumbnail_id = get_post_thumbnail_id();
	$thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail-size', true );
?>

<article class="snippet media-snippet" id="media-1">
	<img class="img-responsive" width="100%" src="<?php echo $thumbnail_url[0]; ?>" alt="NuZest in <?php the_field( 'publication_name' ); ?>">
	
    <div class="info">
		<p><?php the_field( 'date' ); ?></p>
		<h5 class="title"><?php the_title(); ?></h5>
        <p><?php echo get_the_excerpt(); ?></p>
	</div>
        
	<div style="display: none;" class="mediaContent">
		<?php 
		switch ( get_field( 'type' ) ) {
			case 'print-single': $single = get_field( 'print_single' ); echo '<img class="img-responsive" src="' . $single['url'] . '">'; break;
			case 'video': echo get_field( 'youtube_link' ); break;
		}
		?>	
	</div>
    
    <?php if ( get_field( 'type' ) == 'online' ) { ?>
    	<a class="btn btn-primary" href="<?php the_field( 'page_link' ); ?>" target="_blank"><?php _e('View', 'nuzest-custom') ?></a>
    <?php } 
	elseif ( get_field( 'type' ) == 'print-multi' ) { ?>  
		<a class="btn btn-primary" href="<?php echo get_field( 'print_multi' ); ?>" target="_blank"><?php _e('View', 'nuzest-custom') ?></a>
    <?php } 
	else { ?>
		<a class="btn btn-primary mediaToggle" href="#"><?php _e('View', 'nuzest-custom') ?></a>
	<?php }; ?>
    
</article>

<?php session_start(); ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">
	<title>
        <?php wp_title( '|', true, 'right' ); ?>
        <?php bloginfo( 'name' ); ?>
  	</title>

	<?php wp_head(); ?>
	
</head>



<body <?php body_class(); ?>>

<?php global $post; ?>

<div id="loading-message" class="page-loading">
    <div class="loading-message-content" style="background: url('<?php echo get_template_directory_uri();?>/images/ring.svg') no-repeat center center / 80px;"></div>
</div>

<?php if ( is_page() ){ ?>
	<div id="page" class="<?php echo $post->post_name; ?>">
<?php } elseif ( is_single() ){ ?>
	<div id="page" class="single-<?php echo $post->post_type; ?>">
<?php } else { ?>
	<div id="page" class="content">
<?php } ?>

<!-- page template header content -->
<?php 
		if ( ! is_page_template( 'page-templates/page-blank.php' ) ) {
			get_template_part( 'template-parts/content', 'navigation' ); 
		}
?>	
		
		
	<main id="page-content" class="site-content">

	
	<!-- / OPEN main site container (closed in footer.php). Full width to allow for image overflow -->
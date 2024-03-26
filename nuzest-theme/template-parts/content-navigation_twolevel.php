	<?php
/**
 * Template part for displaying header navigation
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Nuzest_Theme
 */

?>

		<header id="masthead" class="site-header">
			<nav id="topNav" class="navbar navbar-default navbar-fixed-top" role="navigation">
						<div class="container">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#mainNav">
										<span class="nav-icon"></span>
									</button>
									
									<div class="mobileSearch">
										<a href="#" title="Search" class="menuSearchButton"><span class="glyphicon glyphicon-search"></span></a>
										<form role="search" method="get" id="mobileSearchForm" action="https://www.nuzest.com.au/" class="search-form">
											<input type="text" placeholder="SEARCH" name="s" id="s-mobile" class="form-control">
										</form>
									</div>

										<!-- navbar-brand -->
										<?php 
										if ( get_theme_mod( 'custom_logo' ) ) {
											$custom_logo_id = get_theme_mod( 'custom_logo' );
											$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
										} else {
											$logo = '/images/nuzest-logo.png';
										}
										?>
										<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
											<?php 
												if(strpos( $logo[0], 'logo' ) == false){
													echo "<img src=". get_template_directory_uri()."/images/nuzest-logo.png";
												}
												else{
													echo "<img src=". $logo[0];
												}
											?>

										</a>
								</div>

								<div class="navmenu navmenu-default navmenu-fixed-left offcanvas-sm" id="mainNav">
								<!-- top nav -->
											<?php 
											$args = array(
													'theme_location' => 'header-menu',
													'menu_id' 		 => 'menu-header-menu',
													'container'       => 'false',
													//'menu_class'	 => 'nav nav-pills pull-left',
													'menu_class'	 => 'nav nav-pills pull-right',
													'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
													'walker'          => new wp_bootstrap_navwalker()
											);
											wp_nav_menu( $args );
											?>
									<!-- main nav -->
										<?php
										$args = array(
												'theme_location' 	=> 'main-menu',
												'menu_id'		 			=> 'menu-main-menu',
												//'container'       => 'div',
												'container'       => 'false',
												'menu_class'	 		=> 'nav navbar-nav' /*navbar-left'*/,
												'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
												'walker'          => new wp_bootstrap_navwalker()
										);
										wp_nav_menu( $args );
										?>

								</div>
						</div><!-- .container -->
				</nav><!-- #topNav -->
		
		</header><!-- #masthead -->

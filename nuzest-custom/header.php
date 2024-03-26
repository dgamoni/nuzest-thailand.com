<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">
		<title>
			<?php wp_title( '|', true, 'right' ); ?>
			<?php bloginfo( 'name' ); ?>
		</title>
		<?php wp_head(); ?>
	</head>

	<?php $site_template = get_field( 'site_template', 'option' ); ?>
	<body <?php body_class( $site_template ); ?> >
    <!-- Google Tag Manager -->
    <noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-WX4MM9"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WX4MM9');</script>
    <!-- End Google Tag Manager -->
		<!-- Facebook -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=<?php echo _x('369559473095475','Facebook App ID') ?>&version=v2.3";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>


		<!-- NAVIGATION
		================================================== -->

		<nav id="mobileNav" class="navmenu navmenu-default navmenu-fixed-left offcanvas hidden-xl hidden-lg hidden-md" role="navigation">
			<?php
				$args = array(
					'menu'			=> 'mobile-menu',
					'menu_class'	=> 'nav navmenu-nav',
					'container'		=> 'false'
				);

				wp_nav_menu( $args );
			?>
		</nav>

		<nav id="topNav" class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<!-- hamburger menu -->
					<button type="button" class="navbar-toggle" data-toggle="offcanvas" data-target="#mobileNav" >
						<span class="nav-icon"></span>
					</button>

					<!-- search icon -->
					<div class="mobileSearch">
						<a href="#" title="Search" class="menuSearchButton"><span class="glyphicon glyphicon-search"></span></a>

						<form role="search" method="get" id="mobileSearchForm" action="<?php echo home_url('/'); ?>" class="search-form">
							<input type="text" placeholder="Search" name="s" id="s-mobile" class="form-control">
						</form>
					</div>
					<!-- logo -->
                    <a class="navbar-brand" href="<?php bloginfo( 'url' ); ?>"><img src="<?php bloginfo( 'template_directory' ); ?><?php if( $site_template == 'st-usa'){ echo '/images/nuzest-logo-or.png'; } else { echo '/images/nuzest-logo.png'; } ?>"></a>

					<!-- cart -->
					<div id="utilsNav">
						<?php
						$args = array(
							'theme_location' => 'header-menu',
							'menu_id' 		 => 'menu-header-menu',
							'menu_class'	 => 'nav navbar-nav navbar-right',
							'container'		 => false,
							'fallback_cb'	 => false,
							'items_wrap' 	 => menu_cart_wrap(),
						);
						wp_nav_menu( $args );
						?>
					</div>
				</div>


				<div id="mainNav" class="navbar-collapse collapse">
					<?php
					$args = array(
						'theme_location' => 'main-menu',
						'menu_id'		 => 'menu-main-menu',
						'menu_class'	 => 'nav navbar-nav navbar-right',
						'container'		 => false,
						'fallback_cb'	 => false,
					);
					wp_nav_menu( $args );
					?>
				</div>
			</div>
		</nav>

		<div id="page-content">
		<!-- / OPEN main site container (closed in footer.php). Full width to allow for image overflow -->

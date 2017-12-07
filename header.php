<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="wrapper">
	<a href="#main" class="sr-only sr-only-focusable skipnav"><?php _e('Skip to main content', 'basetheme'); ?></a>
	<header id="header" class="clearfix">
		<div class="container">
			<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="Home" class="logo"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>

			<nav class="navbar navbar-default">						
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav-container" aria-controls="main-nav-container" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			
				<div class="collapse navbar-collapse" id="main-nav-container">
					<?php
					/* 
						May need to remove the BootstrapNavMenuWalker and make menus a different way.
						This entire header/nav setup is from Bootstrap 3, haven't tested with Bootstrap 4 yet
					*/
					$args = array(
						'theme_location' => 'mainnav',
						'depth'		 => 0,
						'container'	 => false,
						'menu_class'	 => 'navbar-nav mr-auto',
						'menu_id' => 'main-nav',
						'walker'	 => new BootstrapNavMenuWalker()
					);
					wp_nav_menu($args);
				?>
				</div>
			</nav>
		</div>
	</header>
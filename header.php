<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
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

			<nav class="navbar navbar-expand-md navbar-light bg-light" role="navigation">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav-container" aria-controls="main-nav-container" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<?php
				wp_nav_menu(array(
					'theme_location' => 'mainnav',
					'depth' => 2,
					'container' => 'div',
					'container_class' => 'collapse navbar-collapse',
					'container_id' => 'main-nav-container',
					'menu_class' => 'nav navbar-nav',
					'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
					'walker' => new WP_Bootstrap_Navwalker(),
				));
				?>
			</nav>
		</div>
	</header>
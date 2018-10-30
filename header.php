<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section, wrapper, logo, and main navigation.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

?>
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
	<a href="#main" class="sr-only sr-only-focusable skipnav"><?php esc_attr_e( 'Skip to main content', 'basetheme' ); ?></a>
	<header id="header" class="clearfix">
		<div class="container-wide">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php get_bloginfo( 'name', 'display' ); ?>" rel="Home" class="logo">
				<?php echo bt_load_svg_from_media( get_field( 'logo', 'options' )['url'] ); ?>
			</a>

			<nav class="mainnav-navbar navbar navbar-expand-lg navbar-dark" role="navigation">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav-container" aria-controls="main-nav-container" aria-expanded="false" aria-label="Toggle navigation">
					<svg width="30px" height="30px" viewBox="0 0 30 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
						<rect class="navbar-bars-top" x="1" y="9" width="28" height="2"></rect>
						<rect class="navbar-bars-middle" x="1" y="9" width="28" height="2"></rect>
						<rect class="navbar-bars-btm" x="1" y="9" width="28" height="2"></rect>
					</svg>
				</button>
				<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'mainnav',
						'depth'           => 2,
						'container'       => 'div',
						'container_class' => 'collapse navbar-collapse',
						'container_id'    => 'main-nav-container',
						'menu_class'      => 'nav navbar-nav',
						'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
						'walker'          => new WP_Bootstrap_Navwalker(),
					)
				);
				?>
			</nav>
		</div>
	</header>

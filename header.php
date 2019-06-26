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
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
/**
 * Output "Custom Scripts (after body tag)" from the admin Site Settings.
 */
get_template_part( 'template-parts/header/part', 'scripts' );
?>
<div id="wrapper">
	<a href="#site-main" class="sr-only sr-only-focusable skipnav"><?php esc_attr_e( 'Skip to main content', 'basetheme' ); ?></a>
	<header id="site-header">
		<div class="container-wide container-md-none">
			<?php if ( function_exists( 'get_field' ) && get_field( 'logo', 'options' ) ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo get_bloginfo( 'name', 'display' ); ?>" rel="Home" class="logo-set" aria-label="<?php echo get_bloginfo( 'name', 'display' ); ?> logo">
				<span class="logo"><?php echo bt_load_svg_from_media( get_field( 'logo', 'options' )['url'] ); ?></span>
			</a>
			<?php endif; ?>
			<?php
			$utility_nav = wp_nav_menu(
				array(
					'echo'            => false,
					'theme_location'  => 'site-header-utility-nav',
					'depth'           => 1,
					'container'       => 'nav',
					'container_class' => 'nav-container',
					'container_id'    => 'site-header-utility-nav-container',
					'menu_class'      => 'nav navbar-nav',
					'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
					'walker'          => new WP_Bootstrap_Navwalker(),
				)
			);

			$main_nav = wp_nav_menu(
				array(
					'echo'            => false,
					'theme_location'  => 'site-header-main-nav',
					'depth'           => 2,
					'container'       => 'nav',
					'container_class' => 'nav-container',
					'container_id'    => 'site-header-main-nav-container',
					'menu_class'      => 'nav navbar-nav',
					'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
					'walker'          => new WP_Bootstrap_Navwalker(),
				)
			);
			?>
			<?php if ( $utility_nav || $main_nav ) : ?>
			<div class="navbar navbar-expand-lg" role="navigation" id="site-header-navbar-container">
				<div id="site-header-nav-menus" class="collapse navbar-collapse">
					<?php
					if ( $main_nav ) :
						echo $main_nav;
					endif;
					?>
					<?php
					if ( $utility_nav ) :
						echo $utility_nav;
					endif;
					?>
				</div>
			</div>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#site-header-nav-menus" aria-controls="header-nav-menus" aria-expanded="false" aria-label="Toggle navigation">
				<svg width="30px" height="21px" viewBox="0 0 30 21" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
					<rect class="navbar-bars-top" x="1" y="9" width="28" height="3" rx="2" transform="translate(0, -9)"></rect>
					<rect class="navbar-bars-middle" x="1" y="9" width="28" height="3" rx="2"></rect>
					<rect class="navbar-bars-btm" x="1" y="9" width="28" height="3" rx="2" transform="translate(0, 9)"></rect>
				</svg>
			</button>
			<?php endif; ?>
		</div>
	</header>
	<main id="site-main">

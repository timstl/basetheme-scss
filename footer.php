<?php
/**
 * The template for displaying the footer
 *
 * Contains the footer content and footer navigation, copyright, and closing tags
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

?>
	<footer role="contentinfo" id="site-footer">
		<div id="footer-inner">
			<nav id="footer-nav-container" class="nav-container">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footernav',
					'container'      => false,
					'menu_id'        => 'footer-nav',
				)
			);
			?>
			</nav>
			<?php bt_display_social_icons(); ?>
			<?php bt_copyright(); ?>
		</div>
	</footer>
<?php wp_footer(); ?>
</div>
</body>
</html>

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
	</main>
	<footer role="contentinfo" id="site-footer">
		<div class="container">
			<?php
			$footer_nav = wp_nav_menu(
				array(
					'echo'            => false,
					'theme_location'  => 'site-footer-main-nav',
					'depth'           => 1,
					'container'       => 'nav',
					'container_class' => 'nav-container',
					'container_id'    => 'site-footer-main-nav-container',
					'menu_class'      => 'nav',
					'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
					'walker'          => new WP_Bootstrap_Navwalker(),
				)
			);
			?>
			<?php if ( $footer_nav ) : ?>
			<div role="navigation" id="site-footer-navbar-container">
				<?php echo $footer_nav; ?>
			</div>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/footer/part', 'content' ); ?>
			
			<?php get_template_part( 'template-parts/part', 'socialaccounts' ); ?>
			
			<?php get_template_part( 'template-parts/footer/part', 'copyright' ); ?>
		</div>
	</footer>
<?php wp_footer(); ?>
</div>
</body>
</html>

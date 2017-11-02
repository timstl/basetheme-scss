<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>
	<footer role="contentinfo" id="site-footer">
		<div id="footer-inner">
			<nav id="footer-nav-container" class="nav-container">
			 	<?php wp_nav_menu( array( "theme_location" => "footernav", "container" => false, "menu_id" => "footer-nav" ) ); ?> 
			</nav>
			<div class="copyright">&copy; <?php echo date('Y'); ?></div>
		</div>
	</footer>
<?php wp_footer(); ?>
</div>
</body>
</html>
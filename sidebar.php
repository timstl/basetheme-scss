<?php
/**
 * The Sidebar containing the primary widget areas.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>
	<aside id="primary-sidebar-widget-area" class="sidebar">
		<ul class="widgets">
		<?php if ( ! dynamic_sidebar( 'primary-sidebar-widget-area' ) ) : endif; // end primary widget area ?>
		</ul>
	</aside>
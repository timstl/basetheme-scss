<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

if ( ! is_active_sidebar( 'blog-sidebar-widget-area' ) ) {
	return;
}
?>
<div id="blog-sidebar-widget-area" class="sidebar">
	<ul class="widgets">
		<?php dynamic_sidebar( 'blog-sidebar-widget-area' ); ?>
	</ul>
</div>

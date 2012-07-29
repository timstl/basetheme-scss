<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage BaseTheme
 */

get_header(); ?>
	<?php
	/* Run the loop to output the posts.
	 * If you want to overload this in a child theme then include a file
	 * called loop-index.php and that will be used instead.
	 */
	 get_template_part( 'loop', 'index' );
	?>
	<?php /* Display navigation to next/previous pages when applicable */ ?>
	<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<div id="pagination">
		<nav id="nav-below" class="pagenav">
			<ul>
			<li><?php next_posts_link( __( 'Older Posts', 'boilerplate' ) ); ?></li>
			<li><?php previous_posts_link( __( 'Newer Posts', 'boilerplate' ) ); ?></li>
			</ul>
		</nav><!-- #nav-below -->
	</div>
	<?php endif; ?>
<?php get_footer(); ?>
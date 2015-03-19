<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>
	<h1 class="pagetitle"><?php the_archive_title();?></h1>

	<?php get_template_part( 'loop', 'archive' ); ?>
	
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
<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>

				<h1 class="pagetitle"><?php
					printf( __( 'Category Archives: <em>%s</em>', 'boilerplate' ), '' . single_cat_title( '', false ) . '' );
				?></h1>
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) )
						echo '' . $category_description . '';

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				?>
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
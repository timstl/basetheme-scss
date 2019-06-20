<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

get_header(); ?>
<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
		?>
	</header><!-- .page-header -->

	<?php
	// Start the Loop.
	while ( have_posts() ) :
		the_post();

		/*
		 * Include the Post-Format-specific template for the content.
		 * If you want to override this in a child theme, then include a file
		 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
		 */
		get_template_part( 'template-parts/content', get_post_format() );

		// End the loop.
	endwhile;

	// Previous/next page navigation.
	the_posts_pagination(
		array(
			'prev_text'          => __( 'Previous page', 'basetheme' ),
			'next_text'          => __( 'Next page', 'basetheme' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'basetheme' ) . ' </span>',
		)
	);

	// If no content, include the "No posts found" template.
else :
	get_template_part( 'template-parts/content', 'none' );

endif;
?>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>

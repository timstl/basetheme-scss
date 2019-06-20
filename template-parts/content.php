<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title">', '</h2>' );
		}
		?>
	</header><!-- .entry-header -->

	<?php the_post_thumbnail(); ?>

	<section class="entry">
		<?php
		if ( is_single() ) {
			the_content();
		} else {
			the_excerpt();
		}
		?>
	</section><!-- .entry-content -->
</article><!-- #post-## -->

<?php
/**
 * The template used for displaying page content
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<?php the_post_thumbnail(); ?>

	<section class="entry">
		<?php the_content(); ?>
	</section>
</article>

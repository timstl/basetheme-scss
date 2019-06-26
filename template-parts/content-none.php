<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

?>
<article class="no-results not-found">
	<header>
		<h1 class="page-title"><?php _e( 'Nothing Found', 'basetheme' ); ?></h1>
	</header>

	<section class="entry">
		<?php if ( is_search() ) : ?>

			<p><?php esc_attr_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'basetheme' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_attr_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'basetheme' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</section>
</article>

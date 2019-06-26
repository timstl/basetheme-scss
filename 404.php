<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

get_header(); ?>
	<header class="page-header">
		<div class="container">
				<h1><?php _e( 'Not Found' ); ?></h1>
		</div>
	</header>
	<div class="container">
		<?php if ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'basetheme' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'basetheme' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
<?php
get_footer();

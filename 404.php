<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>
	<article id="post-0" class="post error404 not-found post-full" role="main">
		<h1><?php _e( 'Not Found', 'boilerplate' ); ?></h1>
		<p><?php _e( 'Apologies, but the page you requested could not be found. Perhaps searching will help.', 'boilerplate' ); ?></p>
		<?php get_search_form(); ?>
		<script>
			// focus on search field after it has loaded
			document.getElementById('s') && document.getElementById('s').focus();
		</script>
	</article>
</section>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
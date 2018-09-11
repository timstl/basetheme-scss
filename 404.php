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
<main id="main" class="site-main" role="main">
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
</main>
<?php
get_footer();

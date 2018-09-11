<?php
/**
 * The default template for displaying all pages
 *
 * This is the template that displays all pages by default.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

get_header(); ?>
<main id="main" class="site-main" role="main">
<?php
// Start the loop.
while ( have_posts() ) :
	the_post();

	// Include the page content template.
	get_template_part( 'template-parts/content', 'page' );

	// End of the loop.
endwhile;
?>
</main>

<?php
get_footer();

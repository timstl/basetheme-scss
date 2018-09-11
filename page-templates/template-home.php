<?php
/**
 * Template Name: Home
 *
 * Template file to use on homepage of site.
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

get_header(); ?>
<main id="main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>
	<?php
	while ( have_posts() ) :
		the_post();
	?>
	<article <?php post_class(); ?>>
		<?php the_content(); ?>
	</article>
	<?php endwhile; ?>

<?php else : ?>

	<?php get_template_part( 'template-parts/content', 'page' ); ?>

<?php endif; ?>
</main>

<?php get_footer(); ?>

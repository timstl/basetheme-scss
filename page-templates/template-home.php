<?php
/* Template Name: Home */

get_header(); ?>
<main id="main" class="site-main" role="main">
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class(); ?>>
		<?php the_content(); ?>
	</article>
	<?php endwhile; ?>

<?php else : ?>

	<?php get_template_part( 'template-parts/content', 'page' ); ?>

<?php endif; ?>
</main>

<?php get_footer(); ?>

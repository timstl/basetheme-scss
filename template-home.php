<?php
/* Template Name: Home */

get_header(); ?>
<section class="main">
	<div class="container">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<article <?php post_class(); ?>>
			<?php the_content(); ?>
		</article>
<?php endwhile; ?>

<?php else : ?>

	<?php get_template_part('part', 'notfound'); ?>

<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

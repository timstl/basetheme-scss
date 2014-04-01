<?php
/* Template Name: Home */

get_header(); ?>
<div class="innercontain">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<section id="content" role="main">
		<?php the_content(); ?>
	</section>
<?php endwhile; ?>

<?php else : ?>

<?php get_template_part('part', 'notfound'); ?>

<?php endif; ?>

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>

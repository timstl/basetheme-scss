<?php
/* Template Name: Home */

get_header(); ?>
<section class="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="row">
		<?php the_content(); ?>
	</div>
<?php endwhile; ?>

<?php else : ?>

<?php get_template_part('part', 'notfound'); ?>

<?php endif; ?>

</section>

<?php get_footer(); ?>

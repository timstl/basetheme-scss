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
<section class="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="innercontain">
		<?php the_content(); ?>
	</div>
<?php endwhile; ?>

<?php else : ?>

<?php get_template_part('part', 'notfound'); ?>

<?php endif; ?>

<?php get_sidebar(); ?>
</section>

<?php get_footer(); ?>

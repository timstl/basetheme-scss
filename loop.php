<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<article id="post-0" class="post error404 not-found">
		<div class="entry">
			<h2 class="entry-title"><?php _e( 'Not Found', 'boilerplate' ); ?></h2>
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'boilerplate' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-0 -->
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>		
		<div class="entry">
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'boilerplate' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<div class="postdate"><?php the_time('F j, Y'); ?></div>
			<?php if (has_post_thumbnail()) { ?><div class="featured"><?php the_post_thumbnail(); ?></div><?php } ?>
			<?php the_content(); ?>
		</div>
		<aside class="meta">
			<div class="social">
				<a href="<?php comments_link(); ?>" class="commentlink"><?php comments_number( '<span>0</span> Comments', '<span>1</span> Comment', '<span>%</span> Comments' ); ?></a>
			</div>
			<div class="catsntags">
				<?php the_category(', '); ?>
				<?php the_tags('',', ',''); ?>
			</div>
		</aside>
	</article>

	<?php comments_template( '', true ); ?>

<?php endwhile; ?>
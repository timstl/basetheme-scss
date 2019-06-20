<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_single() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		endif;
		?>
	</header><!-- .entry-header -->

	<?php
	if ( has_post_thumbnail() ) :
		if ( is_single() ) :
			the_post_thumbnail();
		else :
			?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail(); ?></a>
			<?php
		endif;
	endif;
	?>

	<section class="entry">
		<?php
		if ( is_single() ) :
			the_content();
		else :
			the_excerpt();
		endif;
		?>
	</section><!-- .entry-content -->
</article><!-- #post-## -->

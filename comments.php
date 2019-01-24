<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the current comments and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
		<?php
		$comments_number = get_comments_number();
		if ( 1 === $comments_number ) {
			/* translators: %s: post title */
			printf( _x( 'One reply on &ldquo;%s&rdquo;', 'comments title', 'basetheme' ), get_the_title() );
		} else {
			printf(
				/* translators: 1: number of comments, 2: post title */
				_nx(
					'%1$s thought on &ldquo;%2$s&rdquo;',
					'%1$s thoughts on &ldquo;%2$s&rdquo;',
					$comments_number,
					'comments title',
					'basetheme'
				),
				number_format_i18n( $comments_number ),
				get_the_title()
			);
		}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments(
					array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 42,
					)
				);
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_attr_e( 'Comments are closed.', 'basetheme' ); ?></p>
	<?php endif; ?>

	<?php
		comment_form(
			array(
				'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
				'title_reply_after'  => '</h2>',
			)
		);
	?>

</div><!-- .comments-area -->

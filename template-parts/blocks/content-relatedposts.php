<?php
/**
 * Block Name: Related Posts
 *
 * Posts related to the current post by categories and/or tags.
 * Contains both the block and support functions.
 */

 /**
  * Get category IDs of current post.
  */
if ( ! function_exists( 'bt_get_current_post_category_ids' ) ) {
	function bt_get_current_post_category_ids( $post_id ) {
		$cat_ids = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
		if ( empty( $cat_ids ) || is_wp_error( $cat_ids ) ) {
			return array();
		}
		if ( ! is_array( $cat_ids ) ) {
			$cat_ids = array( $cat_ids );
		}
		return $cat_ids;
	}
}

/**
 * Get tag IDs of current post.
 */
if ( ! function_exists( 'bt_get_current_post_tag_ids' ) ) {
	function bt_get_current_post_tag_ids( $post_id ) {
		$tag_ids = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );
		if ( empty( $tag_ids ) || is_wp_error( $tag_ids ) ) {
			return array();
		}
		if ( ! is_array( $tag_ids ) ) {
			$tag_ids = array( $cat_ids );
		}
		return $tag_ids;
	}
}
/**
 * Query related posts.
 */
if ( ! function_exists( 'bt_query_related_posts' ) ) {
	function bt_query_related_posts( $post_id, $num = 3, $use_cats = true, $use_tags = false, $criteria_rel = 'OR' ) {
		$args = array(
			'post_type'      => get_post_type( $post_id ),
			'post_status'    => 'publish',
			'posts_per_page' => $num,
			'orderby'        => 'date',
			'order'          => 'desc',
			'post__not_in'   => array( $post_id ),
		);

		$tag_ids = array();
		$cat_ids = array();

		if ( $use_cats ) {
			$cat_ids = bt_get_current_post_category_ids( $post_id );
		}

		if ( $use_tags ) {
			$tag_ids = bt_get_current_post_tag_ids( $post_id );
		}

		if ( ! empty( $cat_ids ) || ! empty( $tag_ids ) ) {
			$args['tax_query'] = array(
				'relation' => $criteria_rel,
			);
			if ( ! empty( $tag_ids ) ) {
				$args['tax_query'][] = array(
					'taxonomy' => 'post_tag',
					'field'    => 'term_id',
					'terms'    => $tag_ids,
				);
			}

			if ( ! empty( $cat_ids ) ) {
				$args['tax_query'][] = array(
					'taxonomy'         => 'category',
					'field'            => 'term_id',
					'terms'            => $cat_ids,
					'include_children' => false,
				);
			}

			return new WP_Query( $args );
		}
		return false;
	}
}

/**
 * Start block code.
 */

// Create id attribute for specific styling.
$block_id = 'relatedposts-' . $block['id'];

$classes = array( 'relatedposts' );

/**
 * Custom classes added in admin.
 */
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}

/**
 * Convert align class to Bootstrap containers.
 */
$align_class = $block['align'] ? 'align' . $block['align'] : '';
if ( ! $align_class ) {
	$align_class = 'alignfull';
} elseif ( $align_class == 'alignwide' ) {
	$align_class = 'container-wide';
} elseif ( $align_class == 'aligncenter' ) {
	$align_class = 'container';
}

$num          = intval( get_field( 'number_of_posts' ) );
$criteria     = get_field( 'criteria' );
$use_cats     = false;
$use_tags     = false;
$criteria_rel = get_field( 'criteria_relationship' );

if ( is_array( $criteria_rel ) ) {
	$criteria_rel = $criteria_rel[0];
}
if ( in_array( 'categories', $criteria ) ) {
	$use_cats = true;
}
if ( in_array( 'tags', $criteria ) ) {
	$use_tags = true;
}
if ( $criteria_rel != 'OR' ) {
	$criteria_rel = 'AND';
}

$c_query = bt_query_related_posts( $post_id, $num, $use_cats, $use_tags, $criteria_rel );

if ( $c_query && ! is_wp_error( $c_query ) && $c_query->have_posts() ) : ?>
<aside id="<?php echo esc_html( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="<?php echo $align_class; ?>">
		<?php
		while ( $c_query->have_posts() ) :
			$c_query->the_post();
			?>
		<article id="related-post-<?php the_ID(); ?>">
			<div class="post-cats"><?php the_category( ', ' ); ?></div>
			<h5 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
			<a href="<?php the_permalink(); ?>" class="btn btn-link btn-more"><?php esc_attr_e( 'Read More', 'basetheme' ); ?></a>
		</article>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</aside>
<?php elseif ( is_admin() ) : ?>
	<p><em><?php esc_attr_e( 'No related posts were found.', 'basetheme' ); ?></em></p>
	<?php
endif;

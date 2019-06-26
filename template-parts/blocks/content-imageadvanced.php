<?php
/**
 * Block Name: Image (Advanced)
 *
 * This is an advanced image field. Use if you need specifically styled images or additional HTML with an image.
 */

// Create id attribute for specific styling.
$image = get_field( 'image' );
if ( $image ) :
	$block_id = 'imageadvanced-' . $block['id'];

	$classes = array( 'wp-block-image', 'imageadvanced' );
	if ( isset( $block['align'] ) && ! empty( $block['align'] ) ) {
		$classes[] = 'align' . $block['align'];
	}

	/**
	 * Custom classes added in admin.
	 */
	if ( ! empty( $block['className'] ) ) {
		$classes[] = $block['className'];
	}

	$img_link    = false;
	$img_link_to = get_field( 'link_to' );
	if ( $img_link_to ) {
		if ( $img_link_to == 'media' ) {
			$img_link = $image['url'];
		} elseif ( $img_link_to == 'custom' && get_field( 'link_to_custom' ) ) {
			$img_link = get_field( 'link_to_custom' );
		}
	}

	$caption = wp_get_attachment_caption( $image['id'] );
	?>
	<figure id="<?php echo esc_html( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php if ( $img_link ) : ?>
		<a href="<?php echo esc_url( $img_link ); ?>"><?php echo wp_get_attachment_image( $image['id'], get_field( 'size' ) ); ?></a>
		<?php else : ?>
			<?php echo wp_get_attachment_image( $image['id'], get_field( 'size' ) ); ?>
		<?php endif; ?>

		<?php if ( $caption ) : ?>
		<figcaption><?php echo esc_attr( $caption ); ?></figcaption>
		<?php endif; ?>
	</figure>
<?php elseif ( is_admin() ) : ?>
	<p><em><?php esc_attr_e( 'Please add an image.', 'basetheme' ); ?></em></p>
<?php endif; ?>

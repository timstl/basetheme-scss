<?php
/**
 * Block Name: Button
 *
 * This is Bootstrap-style button.
 */

// Create id attribute for specific styling.
$block_id = 'buttonbootstrap-' . $block['id'];
$classes  = array( 'buttonbootstrap' );

/**
 * Custom classes added in admin.
 */
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}

if ( get_field( 'button_link' ) ) :

	$btn_class = array(
		'btn',
		get_field( 'button_style' ),
		get_field( 'button_size' ),
	);

	$target = '';
	$url    = esc_url( get_field( 'button_link' ) );

	if ( get_field( 'button_new_window' ) ) {
		$target = ' target="_blank"';
	}
	?>
	<div class="<?php esc_attr_e( implode( ' ', $classes ) ); ?>" id="<?php esc_attr_e( $block_id ); ?>">
		<a href="<?php echo esc_url( $url ); ?>" class="<?php esc_attr_e( implode( ' ', $btn_class ) ); ?>"<?php echo $target; ?>>
			<?php the_field( 'button_text' ); ?>
		</a>
	</div>
	<?php
elseif ( is_admin() ) :
	?>
<p><em><?php _e( 'Please add a button.' ); ?></em></p>
<?php endif; ?>

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

$link = get_field( 'button_link' );
if ( $link ) :
	$btn_class = array(
		'btn',
		get_field( 'button_style' ),
		get_field( 'button_size' ),
	);
	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" id="<?php echo esc_attr( $block_id ); ?>">
		<?php build_acf_link( $link, $btn_class ); ?> 
	</div>
	<?php
elseif ( is_admin() ) :
	?>
<p><em><?php esc_attr_e( 'Please add a button.', 'basetheme' ); ?></em></p>
<?php endif; ?>

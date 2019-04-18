<?php
/**
 * Block Name: Button
 *
 * This is bootstrap-style button with fancybox support.
 */

// Create id attribute for specific styling.
$block_id = 'buttonbootstrap-' . $block['id'];

if ( get_field( 'button_link' ) || ( get_field( 'button_fancybox_mode' ) && get_field( 'button_fancybox_content' ) ) ) :

	$class = array(
		'btn',
		get_field( 'button_style' ),
		get_field( 'button_size' ),
	);

	$datasrc  = '';
	$target   = '';
	$datatype = '';

	if ( get_field( 'button_fancybox_mode' ) && get_field( 'button_fancybox_content' ) ) {
		$url     = 'javascript:;';
		$datasrc = ' data-src="#' . $block_id . '-fancybox-block-content' . '"';
	} else {
		$url = esc_url( get_field( 'button_link' ) );
	}

	if ( get_field( 'button_fancybox_mode' ) ) {
		$class[] = 'fancybox';

		if ( get_field( 'button_fancybox_iframe_mode' ) ) {
			$datatype = ' data-type="iframe"';
		}
	}

	if ( get_field( 'button_new_window' ) ) {
		$target = ' target="_blank"';
	}
	?>
<div class="buttonbootstrap" id="<?php echo esc_attr( $block_id ); ?>">
	<a href="<?php echo esc_url( $url ); ?>" class="<?php esc_attr_e( implode( ' ', $class ) ); ?>"<?php echo $target . $datasrc . $datatype; ?>>
		<?php the_field( 'button_text' ); ?>
	</a>
</div>
<?php if ( $datasrc ) : ?>
<div class="fancybox-block-content" id="<?php echo esc_attr( $block_id ) . '-fancybox-block-content'; ?>">
	<?php the_field( 'button_fancybox_content' ); ?>							
</div>
<?php endif; ?>
<?php
elseif ( is_admin() ) :
?>
<p><em><?php _e( 'Please add a button.' ); ?></em></p>
<?php endif; ?>

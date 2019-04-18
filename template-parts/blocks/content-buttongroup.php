<?php
/**
 * Block Name: Button Group
 *
 * This is repeater field with images inside.
 */

// Create id attribute for specific styling.
$block_id = 'buttongroup-' . $block['id'];
// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? ' align' . $block['align'] : '';

$i = 1;

if ( have_rows( 'buttons' ) ) : ?>
<div id="<?php echo esc_html( $block_id ); ?>" class="buttongroup<?php echo $align_class; ?>">
	<div class="btn-group" role="group" aria-label="button group">
		<?php
		while ( have_rows( 'buttons' ) ) :
			the_row();

			$class = array(
				'btn',
				get_sub_field( 'style' ),
				get_sub_field( 'size' ),
			);

			$datasrc  = '';
			$target   = '';
			$datatype = '';
			$fbc_id   = '';

			if ( get_sub_field( 'button_fancybox_mode' ) && get_sub_field( 'button_fancybox_content' ) ) {
				$url     = 'javascript:;';
				$fbc_id  = esc_attr( $block_id ) . '-fancybox-block-content-' . $i;
				$datasrc = ' data-src="#' . $fbc_id . '"';
			} else {
				$url = esc_url( get_sub_field( 'link' ) );
			}

			if ( get_sub_field( 'button_fancybox_mode' ) ) {
				$class[] = 'fancybox';

				if ( get_sub_field( 'button_fancybox_iframe_mode' ) ) {
					$datatype = ' data-type="iframe"';
				}
			}

			if ( get_sub_field( 'new_window' ) ) {
				$target = ' target="_blank"';
			}
		?>
	<a href="<?php echo esc_url( $url ); ?>" class="<?php esc_attr_e( implode( ' ', $class ) ); ?>"<?php echo $target . $datasrc . $datatype; ?>>
		<?php the_sub_field( 'text' ); ?>
	</a>
	<?php if ( $datasrc ) : ?>
	<div class="fancybox-block-content" id="<?php echo $fbc_id; ?>">
		<?php the_sub_field( 'button_fancybox_content' ); ?>							
	</div>
	<?php endif; ?>
	<?php $i++; ?>
	<?php endwhile; ?>
	</div>
</div>
<?php
elseif ( is_admin() ) :
?>
<p><em><?php _e( 'Please add buttons.' ); ?></em></p>
<?php endif; ?>

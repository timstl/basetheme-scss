<?php
/**
 * Block Name: Button Group
 *
 * This is repeater field with images inside.
 */

// Create id attribute for specific styling.
$block_id = 'buttongroup-' . $block['id'];

$classes = array( 'buttongroup' );

/**
 * Custom classes added in admin.
 */
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}

if ( have_rows( 'buttons' ) ) : ?>
<div id="<?php echo esc_html( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="btn-group" role="group" aria-label="<?php the_field( 'button_group_aria_label' ); ?>">
		<?php
		while ( have_rows( 'buttons' ) ) :
			the_row();

			$btn_class = array(
				'btn',
				get_sub_field( 'style' ),
				get_sub_field( 'size' ),
			);

			$target = '';
			$url    = esc_url( get_sub_field( 'link' ) );

			if ( get_sub_field( 'new_window' ) ) {
				$target = ' target="_blank"';
			}
			?>
		<a href="<?php echo esc_url( $url ); ?>" class="<?php esc_attr_e( implode( ' ', $btn_class ) ); ?>"<?php echo $target; ?>>
			<?php the_sub_field( 'text' ); ?>
		</a>
	<?php endwhile; ?>
	</div>
</div>
	<?php
elseif ( is_admin() ) :
	?>
<p><em><?php _e( 'Please add buttons.' ); ?></em></p>
<?php endif; ?>

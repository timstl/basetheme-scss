<?php
/**
 * Block Name: Button Group
 *
 * This is repeater field with buttons inside, creating a Bootstrap button group.
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

$aria_label = get_field( 'button_group_aria_label' );
if ( ! $aria_label ) {
	$aria_label = 'button group';
}

if ( have_rows( 'buttons' ) ) : ?>
<div id="<?php echo esc_html( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="btn-group" role="group" aria-label="<?php echo esc_attr( $aria_label ); ?>">
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
		<a href="<?php echo esc_url( $url ); ?>" class="<?php echo esc_attr( implode( ' ', $btn_class ) ); ?>"<?php echo $target; ?>>
			<?php the_sub_field( 'text' ); ?>
		</a>
	<?php endwhile; ?>
	</div>
</div>
	<?php
elseif ( is_admin() ) :
	?>
<p><em><?php esc_attr_e( 'Please add buttons.', 'basetheme' ); ?></em></p>
<?php endif; ?>

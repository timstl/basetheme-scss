<?php
/**
 * Block Name: Card Deck
 *
 * This is repeater field with cards inside. Utilizes Bootstrap's Card Decks.
 */

// Create id attribute for specific styling.
$block_id = 'carddeck-' . $block['id'];
// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';

$classes = array( 'block-carddeck' );

/**
 * Custom classes added in admin.
 */
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}

/**
 * Convert align class to Bootstrap containers.
 */
if ( ! $align_class ) {
	$align_class = 'alignfull';
} elseif ( $align_class == 'alignwide' ) {
	$align_class = 'container-wide';
} elseif ( $align_class == 'aligncenter' ) {
	$align_class = 'container';
}

?>
<?php if ( have_rows( 'cards' ) ) : ?>
<div id="<?php echo esc_html( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="<?php echo $align_class; ?>">
		<div class="card-deck">
		<?php
		while ( have_rows( 'cards' ) ) :
			the_row();
			/**
			 * Create button HTML if we have one.
			 */
			$btn = '';
			if ( get_sub_field( 'card_add_button' ) ) {

				$button = get_sub_field( 'card_button' );
				if ( $button ) {

					$btn_class = array(
						'btn',
						$button['button_size'],
						$button['button_style'],
					);

					$btn_placement = get_sub_field( 'card_button_placement' );

					$btn = build_acf_link( $button['button_link'], $btn_class, false );
				}
			}

			/**
			 * Output the Card.
			 */
			?>
			<div class="card">
				<?php if ( get_sub_field( 'card_image' ) ) : ?>
					<?php echo wp_get_attachment_image( get_sub_field( 'card_image' ), 'thumbnail', false, array( 'class' => 'card-img-top' ) ); ?>
				<?php endif; ?>
				<?php if ( get_sub_field( 'card_header' ) ) : ?>
				<div class="card-header">
					<?php the_sub_field( 'card_header' ); ?>
				</div>
				<?php endif; ?>
				<?php if ( get_sub_field( 'card_body' ) || ( $btn && $btn_placement == 'body' ) ) : ?>
				<div class="card-body">
					<?php the_sub_field( 'card_body' ); ?>
					<?php
					if ( $btn && $btn_placement == 'body' ) {
						echo $btn;
					}
					?>
				</div>
				<?php endif; ?>
				<?php if ( get_sub_field( 'card_footer' ) || ( $btn && $btn_placement == 'footer' ) ) : ?>
				<div class="card-footer">
					<?php the_sub_field( 'card_footer' ); ?>
					<?php
					if ( $btn && $btn_placement == 'footer' ) {
						echo $btn;
					}
					?>
				</div>
				<?php endif; ?>
			</div>
			<?php
		endwhile;
		?>
		</div>
	</div>
</div>
	<?php
elseif ( is_admin() ) :
	?>
<p><em><?php esc_attr_e( 'Please add cards.', 'basetheme' ); ?></em></p>
<?php endif; ?>

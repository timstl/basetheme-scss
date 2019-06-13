<?php
/**
 * Block Name: Header
 *
 * This is flexible content field with header layouts
 */

// Create id attribute for specific styling.
$block_id = 'pageheader-' . $block['id'];

$classes = array( 'pageheader' );

/**
 * Substitute Bootstrap classes for alignwide/aligncenter.
 * Page headers should probably always be alignfull.
 */
$align_class = $block['align'] ? 'align' . $block['align'] : '';
if ( ! $align_class ) {
	$align_class = 'alignfull';
} elseif ( $align_class == 'alignwide' ) {
	$align_class = 'container-wide';
} elseif ( $align_class == 'aligncenter' ) {
	$align_class = 'container';
}
$classes[] = $align_class;


/**
 * Custom classes added in admin.
 */
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}

if ( have_rows( 'pageheader' ) ) :
	while ( have_rows( 'pageheader' ) ) :
		the_row();

		$layout = get_row_layout();

		$classes[] = 'pageheader--' . $layout;

		if ( get_sub_field( 'background_dim' ) && get_sub_field( 'background_dim' ) > 0 ) {
			$classes[] = 'has-background-dim';
			$classes[] = 'has-background-dim--' . intval( get_sub_field( 'background_dim' ) );
		}

		if ( get_sub_field( 'background_fixed' ) ) {
			$classes[] = 'pageheader--fixed';
		}

		if ( is_admin() ) {
			/**
			 * In case we have animation:
			 * This is a class we would toggle on the front-end, but always be present on the admin-side.
			 */
			$classes[] = ' inview';
		}

		?>
		<header id="<?php echo $block_id; ?>" class="<?php echo implode( ' ', $classes ); ?>">
			<div class="pageheader-text">
				<?php the_sub_field( 'content' ); ?>
			</div>
			<?php
			if ( get_sub_field( 'image' ) ) :
				if ( get_sub_field( 'background_position' ) ) {
					$position = get_sub_field( 'background_position' );
					/**
					 * ACF issue where we have seen both an array or string returned for this value.
					 * Possibly a bug in 5.8-beta that was fixed at some point?
					 */
					if ( is_array( $position ) ) {
						$position = $position[0];
					}
				} else {
					$position = 'center center';
				}
				?>
				<style type="text/css">
					#<?php echo $block_id; ?> {
						background-position: <?php echo wp_strip_all_tags( $position ); ?>;
						background-image: url(<?php echo esc_url( get_sub_field( 'image' )['url'] ); ?>);
					}
				</style>
			<?php endif; ?>
		</header>
		<?php
endwhile;
elseif ( is_admin() ) :
	?>
<p><em><?php _e( 'Please add a header layout.' ); ?></em></p>
	<?php
endif; ?>

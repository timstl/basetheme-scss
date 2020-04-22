<?php
/**
 * Block Name: Page Header
 *
 * This is flexible content field with page header layouts.
 * Most sites will need custom layouts: You can add them as flexible content fields, which allows you to keep one block.
 */

// Create id attribute for specific styling.
$block_id = 'pageheader-' . $block['id'];
$classes  = array( 'pageheader' );
$styles   = array();

/**
 * Custom classes added in admin.
 */
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}

if ( have_rows( 'pageheader' ) ) :
	while ( have_rows( 'pageheader' ) ) :
		the_row();

		$layout    = get_row_layout();
		$classes[] = 'pageheader--' . $layout;

		if ( get_sub_field( 'background_dim' ) && get_sub_field( 'background_dim' ) > 0 ) {
			$classes[] = 'pageheader--dim';
			$classes[] = 'pageheader--dim--' . intval( get_sub_field( 'background_dim' ) );
		}

		if ( is_admin() ) {
			/**
			 * In case we have animation:
			 * This is a class we would toggle on the front-end, but always be present on the admin-side.
			 */
			$classes[] = ' inview';
		}

		/**
		 * Does this block have a background image set?
		 */
		$image = get_sub_field( 'background_image' );
		if ( $image && isset( $image['url'] ) ) {
			$styles[] = 'background-image:url(' . esc_url( $image['url'] ) . ');';


			$position = get_sub_field( 'background_position' );
			if ( $position ) {
				/**
				 * ACF issue where we have seen both an array or string returned for this value.
				 * Possibly a bug in 5.8-beta that was fixed at some point?
				 */
				if ( is_array( $position ) ) {
					$position = $position[0];
				}

				$styles[] = 'background-position:' . wp_strip_all_tags( $position ) . ';';
			}
		}
		?>
		<header id="<?php echo $block_id; ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
			<?php
			/**
			 * Get this layout's template part.
			 */
			get_template_part( 'template-parts/blocks/pageheader/layout', $layout );
			?>
		</header>
		<?php
		/**
		 * Output this block's styles, if we have any.
		 */
		if ( ! empty( $styles ) ) :
			?>
		<style type="text/css">
			#<?php echo $block_id; ?> {
				<?php echo implode( '', $styles ); ?>
			}
		</style>
			<?php
		endif;
	endwhile;
	elseif ( is_admin() ) :
		?>
<p><em><?php esc_attr_e( 'Please add a header layout.', 'basetheme' ); ?></em></p>
		<?php
endif; ?>
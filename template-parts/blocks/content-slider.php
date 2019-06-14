<?php
/**
 * Block Name: Slider
 *
 * This is slider block powered by Slick Slider.
 */

$block_id = 'slider-' . $block['id'];
if ( have_rows( 'slider' ) ) :

	$classes = array( 'slick-slider-block' );

	/**
	 * Convert align class to Bootstrap containers.
	 */
	$align_class = $block['align'] ? 'align' . $block['align'] : '';
	if ( ! $align_class ) {
		$align_class = 'alignfull';
	} elseif ( $align_class == 'alignwide' ) {
		$align_class = 'container-wide';
	} elseif ( $align_class == 'aligncenter' ) {
		$align_class = 'container';
	}

	/**
	 * Pull some slider settings or set default values.
	 */
	$slider_mode    = get_field( 'slider_mode' );
	$autoplay       = (int) get_field( 'slider_timeout' );
	$dots           = (bool) get_field( 'slider_dots' );
	$arrows         = (bool) get_field( 'slider_arrows' );
	$center_mode     = false;
	$slides_to_scroll = 1;
	$slides_to_show   = 1;
	$responsive     = array();
	/**
	 * Adjust some args if we have a carousel, based on the # of slides to display.
	 */
	if ( $slider_mode == 'carousel' && get_field( 'slides_to_display' ) ) {
		$slides_to_show   = (int) get_field( 'slides_to_display' );
		$slides_to_scroll = $slides_to_show;

		/**
		 * Never 0.
		 */
		if ( $slides_to_scroll <= 0 ) {
			$slides_to_scroll = 1;
		}
	}

	/**
	 * Build slick slider args array.
	 */
	$args = array(
		'autoplay'       => ( $autoplay > 0 ) ? true : false,
		'autoplaySpeed'  => $autoplay,
		'dots'           => $dots,
		'arrows'         => $arrows,
		'slidesToShow'   => $slides_to_show,
		'slidesToScroll' => $slides_to_show,
		'prevArrow'      => '#' . $block_id . ' .slick-prev',
		'nextArrow'      => '#' . $block_id . ' .slick-next',
		'centerMode'     => $center_mode,
		'responsive'     => $responsive,
	);

	?>
<div id="<?php echo esc_html( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="<?php echo $align_class; ?>">
	<?php
	while ( have_rows( 'slider' ) ) :
		the_row();

		/**
		 * If the number of total slides equals the number of slides to show,
		 * we don't need dots or arrows.
		 */
		if ( count( get_sub_field( 'slides' ) ) === $slides_to_show ) {
			$args['dots']   = false;
			$args['arrows'] = false;
		}

		if ( get_row_layout() == 'images' || get_row_layout() == 'content' ) :

			$slider_classes = array(
				'slick-slider',
				'slick-slider--' . get_row_layout(),
				'slick-slider--' . $slider_mode,
			);

			if ( $args['dots'] ) {
				$slider_classes[] = 'slick-slider--hasdots';
			}
			if ( $args['arrows'] ) {
				$slider_classes[] = 'slick-slider--hasarrows';
			}
			?>
		<div class="<?php esc_attr_e( implode(' ', $slider_classes ) ); ?>" data-slick='<?php echo json_encode( $args ); ?>'>
			<?php
			$slider_slides = get_sub_field( 'slides' );

			/**
			 * No slides.
			 */
			if ( ! is_array( $slider_slides ) ) {
				continue;
			}

			/**
			 * Randomize slides?
			 */
			if ( get_field( 'slider_randomize' ) ) {
				shuffle( $slider_slides );
			}


			foreach ( $slider_slides as $slide ) : ?>
			<div class="slick-slide">
				<?php if ( $slide['image'] ) : ?>
				<div class="slick-slide-in">
					<?php echo wp_get_attachment_image( $slide['image'], 'full' ); ?>
				</div>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<?php 
		/**
		 * Arrows
		 */
		if ( $args['arrows'] !== false ) : ?>
		<button type="button" class="slick-prev" title="Previous"><?php _e( 'Previous', 'basetheme' ); ?></button>
		<button type="button" class="slick-next" title="Next"><?php _e( 'Next', 'basetheme' ); ?></button>
		<?php endif; ?>

	<?php endwhile; ?>
	</div>
</div>
	<?php
elseif ( is_admin() ) :
	?>
<p><em><?php _e( 'Please add a slider and slides.' ); ?></em></p>
<?php endif; ?>

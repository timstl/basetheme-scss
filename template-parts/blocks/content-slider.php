<?php
/**
 * Block Name: Slider
 *
 * This is slider block powered by Slick Slider.
 * https://kenwheeler.github.io/slick/
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
	 * Setup slider mode and default values.
	 */
	$slider_mode      = get_field( 'slider_mode' );
	$slider_speed     = (int) get_field( 'slider_timeout' );
	$slides_to_scroll = 1;
	$slides_to_show   = 1;

	/**
	 * Adjust some args if we have a carousel, based on the # of slides to display.
	 */
	if ( $slider_mode == 'carousel' && get_field( 'slides_to_show' ) ) {
		$slides_to_show   = (int) get_field( 'slides_to_show' );
		$slides_to_scroll = $slides_to_show;

		/**
		 * Never 0.
		 */
		if ( $slides_to_scroll <= 0 ) {
			$slides_to_scroll = 1;
		}
	}

	/**
	 * Build the slick slider $args array.
	 * The $args array is converted to JSON for use in the data-slick attribute.
	 * Slick Slider is initialized in /src/js/blocks/slider/block-slider.js, but the arguments are all pulled from this data attribute.
	 */
	$args = array(
		'autoplay'       => ( $slider_speed > 0 ) ? true : false,
		'autoplaySpeed'  => $slider_speed,
		'dots'           => (bool) get_field( 'slider_dots' ),
		'arrows'         => (bool) get_field( 'slider_arrows' ),
		'slidesToShow'   => $slides_to_show,
		'slidesToScroll' => $slides_to_show,
		'prevArrow'      => '#' . $block_id . ' .slick-prev',
		'nextArrow'      => '#' . $block_id . ' .slick-next',
		'responsive'     => array(),
	);

	/**
	 * Pull additional option settings from ACF.
	 */
	$additional_options_keys = array(
		'centerMode',
		'infinite',
		'adaptiveHeight',
		'variableWidth',
		'fade',
		'vertical',
	);

	foreach ( $additional_options_keys as $key ) {
		$args[ $key ] = (bool) get_field( 'slider_' . strtolower( $key ) );
	}

	/**
	 * Responsive example:
	 * Add an array of settings to $args['responsive'].
	 * Use bt_get_breakpoint to get a breakpoint from theme-helpers.php.
	 */

	/*
	$args['responsive'][] =
		array(
			'breakpoint' => (int) bt_get_breakpoint( 'sm', false, 1 ),
			'settings'   => array(
				'slidesToScroll' => 2,
				'slidesToShow'   => 2,
				'centerMode'     => false,
				'dots'           => $dots,
				'arrows'         => $arrows,
			),
		);
	*/
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

		$slider_type = get_row_layout();

		if ( $slider_type == 'images' || $slider_type == 'content' ) :

			$slider_classes = array(
				'slick-slider',
				'slick-slider--' . esc_attr( $slider_type ),
				'slick-slider--' . esc_attr( $slider_mode ),
			);

			if ( $args['dots'] ) {
				$slider_classes[] = 'slick-slider--hasdots';
			}
			if ( $args['arrows'] ) {
				$slider_classes[] = 'slick-slider--hasarrows';
			}
			?>
		<div class="<?php echo esc_attr( implode( ' ', $slider_classes ) ); ?>" data-slick='<?php echo json_encode( $args ); ?>'>
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


			foreach ( $slider_slides as $slide ) :
				?>
			<div class="slick-slide">
				<div class="slick-slide-in">
				<?php if ( $slider_type === 'images' ) : ?>
					<?php echo wp_get_attachment_image( $slide['image']['id'], 'full' ); ?>
				<?php else : ?>
					<?php echo $slide['content']; ?>
				<?php endif; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		<?php
		/**
		 * Arrows
		 */
		if ( $args['arrows'] !== false ) :
			?>
		<button type="button" class="slick-prev" title="Previous"><?php esc_attr_e( 'Previous', 'basetheme' ); ?></button>
		<button type="button" class="slick-next" title="Next"><?php esc_attr_e( 'Next', 'basetheme' ); ?></button>
		<?php endif; ?>

	<?php endwhile; ?>
	</div>
</div>
	<?php
elseif ( is_admin() ) :
	?>
<p><em><?php esc_attr_e( 'Please add a slider and slides.', 'basetheme' ); ?></em></p>
<?php endif; ?>

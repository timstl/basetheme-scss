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

	// Slider args
	$autoplay       = (int) get_field( 'slider_timeout' );
	$dots           = (bool) get_field( 'slider_dots' );
	$arrows         = (bool) get_field( 'slider_arrows' );
	$centerMode     = false;
	$slidesToScroll = 1;
	$slidesToShow   = 1;
	$responsive     = array();

	if ( get_field( 'slider_mode' ) == 'carousel' && get_field( 'slides_to_display' ) ) {
		$slidesToShow   = (int) get_field( 'slides_to_display' );
		$slidesToScroll = $slidesToShow;
		if ( $slidesToScroll <= 0 ) {
			$slidesToScroll = 1;
		}
	}

	$args = array(
		'autoplay'       => ( $autoplay > 0 ) ? true : false,
		'autoplaySpeed'  => $autoplay,
		'dots'           => $dots,
		'arrows'         => $arrows,
		'slidesToShow'   => $slidesToShow,
		'slidesToScroll' => $slidesToShow,
		'prevArrow'      => '#' . $block_id . ' .slick-prev',
		'nextArrow'      => '#' . $block_id . ' .slick-next',
		'centerMode'     => $centerMode,
		'responsive'     => $responsive,
	);

	?>
<div id="<?php echo esc_html( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="<?php echo $align_class; ?>">
	<?php
	while ( have_rows( 'slider' ) ) :
		the_row();

		// Only 1 slide, don't need controls.
		if ( count( get_sub_field( 'slides' ) ) === $slidesToShow ) {
			$args['dots']   = false;
			$args['arrows'] = false;
		}
		?>
		<?php
		if ( get_row_layout() == 'images' || get_row_layout() == 'content' ) :
			?>
		<div class="slick-slider slick-slider--<?php echo get_row_layout(); ?>
														<?php
														if ( $args['dots'] ) {
															?>
		 slick-slider--hasdots<?php } ?>" data-slick='<?php echo json_encode( $args ); ?>'>
			<?php
			$slider_slides = get_sub_field( 'slides' );
			if ( get_field( 'slider_randomize' ) && is_array( $slider_slides ) ) {
				shuffle( $slider_slides );
			}


			foreach ( $slider_slides as $slide ) :
				?>
			<div class="slick-slide">
				<?php
				if ( $slide['image'] ) :
					?>
				<div class="slick-slide-in">
					<?php echo wp_get_attachment_image( $slide['image'], 'full' ); ?>
				</div>
				<?php endif; ?>
			</div>
				<?php
			endforeach;
			?>
		</div>
			<?php
		endif;
		?>
		<?php if ( $args['arrows'] !== false ) : ?>
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

<?php
/**
 * Block Name: Accordion
 *
 * This is repeater field that creates a Bootstrap accordion/collapse component.
 */

// Create id attribute for specific styling.
$block_id = 'accordion-' . $block['id'];
$i        = 0;

$classes = array( 'accordion' );

/**
 * Custom classes added in admin.
 */
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}

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

if ( have_rows( 'accordion' ) ) : ?>
<div id="<?php echo esc_html( $block_id ); ?>" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<div class="<?php echo $align_class; ?>">
	<?php
	$show     = ' show';
	$expanded = 'true';

	while ( have_rows( 'accordion' ) ) :
		the_row();

		$accordion_id = esc_html( $block_id . '-' . $i );
		?>
		<div class="accordion-row">
			<div class="row align-items-center">
				<?php
				$col_content = 'col-md-20';
				$icon        = get_sub_field( 'icon' );
				if ( $icon && isset( $icon['url'] ) ) :
					$col_content = 'col-md-16';
					?>
				<div class="col col-20 col-md-4 col-accordion-icon order-1">
					<div class="accordion-icon">
						<?php
						echo bt_load_image_or_svg( $icon );
						?>
					</div>
				</div>
				<?php endif; ?>
				<div class="col col-24 <?php echo $col_content; ?> col-accordion-content order-3 order-md-2 nobtm">
					<h6 class="accordion-heading" id="<?php echo $accordion_id; ?>-heading"><?php the_sub_field( 'title' ); ?></h6>
					<div id="<?php echo $accordion_id; ?>-collapse" class="collapse accordion-content<?php echo $show; ?>" aria-labelledby="<?php echo $accordion_id; ?>-heading" data-parent="#<?php echo esc_html( $block_id ); ?>">
						<div class="in">
							<?php the_sub_field( 'content' ); ?>
						</div>
					</div>
				</div>
				<div class="col col-4 col-md-4 col-accordion-toggle order-2 order-md-3">
					<button type="button" class="accordion-toggle accordion-trigger" data-toggle="collapse" data-target="#<?php echo $accordion_id; ?>-collapse" aria-expanded="<?php echo $expanded; ?>" aria-controls="<?php echo $accordion_id; ?>-collapse">
						<span class="screen-reader-text"><?php esc_attr_e( 'Expand', 'basetheme' ); ?></span>
						<span class="accordion-expand">+</span>
					</button>					
				</div>
			</div>
		</div>
		<?php
		$expanded = 'false';
		$show     = '';
		$i++;
	endwhile;
	?>
	</div>
</div>
	<?php
elseif ( is_admin() ) :
	?>
<p><em><?php esc_attr_e( 'Please add accordions.', 'basetheme' ); ?></em></p>
<?php endif; ?>

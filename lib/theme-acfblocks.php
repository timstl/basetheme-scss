<?php
/**
 * The category slug for all custom acf blocks.
 */
define( 'BT_ACF_BLOCKS_CATEGORY', 'basetheme-blocks' );

/**
 * A keyword string that allows you to search for all of these blocks with 1 string.
 */
define( 'BT_ACF_BLOCKS_KEYWORD', 'basetheme' );

/**
 * The default ACF preview mode.
 * https://www.advancedcustomfields.com/resources/acf_register_block_type/
 */
define( 'BT_ACF_BLOCKS_MODE', 'auto' );

/**
 * Register ACF blocks
 */
function bt_acf_register_blocks() {

	// Check function exists
	if ( function_exists( 'acf_register_block' ) ) {
		// Add svg code for block icon.
		$icon = '';

		// Register button group block
		acf_register_block_type(
			array(
				'name'            => 'buttongroup',
				'title'           => __( 'Button Group' ),
				'description'     => __( 'A group of Bootstrap-style buttons.' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'button', 'button group', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,
			)
		);

		// Register button block
		acf_register_block_type(
			array(
				'name'            => 'buttonbootstrap',
				'title'           => __( 'Button (Bootstrap)' ),
				'description'     => __( 'A bootstrap-style button.' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'button', 'bootstrap', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,
			)
		);

		/**
		 * Disabled blocks.
		 * These blocks have starter files in template-parts/blocks/ and scss/blocks/custom/.
		 * By default they are disabled, so you have to uncomment below and uncomment the SCSS file in /scss/_blocks.scss
		 */

		/*
		// Page Header
		acf_register_block_type(
			array(
				'name'            => 'pageheader',
				'title'           => __( 'Page Header' ),
				'description'     => __( 'A page header with an image and content.' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'header', 'image', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,
				'align'           => 'full',
			)
		); */

		/*
		// Bootstrap Card Deck
		acf_register_block_type(
			array(
				'name'            => 'carddeck',
				'title'           => __( 'Card Deck' ),
				'description'     => __( 'A Bootstrap card deck.' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'card', 'deck', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,
				'align'           => 'center',
			)
		); 

		// Slider
		acf_register_block_type(
			array(
				'name'            => 'slider',
				'title'           => __( 'Slider' ),
				'description'     => __( 'A slider block.' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'header', 'image', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,
				'align'           => 'center',
				'enqueue_style'   => get_template_directory_uri() . '/dist/css/blocks/slick.css',
				'enqueue_script'  => get_template_directory_uri() . '/dist/js/blocks/block-slider.min.js',
			)
		);

		// Custom image
		acf_register_block_type(
			array(
				'name'            => 'imageadvanced',
				'title'           => __( 'Image (Advanced)' ),
				'description'     => __( 'An advanced image field. Use if you need specifically styled images or additional HTML with an image.' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'image', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,				
			)
		);*/
	}
}
add_action( 'acf/init', 'bt_acf_register_blocks' );

/**
 * Render ACF blocks
 */
function bt_acf_block_render_callback( $block, $content, $is_preview, $post_id ) {
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace( 'acf/', '', $block['name'] );

	// include a template part from within the "template-parts/block" folder
	if ( file_exists( get_theme_file_path( "/template-parts/blocks/content-{$slug}.php" ) ) ) {
		include get_theme_file_path( "/template-parts/blocks/content-{$slug}.php" );
	}
}

/**
 * Add block category for custom blocks.
 * Update title.
 */
function bt_register_block_categories( $categories, $post ) {
	return array_merge(
		array(
			array(
				'slug'  => BT_ACF_BLOCKS_CATEGORY,
				'title' => __( 'Basetheme Blocks', 'basetheme' ),
			),
		),
		$categories
	);
}
add_filter( 'block_categories', 'bt_register_block_categories', 10, 2 );

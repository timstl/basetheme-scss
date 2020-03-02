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
				'title'           => esc_attr__( 'Button Group', 'basetheme' ),
				'description'     => esc_attr__( 'A group of Bootstrap-style buttons.', 'basetheme' ),
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
				'title'           => esc_attr__( 'Button (Bootstrap)', 'basetheme' ),
				'description'     => esc_attr__( 'A bootstrap-style button.', 'basetheme' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'button', 'bootstrap', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,
			)
		);

		acf_register_block_type(
			array(
				'name'            => 'sociallinks',
				'title'           => esc_attr__( 'Social Links', 'basetheme' ),
				'description'     => esc_attr__( 'Output social account links from Site Settings.', 'basetheme' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'social', 'connect', BT_ACF_BLOCKS_KEYWORD ),
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
				'title'           => esc_attr__( 'Page Header', 'basetheme' ),
				'description'     => esc_attr__( 'A page header with an image and content.', 'basetheme' ),
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
				'title'           => esc_attr__( 'Card Deck', 'basetheme' ),
				'description'     => esc_attr__( 'A Bootstrap card deck.', 'basetheme' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'card', 'deck', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,
				'align'           => 'center',
			)
		); 
		// Custom image
		acf_register_block_type(
			array(
				'name'            => 'imageadvanced',
				'title'           => esc_attr__( 'Image (Advanced)', 'basetheme' ),
				'description'     => esc_attr__( 'An advanced image field. Use if you need specifically styled images or additional HTML with an image.', 'basetheme' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'image', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,				
			)
		);

		// Accordion
		acf_register_block_type(
			array(
				'name'            => 'accordion',
				'title'           => esc_attr__( 'Accordion', 'basetheme' ),
				'description'     => esc_attr__( 'A set of accordions.', 'basetheme' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'accordion', 'collapse', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,
			)
		);

		// Slider
		acf_register_block_type(
			array(
				'name'            => 'slider',
				'title'           => esc_attr__( 'Slider', 'basetheme' ),
				'description'     => esc_attr__( 'A slider block.', 'basetheme' ),
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

		// Related Posts
		acf_register_block_type(
			array(
				'name'            => 'relatedposts',
				'title'           => esc_attr__( 'Related Posts', 'basetheme' ),
				'description'     => esc_attr__( 'Display posts related to the current post\'s categories and/or tags.', 'basetheme' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'header', 'image', BT_ACF_BLOCKS_KEYWORD ),
				'mode'            => BT_ACF_BLOCKS_MODE,
				'align'           => 'center',
			)
		);
		*/
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
				'title' => esc_attr__( 'Basetheme Blocks', 'basetheme' ),
			),
		),
		$categories
	);
}
add_filter( 'block_categories', 'bt_register_block_categories', 10, 2 );

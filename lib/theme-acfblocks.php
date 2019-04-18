<?php
define( BT_ACF_BLOCKS_CATEGORY, 'basetheme-blocks' );
define( BT_ACF_BLOCKS_KEYWORD, 'basetheme' );

/**
 * Register ACF blocks
 */
function bt_acf_register_blocks() {

	// check function exists
	if ( function_exists( 'acf_register_block' ) ) {
		// svg code
		$icon = '';

		// register button group block
		acf_register_block(
			array(
				'name'            => 'buttongroup',
				'title'           => __( 'Button Group' ),
				'description'     => __( 'A group of Bootstrap-style buttons.' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'button', 'button group', BT_ACF_BLOCKS_KEYWORD ),
			)
		);

		// register button block
		acf_register_block(
			array(
				'name'            => 'buttonbootstrap',
				'title'           => __( 'Button (Bootstrap)' ),
				'description'     => __( 'A bootstrap-style button.' ),
				'render_callback' => 'bt_acf_block_render_callback',
				'category'        => BT_ACF_BLOCKS_CATEGORY,
				'icon'            => $icon,
				'keywords'        => array( 'button', 'bootstrap', BT_ACF_BLOCKS_KEYWORD ),
			)
		);
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
 * Update title if uncommenting.
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

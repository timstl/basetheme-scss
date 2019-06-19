<?php
/**
 * Any support functions unique to this site should be added here, if not in a plugin.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

if ( ! function_exists( 'bt_editor_add_theme_support' ) ) {
	/**
	 * Setup Gutenberg theme support.
	 */
	function bt_editor_add_theme_support() {
		add_theme_support( 'align-wide' );

		/**
		 * Setup color pallete used in Gutenberg sidebar.
		 * Add same hex colors from your Bootstrap variables.
		 */
		$palette = array(
		/*
		'primary'   => '',
		'secondary' => '',
		'success'   => '',
		'info'      => '',
		'warning'   => '',
		'danger'    => '',
		'gray-100'  => '',
		'gray-200'  => '',
		'gray-300'  => '',
		'gray-400'  => '',
		'gray-500'  => '',
		'gray-600'  => '',
		'gray-700'  => '',
		'gray-900'  => '',*/
		);

		if ( ! empty( $palette ) ) {
			$editor_palette = array();
			foreach ( $palette as $key => $value ) {
				if ( ! array_search( $value, array_column( $editor_palette, 'color' ) ) ) {
					$editor_palette[] = array(
						'name'  => __( $key . ' (' . $value . ')', 'basetheme' ),
						'slug'  => $key,
						'color' => $value,
					);
				}
			}

			add_theme_support( 'editor-color-palette', $editor_palette );
		}

		/**
		 * Setup font sizes.
		 */
		add_theme_support(
			'editor-font-sizes',
			array(
				array(
					'name' => __( 'Small', 'basetheme' ),
					'size' => 12,
					'slug' => 'small',
				),
				array(
					'name' => __( 'Normal', 'basetheme' ),
					'size' => 16,
					'slug' => 'normal',
				),
				array(
					'name' => __( 'Medium', 'basetheme' ),
					'size' => 20,
					'slug' => 'medium',
				),
				array(
					'name' => __( 'Large', 'basetheme' ),
					'size' => 36,
					'slug' => 'large',
				),
				array(
					'name' => __( 'Huge', 'basetheme' ),
					'size' => 48,
					'slug' => 'huge',
				),
			)
		);
	}
}
add_action( 'init', 'bt_editor_add_theme_support', 3 );

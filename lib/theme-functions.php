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
						'name'  => $key . ' (' . $value . ')',
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
					'name' => esc_attr__( 'Small', 'basetheme' ),
					'size' => 12,
					'slug' => 'small',
				),
				array(
					'name' => esc_attr__( 'Normal', 'basetheme' ),
					'size' => 16,
					'slug' => 'normal',
				),
				array(
					'name' => esc_attr__( 'Medium', 'basetheme' ),
					'size' => 20,
					'slug' => 'medium',
				),
				array(
					'name' => esc_attr__( 'Large', 'basetheme' ),
					'size' => 36,
					'slug' => 'large',
				),
				array(
					'name' => esc_attr__( 'Huge', 'basetheme' ),
					'size' => 48,
					'slug' => 'huge',
				),
			)
		);
	}
}
add_action( 'init', 'bt_editor_add_theme_support', 3 );

/**
 * Modify Tiny MCE Settings.
 * This is for ACF blocks that use the content editor.
 *
 * This is similar to what is done in the "Basetheme Modify Core Blocks" plugin, but is more likely to be modified in each theme.
 */
add_filter( 'mce_buttons_2', 'bt_theme_add_mce_buttons' );
add_filter( 'tiny_mce_before_init', 'bt_theme_modify_tiny_mce_style_formats' );

if ( ! function_exists( 'bt_theme_add_mce_buttons' ) ) {
	function bt_theme_add_mce_buttons( $buttons ) {
		if ( ! in_array( 'styleselect', $buttons ) ) {
			array_unshift( $buttons, 'styleselect' );
		}
		return $buttons;
	}
}

if ( ! function_exists( 'bt_theme_modify_tiny_mce_style_formats' ) ) {

	function bt_theme_modify_tiny_mce_style_formats( $settings ) {

		$style_formats = array();
		if ( isset( $settings['style_formats'] ) && $settings['style_formats'] != '' ) {
			if ( ! is_array( $settings['style_formats'] ) ) {
				$settings['style_formats'] = json_decode( $settings['style_formats'] );
			}
			$style_formats = $settings['style_formats'];
		}

		foreach ( array(
			'Primary'   => 'Primary',
			'Secondary' => 'Secondary',
			'Success'   => 'Success',
			'Info'      => 'Info',
			'Warning'   => 'Warning',
			'Danger'    => 'Danger',
		) as $key => $color ) {
			$style_formats[] = array(
				'title'    => 'Color: ' . $color . ' (' . $key . ')',
				'classes'  => 'color--' . strtolower( $key ),
				'selector' => 'p,h1,h2,h3,h4,h5,h6,li',
				'inline'   => false,
			);
		}

		foreach ( array( 'Small', 'Normal', 'Medium', 'Large', 'Huge' ) as $size ) {
			$style_formats[] = array(
				'title'    => 'Size: ' . $size,
				'classes'  => 'has-' . strtolower( $size ) . '-font-size',
				'selector' => 'p,h1,h2,h3,h4,h5,h6,li',
				'inline'   => false,
			);
		}

		/*
		Example of adding is-style-serif to the editor. You can then add this class to _utilities.scss.

		$style_formats[] = array(
		'title'    => 'Serif',
		'classes'  => 'is-style-serif',
		'selector' => 'p,h1,h2,h3,h4,h5,h6,li',
		'inline'   => false,
		);
		*/
		$settings['style_formats'] = json_encode( $style_formats );

		return $settings;
	}
}

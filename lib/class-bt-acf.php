<?php
/**
 * Creates General "Site Settings" ACF Options page
 * Hooks in to wp_head and wp_footer to output code.
 *
 * ACF Class
 */
class BT_ACF {

	/**
	 * Add actions.
	 */
	public static function hooks() {
		add_action( 'wp_head', array( 'BT_ACF', 'custom_output_prewphead' ), apply_filters( 'bth_custom_output_prewphead_priority', 0 ) );
		add_action( 'wp_head', array( 'BT_ACF', 'custom_output_wphead' ), apply_filters( 'bth_custom_output_head_priority', 9999 ) );
		add_action( 'wp_footer', array( 'BT_ACF', 'custom_output_wpfooter' ), apply_filters( 'bth_custom_output_footer_priority', 9999 ) );
	}

	/**
	 * Output at start of wp_head();
	 */
	public static function custom_output_prewphead() {
		self::custom_output( 'pre-wp_head' );
	}

	/**
	 * Output at end of wp_head();
	 */
	public static function custom_output_wphead() {
		self::custom_output( 'header' );
	}

	/**
	 * Output after opening body tag.
	 * This function isn't tied to a hook; Call from template partial:
	 * ./template-parts/header/part-scripts.php
	 * BT_ACF::custom_output_body();
	 */
	public static function custom_output_body() {
		self::custom_output( 'body' );
	}

	/**
	 * Output at end of wp_footer();
	 */
	public static function custom_output_wpfooter() {
		self::custom_output( 'footer' );
	}

	/**
	 * Pull ACF fields and output.
	 *
	 * @param string $location Field to display.
	 */
	private static function custom_output( $location = 'header' ) {
		if ( ! function_exists( 'the_field' ) ) {
			return;
		}

		if ( get_field( 'custom_' . $location . '_scripts', 'options' ) ) {
			the_field( 'custom_' . $location . '_scripts', 'options' );
			echo "\r\n";
		}

		if ( get_field( 'custom_' . $location . '_scripts' ) ) {
			the_field( 'custom_' . $location . '_scripts' );
			echo "\r\n";
		}
	}

	/**
	 * Create ACF options in the admin.
	 */
	public static function create_acf_pages() {
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				array(
					'page_title' => 'Site Settings',
					'menu_title' => 'Site Settings',
					'menu_slug'  => 'site-general-settings',
					'capability' => 'manage_options',
					'redirect'   => false,
				)
			);
		}
	}
}

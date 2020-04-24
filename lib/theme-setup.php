<?php
/**
 * This file contains theme setup such as sidebars, widgets, enqueing, etc.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

/**
 * Set the content width.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 960;
}

if ( ! function_exists( 'bt_setup_acf' ) ) {
	/**
	 * Require BT_ACF class, setup options page and hooks.
	 */
	function bt_setup_acf() {
		/**
		 * ACF Fields for theme.
		 * Create Site Settings options page + some hooks for outputting ACF fields.
		 * Does NOT include block functionality (see theme-acfblocks.php).
		 */
		require_once get_template_directory() . '/lib/class-bt-acf.php';
		BT_ACF::create_acf_pages();
		BT_ACF::hooks();
	}
}
add_action( 'after_setup_theme', 'bt_setup_acf' );

if ( ! function_exists( 'bt_setup' ) ) {
	/**
	 * Setup scripts, sidebars, menus, etc.
	 */
	function bt_setup() {

		/**
		 * Text domain
		 */
		load_theme_textdomain( 'basetheme', get_template_directory() . '/languages' );

		/**
		 * Match the default post thumbnail size to the $content_width.
		 * Add additional image sizes here if desired.
		 */
		global $content_width;
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( $content_width, 9999, false );
		// add_image_size( 'another-image-size', '250', '250', true );

		/**
		 * Class to handle bootstrap-style breadacrumbs.
		 * You can modify this class as needed if using breadcrumbs on this site.
		 *
		 * Usage:
		 * $breadcrumbs = new Bootstrap_Breadcrumbs();
		 * echo $breadcrumbs->bootstrap_breadcrumb();
		 */
		require_once get_template_directory() . '/lib/class-wp-bootstrap-breadcrumbs.php';

		/**
		 * Bootstrap Nav Walker
		 */
		require_once get_template_directory() . '/lib/class-wp-bootstrap-navwalker.php';

		/**
		 * Register a main, utility and footer nav.
		 * Consider disabling utility navigation if not in use.
		 */
		register_nav_menus(
			array(
				'site-header-utility-nav' => esc_attr__( 'Utility Navigation', 'basetheme' ),
				'site-header-main-nav'    => esc_attr__( 'Main Navigation', 'basetheme' ),
				'site-footer-main-nav'    => esc_attr__( 'Footer Navigation', 'basetheme' ),
			)
		);

		/**
		 * Add HTML5 theme support.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * Post Formats example. Not in use.
		 * add_theme_support( 'post-formats', array('aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat') );
		 */

		/**
		 * Add Automatic Feed Links.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * WordPress should handle <title></title>, not our header.php.
		 */
		add_theme_support( 'title-tag' );
	}
}
add_action( 'after_setup_theme', 'bt_setup' );

if ( ! function_exists( 'bt_widgets_init' ) ) {
	/**
	 *  Register widgetized areas.
	 */
	function bt_widgets_init() {
		register_sidebar(
			array(
				'name'          => esc_attr__( 'Blog Sidebar Widget Area', 'basetheme' ),
				'id'            => 'blog-sidebar-widget-area',
				'description'   => esc_attr__( 'The blog widget area', 'basetheme' ),
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget'  => '</li>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_attr__( 'Page Sidebar Widget Area', 'basetheme' ),
				'id'            => 'page-sidebar-widget-area',
				'description'   => esc_attr__( 'The page widget area', 'basetheme' ),
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget'  => '</li>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'bt_widgets_init' );

if ( ! function_exists( 'bt_fonts' ) ) {
	/**
	 * Enqueue fonts by adding URLs to the $fonts array.
	 * Use a single function because these will load in the admin and front-end.
	 * Call this function from your enqueue functions.
	 */
	function bt_fonts() {
		/**
		 * An array of URLs.
		 */
		$fonts = array(
			// 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,600,600i&display=swap',
		);

		if ( ! empty( $fonts ) ) {
			$i = 1;
			foreach ( $fonts as $url ) {
				wp_enqueue_style( 'bt-fonts-' . $i, $url, array(), '1.0' );
				$i++;
			}
		}
	}
}

if ( ! function_exists( 'bt_enqueue' ) ) {
	/**
	 * Enqueue scripts and styles.
	 */
	function bt_enqueue() {

		/**
		 * Enqueue fonts. Add wp_enqueue_style lines above.
		 */
		bt_fonts();

		wp_enqueue_style( 'bt-base-style', get_template_directory_uri() . '/dist/css/style.css', array(), '1.0' );

		/**
		 * Use latest jQuery.
		 */
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', get_template_directory_uri() . '/dist/js/jquery.min.js', array(), '3.4.1', false );
		wp_enqueue_script( 'jquery' );

		/**
		 * Previously, Gravity Forms would throw an error without jQuery Migrate.
		 * That doesn't seem to be the case any longer? Leaving this comment here until it's confirmed there are no issues.
		 */
		// wp_enqueue_script( 'jquery-migrate' );

		/**
		 * Enqueue comment-reply script if needed.
		 */
		if ( is_singular() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		/**
		 * Enqueue scripts in head.
		 * This is a concatinated, minified file of scripts from ./src/js/head/
		 */
		wp_enqueue_script( 'bt-head', get_template_directory_uri() . '/dist/js/head.min.js', array(), '1.0', false );

		/**
		 * Enqueue scripts in footer.
		 * This is a concatinated, minified file of scripts from ./src/js/footer/
		 */
		wp_enqueue_script( 'bt-scripts', get_template_directory_uri() . '/dist/js/scripts.min.js', array(), '1.0', true );
	}
}
add_action( 'wp_enqueue_scripts', 'bt_enqueue' );

if ( ! function_exists( 'bt_enqueue_block_editor_assets' ) ) {
	/**
	 * Enqueue scripts and styles in admin.
	 */
	function bt_enqueue_block_editor_assets() {
		// Enqueue fonts.
		bt_fonts();
		wp_enqueue_style( 'bt-editor-styles', get_template_directory_uri() . '/dist/css/editor-styles.css', null, '1.0' );
	}
}
add_action( 'enqueue_block_editor_assets', 'bt_enqueue_block_editor_assets' );

if ( ! function_exists( 'bt_override_mp6_tinymce_styles' ) ) {
	/**
	 * Add custom styles to ACF wysiwyg editor.
	 */
	function bt_override_mp6_tinymce_styles( $mce_init ) {

		// make sure we don't override other custom <code>content_css</code> files
		$content_css = get_template_directory_uri() . '/dist/css/editor-styles.css';
		if ( isset( $mce_init['content_css'] ) ) {
			$content_css .= ',' . $mce_init['content_css'];
		}

		$mce_init['content_css'] = $content_css;

		return $mce_init;
	}
	add_filter( 'tiny_mce_before_init', 'bt_override_mp6_tinymce_styles' );
}

<?php
/**
 * This file contains generic support functions that are used by the theme or often used on sites.
 * These functions were not deemed appropriate for basetheme-helper-plugin for one reason or another.
 * They are unlikely to be changed or modified (much), so are separated from theme-functions.php.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

if ( ! function_exists( 'bt_get_breakpoint' ) ) {
	/**
	 * CSS breakpoints: Make sure these match your Bootstrap variables.
	 * This function is useful for writing custom media queries in your ACF blocks.
	 */
	function bt_get_breakpoint( $size, $append_px = true, $adjust = 0 ) {

		$unit = '';
		if ( $append_px ) {
			$unit = 'px';
		}

		$breakpoint = array(
			'xs' => '0',
			'sm' => ( 576 + $adjust ) . $unit,
			'md' => ( 768 + $adjust ) . $unit,
			'lg' => ( 1024 + $adjust ) . $unit, // Changed from Bootstrap defaults to Kadence plugin.
			'xl' => ( 1200 + $adjust ) . $unit,
		);

		return $breakpoint[ $size ];
	}
}

if ( ! function_exists( 'bt_log' ) ) {
	/**
	 * Logging function.
	 * In wp-config.php define the WP_DEBUG_LOG constant: define('WP_DEBUG_LOG', true);
	 *
	 * You can then use this function anywhere in your themes or plugin:
	 *
	 * bt_log("log message here");
	 *
	 * This will write to wp-content/debug.log.
	 * In terminal: tail -f debug.log
	 *
	 * @param string|int|object|array $log Debug info to log.
	 */
	function bt_log( $log ) {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

if ( ! function_exists( 'alt_title' ) ) :
	/**
	 * Use instead of the_title in some cases, if you want more flexibility.
	 * Checks for alt_title custom field. Uses the_title if none exists.
	 * Can either return or echo the title.
	 * Uses current post in the loop, or a $post->ID passed in as second parameter.
	 *
	 * @param boolean     $echo Echo or return.
	 * @param int|boolean $pid Post ID or false.
	 */
	function alt_title( $echo = true, $pid = false ) {
		if ( ! $pid ) {
			global $post;
			$pid = $post->ID;
		}

		$title = get_post_meta( $pid, 'alt_title', true );
		if ( ! $title ) {
			$title = get_the_title( $pid );
		}

		if ( ! $echo ) {
			return apply_filters( 'the_title', $title );
		} else {
			echo esc_attr( apply_filters( 'the_title', $title ) );
		}
	}
endif;

if ( ! function_exists( 'bt_load_image_or_svg' ) ) :
	/**
	 * Load an SVG or image from media uploads.
	 *
	 * @param array An image array from ACF or other media array.
	 *
	 * @return string  The SVG contents or an image tag.
	 */
	function bt_load_image_or_svg( $image ) {

		if ( isset( $image['url'] ) ) {
			$ext = strtolower( pathinfo( $image['url'], PATHINFO_EXTENSION ) );

			if ( $ext == 'svg' ) {
				return bt_load_svg_from_media( $image['url'] );
			}
		}

		if ( isset( $image['id'] ) ) {
			return wp_get_attachment_image( $image['id'] );
		}
	}
endif;

if ( ! function_exists( 'bt_load_svg_from_media' ) ) :
	/**
	 * Loads an SVG from media uploads.
	 *
	 * @param string $url Site URL.
	 *
	 * @return string  The SVG contents.
	 */
	function bt_load_svg_from_media( $url ) {
		$filepath = ABSPATH . str_replace( home_url(), '', $url );

		if ( file_exists( $filepath ) ) {
			return file_get_contents( $filepath );
		}

		return '';
	}
endif;

if ( ! function_exists( 'bt_load_svg' ) ) :
	/**
	 * Load an SVG from the theme directory
	 *
	 * @param string  $file File path appended to the template directory or url. Start path with /
	 * @param boolean $from_url Use a theme URL instead of directory.
	 */
	function bt_load_svg( $file = '', $from_url = false ) {
		if ( $from_url ) {
			$path = get_template_directory_uri();
		} else {
			$path = get_template_directory();
		}

		if ( ! $file || ( ! $from_url && ! file_exists( $path . $file ) ) ) {
			return '';
		}

		return file_get_contents( $path . $file );
	}
endif;

if ( ! function_exists( 'bt_classes' ) ) :
	/**
	 * Build conditional classes for an element.
	 * Checks if a value exists, and appends the key as a classname if it does.
	 * The intended use is with ACF True/False fields, but any function that returns a truthy/falsey result would work.
	 *
	 * Example usage:
	 *
	 * <div class="<?php bt_classes( 'someclass', array( 'someclass--classtwo' => get_field( 'field_name' ) ) ); ?>">
	 */
	function bt_classes( $classes = array(), $conditional_classes = array(), $echo = true ) {

		if ( ! is_array( $classes ) ) {
			$classes = array( $classes );
		}

		if ( is_array( $conditional_classes ) && ! empty( $conditional_classes ) ) {
			foreach ( $conditional_classes as $key => $value ) {
				if ( ! $value ) {
					continue;
				}
				$classes[] = $key;
			}
		}

		$classes = array_map( 'wp_strip_all_tags', $classes );

		if ( ! $echo ) {
			return implode( ' ', $classes );
		}

		echo esc_attr( implode( ' ', $classes ) );
	}
endif;

/**
 * HOOKS
 *
 * Some disabled by default.
 */

if ( ! function_exists( 'bt_mime_types' ) ) {
	/**
	 * Allow upload of SVGs to media library.
	 */
	function bt_mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
}
add_filter( 'upload_mimes', 'bt_mime_types' );

if ( ! function_exists( 'boilerplate_excerpt_length' ) ) {
	/**
	 * Sets the post excerpt length to 40 characters.
	 *
	 * TO ENABLE: add_filter( 'excerpt_length', 'boilerplate_excerpt_length' );
	 *
	 * @param int $length Integer length passed into function.
	 */
	function boilerplate_excerpt_length( $length ) {
		return 40;
	}
}

if ( ! function_exists( 'boilerplate_category_id_class' ) ) {
	/**
	 * Add category nicenames in body and post class
	 *
	 * TO ENABLE: add_filter('post_class', 'boilerplate_category_id_class');
	 * TO ENABLE: add_filter('body_class', 'boilerplate_category_id_class');
	 *
	 * @param array $classes Classes passed into hook.
	 */
	function boilerplate_category_id_class( $classes ) {
		global $post;
		foreach ( ( get_the_category( $post->ID ) ) as $category ) {
			$classes[] = $category->category_nicename;}
		return $classes;
	}
}

if ( ! function_exists( 'bt_custom_body_class' ) ) {
	/**
	 * AAppend class to body if one added to the admin.
	 *
	 * @param array $classes Classes passed into hook.
	 */
	function bt_custom_body_class( $classes ) {
		global $post;
		if ( ! isset( $post->ID ) ) {
			return $classes;
		}
		if ( function_exists( 'get_field' ) ) {
			$page_class = get_field( 'page_class', $post->ID );
			if ( $page_class ) {
				$classes[] = esc_attr( $page_class );
			}
		}
		return $classes;
	}
}
add_filter( 'body_class', 'bt_custom_body_class' );

if ( ! function_exists( 'bt_custom_oembed_filter' ) ) {
	/**
	 * Responsive Embed filter. Assumes 16:9
	 *
	 * @param string $html HTML passed into filter.
	 */
	function bt_custom_oembed_filter( $html ) {
		return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
	}
}
add_filter( 'embed_oembed_html', 'bt_custom_oembed_filter', 10, 4 );

if ( ! function_exists( 'boilerplate_continue_reading_link' ) ) {
	/**
	 * Returns a "Continue Reading" link.
	 */
	function boilerplate_continue_reading_link() {
		return ' <a href="' . get_permalink() . '">' . esc_attr__( 'Continue reading <span class="meta-nav">&rarr;</span>', 'basetheme' ) . '</a>';
	}
}

if ( ! function_exists( 'boilerplate_auto_excerpt_more' ) ) {
	/**
	 * Returns a "Continue Reading" link for excerpts.
	 */
	function boilerplate_auto_excerpt_more() {
		return '&hellip; ' . boilerplate_continue_reading_link();
	}
}
add_filter( 'excerpt_more', 'boilerplate_auto_excerpt_more' );

if ( ! function_exists( 'boilerplate_custom_excerpt_more' ) ) {
	/**
	 * Hook into get_the_excerpt and add continue reading link.
	 *
	 * @param string $output Output passed into filter.
	 */
	function boilerplate_custom_excerpt_more( $output ) {
		if ( has_excerpt() && ! is_attachment() ) {
			$output .= boilerplate_continue_reading_link();
		}
		return $output;
	}
}
add_filter( 'get_the_excerpt', 'boilerplate_custom_excerpt_more' );

if ( ! function_exists( 'bt_yoasttobottom' ) ) {
	/**
	 *  Move Yoast to bottom
	 */
	function bt_yoasttobottom() {
		return 'low';
	}
}
add_filter( 'wpseo_metabox_prio', 'bt_yoasttobottom' );

if ( ! function_exists( 'build_acf_link' ) ) {
	/**
	 * Build an achor link from an ACF link field (assumes array is passed).
	 *
	 * @param array        $link ACF link array.
	 * @param array|string $classes Array or string of classes to add to link.
	 * @param boolean      $echo Echo or return the link.
	 */
	function build_acf_link( $link = array(), $classes = array(), $echo = true ) {
		if ( ! $link || empty( $link ) ) {
			return false;
		}

		if ( $classes && ! is_array( $classes ) ) {
			$classes = array( $classes );
		}

		$target = '';
		if ( isset( $link['target'] ) && ! empty( $link['target'] ) ) {
			$target = ' target="' . esc_attr( $link['target'] ) . '"';

			if ( $link['target'] == '_blank' ) {
				$target .= ' rel="noopener noreferrer"';
			}
		}

		$class = '';
		if ( ! empty( $classes ) ) {
			$class = ' class="' . esc_attr( implode( ' ', $classes ) ) . '"';
		}

		$html = '<a href="' . esc_url( $link['url'] ) . '"' . $class . $target . '>' . esc_attr( $link['title'] ) . '</a>';

		if ( ! $echo ) {
			return $html;
		}

		echo $html;
	}
}

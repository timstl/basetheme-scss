<?php
/**
 * This file contains generic support functions that are used by the theme or often used on sites.
 * These functions were not deemed appropriate for basetheme-helper-plugin for one reason or another.
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
	 */
	function bt_get_breakpoint( $size ) {
		$breakpoint = array(
			'xs' => '0',
			'sm' => '576px',
			'md' => '768px',
			'lg' => '992px',
			'xl' => '1200px',
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

/**
 * Output copyright with dynamic year
 *
 * @param string $before Append HTML or string before copyright.
 * @param string $after Append HTML or string after copyright.
 */

if ( ! function_exists( 'bt_copyright' ) ) :
	function bt_copyright( $before = '', $after = '' ) {
		if ( ! function_exists( 'get_field' ) ) {
			return '';
		}

		if ( get_field( 'footer_copyright', 'options' ) ) :
			echo $before;
			?>
		<span class="copyright">
			<?php echo str_ireplace( '%year%', date( 'Y' ), get_field( 'footer_copyright', 'options' ) ); ?>
		</span>
			<?php
			echo $after;
		endif;
	}
endif;

/**
 * Load an SVG or image from media uploads.
 *
 * @param array An image array from ACF or other media array.
 *
 * @return string  The SVG contents or an image tag.
 */
if ( ! function_exists( 'bt_load_image_or_svg' ) ) :
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

/**
 * Loads an SVG from media uploads.
 *
 * @param string $url Site URL.
 *
 * @return string  The SVG contents.
 */
if ( ! function_exists( 'bt_load_svg_from_media' ) ) :
	function bt_load_svg_from_media( $url ) {
		$filepath = ABSPATH . str_replace( home_url(), '', $url );

		if ( file_exists( $filepath ) ) {
			return file_get_contents( $filepath );
		}

		return '';
	}
endif;

/**
 * Load an SVG from the theme directory
 *
 * @param string  $file File path appended to the template directory or url.
 * @param boolean $from_url Use a theme URL instead of directory.
 */
if ( ! function_exists( 'bt_load_svg' ) ) :
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

/**
 * Display social icons from ACF fields.
 */
if ( ! function_exists( 'bt_display_social_icons' ) ) :
	function bt_display_social_icons() {
		if ( have_rows( 'social_accounts', 'options' ) ) :
			?>
	<ul class="social">
			<?php
			while ( have_rows( 'social_accounts', 'options' ) ) :
				the_row();
				?>
		<li>
			<a href="<?php the_sub_field( 'url' ); ?>" target="_blank" aria-label="<?php the_sub_field('accessibility_text'); ?>"><?php the_sub_field( 'icon' ); ?></a>
		</li>
		<?php endwhile; ?>
	</ul>
			<?php
		endif;
	}
endif;

/**
 * Build conditional classes for an element.
 * Checks if a value exists, and appends the key as a classname if it does.
 *
 * Example usage:
 *
 * <div class="<?php bt_classes( 'someclass', array( 'someclass--classtwo' => get_field( 'field_name' ) ) ); ?>">
 */
if ( ! function_exists( 'bt_classes' ) ) :
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

/**
 * Allow upload of SVGs to media library.
 */
function bt_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'bt_mime_types' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To enable: add_filter( 'excerpt_length', 'boilerplate_excerpt_length' );
 *
 * @param int $length Integer length passed into function.
 */
function boilerplate_excerpt_length( $length ) {
	return 40;
}

/**
 * Add category nicenames in body and post class
 *
 * To enable: add_filter('post_class', 'boilerplate_category_id_class');
 * To enable: add_filter('body_class', 'boilerplate_category_id_class');
 *
 * @param array $classes Classes passed into hook.
 */
function boilerplate_category_id_class( $classes ) {
	global $post;
	foreach ( ( get_the_category( $post->ID ) ) as $category ) {
		$classes[] = $category->category_nicename;}
	return $classes;
}

/**
 * Responsive Embed filter. Assumes 16:9
 *
 * @param string $html HTML passed into filter.
 */
function basetheme_custom_oembed_filter( $html ) {
	return '<div class="embed-responsive embed-responsive-16by9">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'basetheme_custom_oembed_filter', 10, 4 );

/**
 * Returns a "Continue Reading" link.
 */
function boilerplate_continue_reading_link() {
	return ' <a href="' . get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'basetheme' ) . '</a>';
}

/**
 * Returns a "Continue Reading" link for excerpts.
 */
function boilerplate_auto_excerpt_more() {
	return '&hellip; ' . boilerplate_continue_reading_link();
}
add_filter( 'excerpt_more', 'boilerplate_auto_excerpt_more' );

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
add_filter( 'get_the_excerpt', 'boilerplate_custom_excerpt_more' );

/**
 *  Move Yoast to bottom
 */
function yoasttobottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'yoasttobottom' );
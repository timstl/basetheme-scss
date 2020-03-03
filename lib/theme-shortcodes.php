<?php
/**
 * This file contains theme-specific shortcodes.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Basetheme
 * @since 1.0
 * @version 2.7
 */

if ( ! function_exists( 'bt_bootstrap_button_shortcode' ) ) {
	/**
	 *  Button shortcode
	 *
	 * @param array $atts Attributes passed into shortcode function.
	 */
	function bt_bootstrap_button_shortcode( $atts ) {
		$a = shortcode_atts(
			array(
				'class'  => '',
				'href'   => '',
				'text'   => '',
				'target' => '',
				'link'   => '',
			),
			$atts
		);

		$target = '';

		if ( '' !== $a['class'] ) {
			$a['class'] = ' ' . $a['class'];
		} else {
			$a['class'] = ' btn-primary';
		}

		if ( '' === $a['href'] && '' !== $a['link'] ) {
			$a['href'] = $a['link'];
		}

		if ( '' !== $a['target'] ) {
			$target = ' target="' . strip_tags( $a['target'] ) . '"';
		}

		return '<a href="' . esc_url( $a['href'] ) . '" class="btn' . strip_tags( $a['class'] ) . '"' . $target . '><span>' . esc_attr( $a['text'] ) . '</span></a>';
	}
}
add_shortcode( 'button', 'bt_bootstrap_button_shortcode' );

if ( ! function_exists( 'bt_bootstrap_buttongroup_shortcode' ) ) {
	/**
	 * Button group shortcode.
	 *
	 * @param array  $atts Attributes passed into shortcode function.
	 * @param string $content Content passed into shortcode (buttons).
	 */
	function bt_bootstrap_buttongroup_shortcode( $atts = array(), $content = null ) {
		// Remove HTML from buttons. This kills all BRs, but there shouldn't be HTML in your buttons anyway.
		// Could modify later if we find we want to add SVG support within buttons.
		$content = strip_tags( $content );
		$content = do_shortcode( $content );
		return '<div class="btn-group" role="group" aria-label="button group">' . $content . '</div>';
	}
}
add_shortcode( 'buttongroup', 'bt_bootstrap_buttongroup_shortcode' );

if ( ! function_exists( 'bt_social_accounts_shortcode' ) ) {
	/**
	 * Social links shortcode
	 */
	function bt_social_accounts_shortcode( $pid = 'options' ) {
		$html = '';
		if ( function_exists( 'have_rows' ) && have_rows( 'social_accounts', $pid ) ) {
			$html .= '<ul class="social">';
			while ( have_rows( 'social_accounts', $pid ) ) {
					the_row();
				$html .= '<li>';
				$html .= '	<a href="' . get_sub_field( 'url' ) . '" aria-label="' . get_sub_field( 'accessibility_text' ) . '" target="_blank" rel="noopener noreferrer">' . get_sub_field( 'icon' );
				if ( get_sub_field( 'title' ) ) {
					$html .= '<span>' . get_sub_field( 'title' ) . '</span>';
				}
				$html .= '</a>';
				$html .= '</li>';
			}
			$html .= '</ul>';
		}

		return $html;
	}
}
add_shortcode( 'sociallinks', 'bt_social_accounts_shortcode' );

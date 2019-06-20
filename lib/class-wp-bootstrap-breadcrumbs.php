<?php
/**
 * This class is meant as a starting point.
 * Likely requirements customization on most themes.
 *
 * Usage:
 * $breadcrumbs = new Bootstrap_Breadcrumbs();
 * echo $breadcrumbs->bootstrap_breadcrumb();
 */
class Bootstrap_Breadcrumbs {
	/**
	 * Retrieve category parents.
	 *
	 * @param int   $id Category ID.
	 * @param array $visited Optional. Already linked to categories to prevent duplicates.
	 * @return string|WP_Error A list of category parents on success, WP_Error on failure.
	 */
	function custom_get_category_parents( $id, $visited = array() ) {
		$chain  = '';
		$parent = get_term( $id, 'category' );

		if ( is_wp_error( $parent ) ) {
			return $parent;
		}

		$name = $parent->name;

		if ( $parent->parent && ( $parent->parent != $parent->term_id ) && ! in_array( $parent->parent, $visited ) ) {
			$visited[] = $parent->parent;
			$chain    .= $this->custom_get_category_parents( $parent->parent, $visited );
		}

		$chain .= '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $parent->term_id ) ) . '">' . $name . '</a>' . '</li>';

		return $chain;
	}


	function bootstrap_breadcrumb() {
		global $post;
		$class = 'breadcrumb';

		$html = '<ol class="' . $class . '">';

		if ( is_admin() ) {
			$html .= '<li class="breadcrumb-item active">Breadcrumbs</li>';
		} elseif ( ( is_front_page() ) || ( is_home() ) ) {
			$html .= '<li class="breadcrumb-item active">Home</li>';
		} else {
			if ( is_singular( 'post' ) ) {
				$html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">Blog</a></li>';
			} else {
				// $html .= '<li class="breadcrumb-item"><a href="'.esc_url(home_url('/')).'">Home</a></li>';
			}

			if ( is_attachment() ) {
				$parent     = get_post( $post->post_parent );
				$categories = get_the_category( $parent->ID );

				if ( $categories[0] ) {
					$html .= $this->custom_get_category_parents( $categories[0] );
				}

				$html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';
				$html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
			} elseif ( is_category() ) {
				$category = get_category( get_query_var( 'cat' ) );

				if ( $category->parent != 0 ) {
					$html .= $this->custom_get_category_parents( $category->parent );
				}

				$html .= '<li class="breadcrumb-item active">' . single_cat_title( '', false ) . '</li>';
			} elseif ( is_page() && ! is_front_page() ) {
				$parent_id    = $post->post_parent;
				$parent_pages = array();

				while ( $parent_id ) {
					$page           = get_page( $parent_id );
					$parent_pages[] = $page;
					$parent_id      = $page->post_parent;
				}

				$parent_pages = array_reverse( $parent_pages );

				if ( ! empty( $parent_pages ) ) {
					foreach ( $parent_pages as $parent ) {
						$html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $parent->ID ) ) . '">' . get_the_title( $parent->ID ) . '</a></li>';
					}
				}

				$html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
			} elseif ( is_singular( 'post' ) ) {
				$categories = get_the_category();

				if ( $categories[0] ) {
					$html .= $this->custom_get_category_parents( $categories[0] );
				}

				$html .= '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
			} elseif ( is_tag() ) {
				$html .= '<li class="breadcrumb-item active">' . single_tag_title( '', false ) . '</li>';
			} elseif ( is_day() ) {
				$html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
				$html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) ) . '">' . get_the_time( 'm' ) . '</a></li>';
				$html .= '<li class="breadcrumb-item active">' . get_the_time( 'd' ) . '</li>';
			} elseif ( is_month() ) {
				$html .= '<li class="breadcrumb-item"><a href="' . esc_url( get_year_link( get_the_time( 'Y' ) ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';
				$html .= '<li class="breadcrumb-item active">' . get_the_time( 'F' ) . '</li>';
			} elseif ( is_year() ) {
				$html .= '<li class="breadcrumb-item active">' . get_the_time( 'Y' ) . '</li>';
			} elseif ( is_author() ) {
				$html .= '<li class="breadcrumb-item active">' . get_the_author() . '</li>';
			} elseif ( is_search() ) {

			} elseif ( is_404() ) {

			}
		}

		$html .= '</ol>';

		return $html;
	}
}

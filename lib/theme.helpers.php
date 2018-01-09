<?php
/* 
	This file contains generic functions that are used on many sites.
*/

/* 
	Logging function.
	In wp-config.php define the WP_DEBUG_LOG constant: define('WP_DEBUG_LOG', true);
	
	You can then use this function anywhere in your themes or plugin:
	
	bt_log("log message here");
	
	This will write to wp-content/debug.log.
	In terminal: tail -f debug.log 
*/
if (!function_exists('bt_log')) {
	function bt_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

/* 
	Use instead of the_title in some cases, if you want more flexibility. 
	Checks for alt_title custom field. Uses the_title if none exists.
	Can either return or echo the title.
	Uses current post in the loop, or a $post->ID passed in as second parameter.
*/
if (!function_exists('alt_title')) : 
	function alt_title($echo=true, $pid=false)
	{
		if (!$pid) 
		{ 
			global $post; 
			$pid = $post->ID;
		}
		
		$title = get_post_meta($pid, 'alt_title', true);
		if ($title == '') { $title = get_the_title($pid); }
		
		$title = apply_filters('the_title', $title);
		
		if (!$echo)
		{
			return $title;
		}
		else
		{
			echo $title;
		}
	}
endif;

/* 
	Usage: the_field_srcset('field_name');
	ACF field should return Image ID.
*/
if (!function_exists('the_field_srcset') && function_exists('get_field')) {
	function the_field_srcset($field, $before='', $after='', $size = 'full', $echo = true) {
		
		if (get_field($field)) {
			$img = wp_get_attachment_image(get_field($field), $size);
			
			
			if ($before) {
				$img = $before.$img;
			}
			
			if ($after) {
				$img = $img.$after;
			}
			
			if (!$echo) {
				return $img;
			}
			
			echo $img;
		}
	}
}

/*
	Misc Twentysixteen meta functions used throughout the theme.
*/
if ( ! function_exists( 'twentysixteen_entry_meta' ) ) :
function twentysixteen_entry_meta() {
	if ( 'post' === get_post_type() ) {
		$author_avatar_size = apply_filters( 'twentysixteen_author_avatar_size', 49 );
		printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
			get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
			_x( 'Author', 'Used before post author name.', 'basetheme' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		twentysixteen_entry_date();
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'basetheme' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( 'post' === get_post_type() ) {
		twentysixteen_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'basetheme' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'twentysixteen_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * Create your own twentysixteen_entry_meta() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_meta() {
	if ( 'post' === get_post_type() ) {
		$author_avatar_size = apply_filters( 'twentysixteen_author_avatar_size', 49 );
		printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
			get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
			_x( 'Author', 'Used before post author name.', 'basetheme' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		twentysixteen_entry_date();
	}

	$format = get_post_format();
	if ( current_theme_supports( 'post-formats', $format ) ) {
		printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
			sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'basetheme' ) ),
			esc_url( get_post_format_link( $format ) ),
			get_post_format_string( $format )
		);
	}

	if ( 'post' === get_post_type() ) {
		twentysixteen_entry_taxonomies();
	}

	if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'basetheme' ), get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'twentysixteen_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own twentysixteen_entry_date() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		_x( 'Posted on', 'Used before publish date.', 'basetheme' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

if ( ! function_exists( 'twentysixteen_entry_taxonomies' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own twentysixteen_entry_taxonomies() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_entry_taxonomies() {
	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'basetheme' ) );
	if ( $categories_list && twentysixteen_categorized_blog() ) {
		printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Categories', 'Used before category names.', 'basetheme' ),
			$categories_list
		);
	}

	$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'basetheme' ) );
	if ( $tags_list ) {
		printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
			_x( 'Tags', 'Used before tag names.', 'basetheme' ),
			$tags_list
		);
	}
}
endif;

/**
 * Determines whether blog/site has more than one category.
 *
 * Create your own twentysixteen_categorized_blog() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 *
 * @return bool True if there is more than one category, false otherwise.
 */
function twentysixteen_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'twentysixteen_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'twentysixteen_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so twentysixteen_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so twentysixteen_categorized_blog should return false.
		return false;
	}
}

/* Output site-wide and page-specific custom scripts in header and footer */
function theme_custom_scripts_css($location = 'header') {
	the_field('custom_' . $location . '_scripts', 'options');
	the_field('custom_' . $location . '_scripts');
}
/*** HOOKS ***/
/* 
	Responsive Embed filter. Assumes 16:9 
*/
function basetheme_custom_oembed_filter($html, $url, $attr, $post_ID) {
	$return = '<div class="embed-responsive embed-responsive-16by9">'.$html.'</div>';
 return $return;
}
add_filter( 'embed_oembed_html', 'basetheme_custom_oembed_filter', 10, 4 );

/* 
	Add category nicenames in body and post class 
*/
function boilerplate_category_id_class($classes) 
{
	global $post;
	foreach((get_the_category($post->ID)) as $category) { $classes[] = $category->category_nicename; }
	return $classes;
}
add_filter('post_class', 'boilerplate_category_id_class');
add_filter('body_class', 'boilerplate_category_id_class');

/* 
	Returns a "Continue Reading" link for excerpts 
*/
function boilerplate_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'basetheme' ) . '</a>';
}

function boilerplate_auto_excerpt_more( $more ) {
	return '&hellip; ' . boilerplate_continue_reading_link();
}
add_filter( 'excerpt_more', 'boilerplate_auto_excerpt_more' );

function boilerplate_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= boilerplate_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'boilerplate_custom_excerpt_more' );

/* 
	Optional functions. 
	Remove comment to enable 
*/

/* Sets the post excerpt length to 40 characters. */
function boilerplate_excerpt_length( $length ) { 
	return 40; 
}
//add_filter( 'excerpt_length', 'boilerplate_excerpt_length' );
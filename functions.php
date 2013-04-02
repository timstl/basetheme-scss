<?php
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */

if ( ! isset( $content_width ) )
	$content_width = 618;

/* remove some stuff from the head. */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

// remove version info from head and feeds (http://digwp.com/2009/07/remove-wordpress-version-number/)
function boilerplate_complete_version_removal() {
	return '';
}
add_filter('the_generator', 'boilerplate_complete_version_removal');

/* This is not perfect, but changing this number will help refresh cache
   for stylesheet, main.js, plugins.js. */
function cache_bust()
{
	return '010213';
}

/* Uncomment to disable the admin bar. */
// if (!is_admin()) { show_admin_bar(false); }
if ( ! function_exists( 'basetheme_setup' ) ):
function basetheme_setup() {

	add_editor_style();

	add_theme_support( 'automatic-feed-links' );

	load_theme_textdomain( 'boilerplate', get_template_directory() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory() . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// Register nav menus.
	register_nav_menus( array(
		'mainnav' => __( 'Main Navigation', 'boilerplate' ),
		'footernav' => __( 'Footer Navigation', 'boilerplate' ),
	) );
	
	// Register custom post type and taxonomy.
	/*  $labels = array(
	    'name' => _x('Case Studies', 'post type general name'),
	    'singular_name' => _x('Case Study', 'post type singular name'),
	    'add_new' => _x('Add New', 'casestudies'),
	    'add_new_item' => __('Add New Case Study'),
	    'edit_item' => __('Edit Case Study'),
	    'new_item' => __('New Case Study'),
	    'all_items' => __('All Case Studies'),
	    'view_item' => __('View Case Study'),
	    'search_items' => __('Search Case Studies'),
	    'not_found' =>  __('No Case Studies found'),
	    'not_found_in_trash' => __('No Case Studies found in Trash'), 
	    'parent_item_colon' => '',
	    'menu_name' => 'Case Studies'
	
	  );
	  $args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true, 
	    'show_in_menu' => true, 
	    'query_var' => true,
	    'rewrite' => true,
	    'capability_type' => 'post',
	    'has_archive' => true, 
	    'hierarchical' => true,
	    'menu_position' => 6,
	    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields' )
	  ); 
	  register_post_type('casestudies',$args);
	  
	  $labels = array(
	    'name' => _x( 'Industries', 'taxonomy general name' ),
	    'singular_name' => _x( 'Industry', 'taxonomy singular name' ),
	    'search_items' =>  __( 'Search Industries' ),
	    'popular_items' => __( 'Popular Industries' ),
	    'all_items' => __( 'All Industries' ),
	    'parent_item' => null,
	    'parent_item_colon' => null,
	    'edit_item' => __( 'Edit Industry' ), 
	    'update_item' => __( 'Update Industry' ),
	    'add_new_item' => __( 'Add New Industry' ),
	    'new_item_name' => __( 'New Industry Name' ),
	    'separate_items_with_commas' => __( 'Separate Industries with commas' ),
	    'add_or_remove_items' => __( 'Add or remove Industries' ),
	    'choose_from_most_used' => __( 'Choose from the most used Industries' ),
	    'menu_name' => __( 'Industries' ),
	  ); 
	
	  register_taxonomy('industries','casestudies',array(
	    'hierarchical' => true,
	    'labels' => $labels,
	    'show_ui' => true,
	    'update_count_callback' => '_update_post_term_count',
	    'query_var' => true,
	    'has_archive' => true,   
	    'rewrite' => array( 'slug' => 'industries' ),
	  )); */
}
endif;
add_action( 'after_setup_theme', 'basetheme_setup' );

// Add theme support for thumbnails.
if ( function_exists( 'add_theme_support' ) ) 
{
	add_theme_support( 'post-thumbnails' );
	//set_post_thumbnail_size( 618, 9999, false );
	//add_image_size( 'another-image-size', '250', '250', true );
}

/**
 * Makes some changes to the <title> tag, by filtering the output of wp_title().
 *
 * If we have a site description and we're viewing the home page or a blog posts
 * page (when using a static front page), then we will add the site description.
 *
 * If we're viewing a search result, then we're going to recreate the title entirely.
 * We're going to add page numbers to all titles as well, to the middle of a search
 * result title and the end of all other titles.
 *
 * The site title also gets added to all titles.
 *
 * @since Twenty Ten 1.0
 *
 * @param string $title Title generated by wp_title()
 * @param string $separator The separator passed to wp_title(). Twenty Ten uses a
 * 	vertical bar, "|", as a separator in header.php.
 * @return string The new title, ready for the <title> tag.
 */

// If using All in One SEO Pack, may want to disable this function. Test first.
function boilerplate_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'boilerplate' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'boilerplate' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'boilerplate' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'boilerplate_filter_wp_title', 10, 2 );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function boilerplate_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'boilerplate_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function boilerplate_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'boilerplate_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function boilerplate_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'boilerplate' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and boilerplate_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function boilerplate_auto_excerpt_more( $more ) {
	return '&hellip; ' . boilerplate_continue_reading_link();
}
add_filter( 'excerpt_more', 'boilerplate_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function boilerplate_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= boilerplate_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'boilerplate_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 */
function boilerplate_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'boilerplate_remove_gallery_css' );

if ( ! function_exists( 'boilerplate_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 */
function boilerplate_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 40 ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', 'boilerplate' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
			</div><!-- .comment-author .vcard -->
			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em><?php _e( 'Your comment is awaiting moderation.', 'boilerplate' ); ?></em>
				<br />
			<?php endif; ?>
			<footer class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php
					/* translators: 1: date, 2: time */
					printf( __( '%1$s at %2$s', 'boilerplate' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'boilerplate' ), ' ' );
				?>
			</footer><!-- .comment-meta .commentmetadata -->
			<div class="comment-body"><?php comment_text(); ?></div>
			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-##  -->
	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'boilerplate' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'boilerplate'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas
 */
function basetheme_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Main Sidebar Widget Area', 'boilerplate' ),
		'id' => 'primary-sidebar-widget-area',
		'description' => __( 'The primary widget area', 'boilerplate' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running basetheme_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'basetheme_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 */
function boilerplate_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'boilerplate_remove_recent_comments_style' );

if ( ! function_exists( 'boilerplate_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function boilerplate_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'boilerplate' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'boilerplate' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'boilerplate_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function boilerplate_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'boilerplate' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'boilerplate' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'boilerplate' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

function tg_scripts()
{
	if (!is_admin())
	{
		wp_enqueue_style( 'base-style', get_stylesheet_uri(), array(), cache_bust() );
	
		wp_enqueue_script('modernizr-respond', get_template_directory_uri() . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array(), '2.6.2-1.1.0');     

		wp_deregister_script('jquery');
		wp_register_script('jquery', "http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js", array(), null);
		wp_enqueue_script('jquery');

		if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
	
		wp_enqueue_script('plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), cache_bust(), true);    
		wp_enqueue_script('scripts', get_template_directory_uri() . '/js/main.js', array('jquery'), cache_bust(), true);    
	}
}
add_action('wp_enqueue_scripts', 'tg_scripts');

// add category nicenames in body and post class
function boilerplate_category_id_class($classes) {
    global $post;
    foreach((get_the_category($post->ID)) as $category)
        $classes[] = $category->category_nicename;
        return $classes;
}
add_filter('post_class', 'boilerplate_category_id_class');
add_filter('body_class', 'boilerplate_category_id_class');

// change Search Form input type from "text" to "search" and add placeholder text
function boilerplate_search_form ( $form ) {
	$form = '<form role="search" method="get" class="searchform" action="' . home_url( '/' ) . '" >
	<div>
	<input type="search" placeholder="Search for..." value="' . get_search_query() . '" name="s" class="s" />
	<input type="submit" class="searchsubmit" value="'. esc_attr__('Search') .'" />
	</div>
	</form>';
	return $form;
}
add_filter( 'get_search_form', 'boilerplate_search_form' );

/* Use instead of the_title in some cases, if you want more flexibility. 
   Checks for alt_title custom field. Uses the_title if none exists.
   Can either return or echo the title.
   Uses current post in the loop, or a $post->ID passed in as second parameter.
*/
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

/* 
	Debugging function. Much nicer than print_r.
	Note: Limited to manage_options users by default. 
	Pass in 'false' as section param to show to everyone.
	
	Based on debugging function found in CMS Made Simple http://www.cmsmadesimple.org/
*/
function debug_display($var, $admins=true, $title="", $echo_to_screen = true, $use_html = true)
{
	if ($admins == true && !current_user_can('manage_options')) { return; }
	
     $titleText = "Debug: ";
     if($title)
      {
          $titleText = "Debug display of '$title':";
      }
  
      ob_start();
      if ($use_html)
          echo "<p><b>$titleText</b><pre>\n";
  
      if(is_array($var))
      {
          echo "Number of elements: " . count($var) . "\n";
          print_r($var);
      }
      elseif(is_object($var))
      {
          print_r($var);
     }
      elseif(is_string($var))
      {
          print_r(htmlentities(str_replace("\t", '  ', $var)));
      }
      elseif(is_bool($var))
      {
         echo $var === true ? 'true' : 'false';
      }
     else
      {
          print_r($var);
      }
  
      if ($use_html)
          echo "</pre></p>\n";
  
      $output = ob_get_contents();
     ob_end_clean();
  
      if($echo_to_screen)
      {
          echo $output;
      }
 
      return $output;
}


/* admin */
if (is_admin())
{
	require_once(get_template_directory() . '/lib/admin.functions.php');
}
?>

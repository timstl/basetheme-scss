<?php
/*
Uncomment to disable the admin bar.
*/
// if (!is_admin()) { show_admin_bar(false); }

/*
Set the content width based on the theme's design and stylesheet.
*/
if ( ! isset( $content_width ) ) { 
	$content_width = 660; 
}

/* Remove some stuff from the head. */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

/* Remove version info from head and feeds (http://digwp.com/2009/07/remove-wordpress-version-number/) */
function boilerplate_complete_version_removal() { 
	return ''; 
}
add_filter('the_generator', 'boilerplate_complete_version_removal');

/*
Help refresh cache for stylesheet, main.js, plugins.js.
This number is appended in basetheme_enqueue()
*/
function cache_bust() { 
	return '112113'; 
}

/* Setup custom post types */
include(get_template_directory() . '/lib/cpt.php');

/* Setup Theme */
function basetheme_setup() 
{

	add_editor_style();

	add_theme_support( 'automatic-feed-links' );

	load_theme_textdomain( 'basetheme', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );	

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );	
		
	global $content_width;
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( $content_width, 9999, false );
	//add_image_size( 'another-image-size', '250', '250', true );

	// Register nav menus.
	register_nav_menus( array(
		'mainnav' => __( 'Main Navigation', 'boilerplate' ),
		'footernav' => __( 'Footer Navigation', 'boilerplate' ),
	) );

	// This theme uses its own gallery styles.
	// add_filter( 'use_default_gallery_style', '__return_false' );

	/*add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );*/
	
}
add_action( 'after_setup_theme', 'basetheme_setup' );

/* Register widgetized areas */
function basetheme_widgets_init() 
{
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
add_action( 'widgets_init', 'basetheme_widgets_init' );

/* Enqueue scripts and styles */
function basetheme_enqueue()
{
	if (!is_admin())
	{
		// add font enqueue here, before base-style.
		
		wp_enqueue_style( 'base-style', get_template_directory_uri() . '/css/app.css', array(), cache_bust() );
	
		wp_enqueue_script('modernizr-respond', get_template_directory_uri() . '/js/vendor/modernizr.js', array(), '2.8.3');

		wp_deregister_script('jquery');
		wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js", array(), null);
		wp_enqueue_script('jquery');

		if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
	
		wp_enqueue_script('plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), cache_bust(), true);    
		wp_enqueue_script('scripts', get_template_directory_uri() . '/js/main.js', array('jquery'), cache_bust(), true);    
	}
}
add_action('wp_enqueue_scripts', 'basetheme_enqueue');

/* Add category nicenames in body and post class */
function boilerplate_category_id_class($classes) 
{
	global $post;
	foreach((get_the_category($post->ID)) as $category) { $classes[] = $category->category_nicename; }
	return $classes;
}
add_filter('post_class', 'boilerplate_category_id_class');
add_filter('body_class', 'boilerplate_category_id_class');

if ( ! function_exists( 'twentyfifteen_comment_nav' ) ) :
/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_comment_nav() {
	// Are there comments to navigate through?
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
	?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'twentyfifteen' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'twentyfifteen' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( __( 'Newer Comments', 'twentyfifteen' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}
endif;

/* 
Use instead of the_title in some cases, if you want more flexibility. 
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

/* Returns a "Continue Reading" link for excerpts */
function boilerplate_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'boilerplate' ) . '</a>';
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

add_filter( 'embed_oembed_html', 'custom_oembed_filter', 10, 4 ) ;
function custom_oembed_filter($html, $url, $attr, $post_ID) {
	$return = '<div class="vid">'.$html.'</div>';
 return $return;
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


/* 
Admin 
*/
if (is_admin()) { require_once(get_template_directory() . '/lib/admin.functions.php'); }
?>
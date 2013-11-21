<?php
/*
Uncomment to disable the admin bar.
*/
// if (!is_admin()) { show_admin_bar(false); }

/*
Set the content width based on the theme's design and stylesheet.
*/
if ( ! isset( $content_width ) ) { $content_width = 618; }

/*
Remove some stuff from the head.
*/
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

/*
Remove version info from head and feeds (http://digwp.com/2009/07/remove-wordpress-version-number/)
*/
function boilerplate_complete_version_removal() { return ''; }
add_filter('the_generator', 'boilerplate_complete_version_removal');

/*
Help refresh cache for stylesheet, main.js, plugins.js.
This number is appended in basetheme_enqueue()
*/
function cache_bust() { return '112113'; }

/*
Setup Theme
*/
function basetheme_setup() 
{

	add_editor_style();

	add_theme_support( 'automatic-feed-links' );

	load_theme_textdomain( 'basetheme', get_template_directory() . '/languages' );
	
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
		
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
	add_filter( 'use_default_gallery_style', '__return_false' );
	
}
add_action( 'after_setup_theme', 'basetheme_setup' );

/*
Setup custom post types
*/
include(get_template_directory() . '/lib/cpt.php');

/*
Register widgetized areas
*/
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

/*
Enqueue scripts and styles
*/
function basetheme_enqueue()
{
	if (!is_admin())
	{
		wp_enqueue_style( 'base-style', get_stylesheet_uri(), array(), cache_bust() );
	
		wp_enqueue_script('modernizr-respond', get_template_directory_uri() . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array(), '2.6.2-1.1.0');     

		wp_deregister_script('jquery');
		wp_register_script('jquery', "http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js", array(), null);
		wp_enqueue_script('jquery');

		if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
	
		wp_enqueue_script('plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), cache_bust(), true);    
		wp_enqueue_script('scripts', get_template_directory_uri() . '/js/main.js', array('jquery'), cache_bust(), true);    
	}
}
add_action('wp_enqueue_scripts', 'basetheme_enqueue');

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function twentythirteen_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentythirteen_wp_title', 10, 2 );


/*
Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
*/
function boilerplate_page_menu_args( $args ) 
{
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'boilerplate_page_menu_args' );

/*
Sets the post excerpt length to 40 characters.
*/
function boilerplate_excerpt_length( $length ) { return 40; }
add_filter( 'excerpt_length', 'boilerplate_excerpt_length' );

/*
Returns a "Continue Reading" link for excerpts
*/
function boilerplate_continue_reading_link() 
{
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'boilerplate' ) . '</a>';
}

/*
Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and boilerplate_continue_reading_link().
*/
function boilerplate_auto_excerpt_more( $more ) 
{
	return '&hellip; ' . boilerplate_continue_reading_link();
}
add_filter( 'excerpt_more', 'boilerplate_auto_excerpt_more' );

/*
Adds a pretty "Continue Reading" link to custom post excerpts.
*/
function boilerplate_custom_excerpt_more( $output ) 
{
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= boilerplate_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'boilerplate_custom_excerpt_more' );

/*
Template for comments and pingbacks.
*/
function boilerplate_comment( $comment, $args, $depth ) 
{
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

/*
Prints HTML with meta information for the current post—date/time and author.
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

/*
Prints HTML with meta information for the current post (category, tags and permalink).
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

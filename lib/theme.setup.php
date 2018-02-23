<?php
/*
Set the content width based on the theme's design and stylesheet.
*/
if ( ! isset( $content_width ) ) { 
	$content_width = 960; 
}

/* 
	Setup scripts, sidebars, menus, etc. 
*/
function basetheme_setup() {

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
		'mainnav' => __( 'Main Navigation', 'basetheme' ),
		'footernav' => __( 'Footer Navigation', 'basetheme' )
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	
	/*add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );*/
}
add_action( 'after_setup_theme', 'basetheme_setup' );

/* Register widgetized areas */
function basetheme_widgets_init() 
{
	register_sidebar( array(
		'name' => __( 'Blog Sidebar Widget Area', 'basetheme' ),
		'id' => 'blog-sidebar-widget-area',
		'description' => __( 'The blog widget area', 'basetheme' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	register_sidebar( array(
		'name' => __( 'Page Sidebar Widget Area', 'basetheme' ),
		'id' => 'page-sidebar-widget-area',
		'description' => __( 'The page widget area', 'basetheme' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'widgets_init', 'basetheme_widgets_init' );

/* Enqueue scripts and styles */
function basetheme_enqueue()
{
	/**
	 * cache_bust():
	 * Pass in the file path (not the URI) into this function.
	 * File modified time used for unique string to force cache busting.
	 * File modified time is stored in a WP transient for 60 seconds to prevent checking every page load during high traffic.
	 * See theme.helpers.php for more.
	 */

	// add font enqueue here, before base-style.

	//wp_enqueue_style( 'fonts', '', array() );
	wp_enqueue_style( 'base-style', get_template_directory_uri() . '/dist/style.css', array(), cache_bust(get_template_directory() . '/dist/style.css') );

	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/js/head/vendor/jquery.min.js', array(), '3.3.1');
	wp_enqueue_script('jquery');

	wp_enqueue_script('head', get_template_directory_uri() . '/dist/head.min.js', array(), cache_bust(get_template_directory() . '/dist/head.min.js'));

	if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }

	wp_enqueue_script('scripts', get_template_directory_uri() . '/dist/scripts.min.js', array(), cache_bust(get_template_directory() . '/dist/scripts.min.js'), true);      
}
add_action('wp_enqueue_scripts', 'basetheme_enqueue');
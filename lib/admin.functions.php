<?php
/* ACF Options Page 
if(function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'manage_options',
		'redirect'		=> false
	));
}*/

/*
Automated plugin notifications
*/
require_once(get_template_directory().'/lib/tgm-plugin-activation/plugins.php');

/*
Enqueue an admin-specific css file.
*/
function admin_scripts(){
	wp_enqueue_style( 'btadmin', get_template_directory_uri().'/lib/css/admin.css', array(), cache_bust() );
}
add_action( 'wp_enqueue_scripts', 'admin_scripts' );
/*
Call various functions that display notices in the admin.
*/
function bt_admin_notices()
{
	if (current_user_can('manage_options')) { bt_privacy_notice(); }
}
add_action('admin_notices', 'bt_admin_notices');

/*
Check search engine settings, display notice.
*/
function bt_privacy_notice()
{
	if ( '0' == get_option('blog_public') )
	{
		echo '<div class="error"><p>Search engines are currently blocked.</p></div>';	
	}
	
	/*if (!file_exists(get_home_path() . '.htpasswd'))
	{
		echo '<div class="error"><p>There is no .htpasswd file in your root directory. Generate one <a href="http://www.htaccesstools.com/htpasswd-generator/" target="_blank">here</a> and get your .htaccess code <a href="http://www.htaccesstools.com/htaccess-authentication/" target="_blank">here</a> (path: '.get_home_path() . '.htpasswd'.'). Using a .htpasswd on your dev sites will help prevent automated hack attempts on old sites without updates.</p></div>';			
	}*/
}

/* on activation */
function bt_on_activation()
{
	goodbye_dolly(); 
	bt_base_pages();
}

function bt_base_pages()
{
	$page_titles = array("Home", "About", "Blog");
		
	if (!get_page_by_path('home') && get_page_by_path('sample-page'))
	{		
		wp_delete_post( get_page_by_path('sample-page')->ID );
		
		$args = array (
			"post_type" => "page",
			"post_content" => "",
			"post_status" => "publish",
			"post_author" => 1
		);

		foreach ($page_titles as $pt)
		{
			$args['post_title'] = $pt;
			
			$id = wp_insert_post($args);
			
			if (!is_wp_error($id) && $id > 0)
			{
				if ($pt == "Home")
				{
					update_option('show_on_front', 'page');
					update_option('page_on_front', $id);
					
					update_post_meta($id, '_wp_page_template', 'template-home.php');
				}
				elseif ($pt == "Blog")
				{
					update_option('page_for_posts', $id);
				}

			}
		}
		
		update_option('page-created', true);
		update_option('blog_public', '0');		
	}
}

/* 
Auto remove Hello Dolly 
*/
function goodbye_dolly() 
{
	if (file_exists(WP_PLUGIN_DIR.'/hello.php')) 
	{
		require_once(ABSPATH.'wp-admin/includes/plugin.php');
		require_once(ABSPATH.'wp-admin/includes/file.php');
		delete_plugins(array('hello.php'));
	}
}

if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) 
{ 
	bt_on_activation();
}
?>
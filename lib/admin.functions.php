<?php
/*
Automated plugin notifications
*/
require_once(get_template_directory().'/lib/tgm-plugin-activation/plugins.php');

/*
Enqueue an admin-specific css file.
*/
wp_enqueue_style( 'btadmin', get_template_directory_uri().'/lib/css/admin.css', array(), cache_bust() );

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
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) { goodbye_dolly(); }
?>
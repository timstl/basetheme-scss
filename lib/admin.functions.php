<?php
// enqueue an admin-specific css file.
wp_enqueue_style( 'btadmin', get_template_directory_uri().'/lib/css/admin.css', array(), '080512' );

// call various functions that display notices in the admin.
function bt_admin_notices()
{
	if (current_user_can('manage_options'))
	{
		bt_privacy_notice();
	}
}
add_action('admin_notices', 'bt_admin_notices');

// check search engine settings, display notice.
function bt_privacy_notice()
{
	if ( '0' == get_option('blog_public') )
	{
		echo '<div class="error"><p>Search engines are currently blocked.</p></div>';	
	}
}

require_once(get_template_directory() . '/lib/admin.themeadmin.php');
?>
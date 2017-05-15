<?php
/*
Enqueue an admin-specific css file.
*/
function admin_scripts(){
	wp_enqueue_style( 'btadmin', get_template_directory_uri().'/lib/css/admin.css', array(), cache_bust() );
}
add_action( 'wp_enqueue_scripts', 'admin_scripts' );
<?php
function csl_siteorigin_widgets($folders){
	$folders[] = get_template_directory() . '/lib/siteorigin-widgets/';
	return $folders;
}
add_filter('siteorigin_widgets_widget_folders', 'csl_siteorigin_widgets');

function basetheme_siteorigin_widget_banner_img_src( $banner_url, $widget_meta ) {
	if( in_array($widget_meta['ID'], array('bt-bootstrap-accordion-widget', 
											'bt-button-group-widget', 
											'bt-button-widget', 
											'bt-responsive-video-widget', 
											'bt-cycle-slideshow-widget', 
											'bt-image-and-content-rows-widget',
											'bt-gravity-form-widget',
											'bt-bootstrap-column-widget')
											)) {
												
		$banner_url = get_template_directory_uri() . '/lib/siteorigin-widgets/ico.svg';
	}
	return $banner_url;
}
add_filter( 'siteorigin_widgets_widget_banner', 'basetheme_siteorigin_widget_banner_img_src', 10, 2);
<?php
/*
Widget Name: AD: Responsive Video
Description: Add a video or other embed with responsive bootstrap wrapper.
Author: Atomicdust
Author URI: http://atomicdust.com
*/

class BT_Responsive_Video_Widget extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
	
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'bt-responsive-video-widget',
	
			// The name of the widget for display purposes.
			__('AD: Responsive Video', 'basetheme'),
	
			// The $widget_options array, which is passed through to WP_Widget.
			array(
				'description' => __('A responsive video with bootstrap and custom classes.', 'basetheme'),
				'panels_icon' => 'widget-icon dashicons basetheme-so-dashicon basetheme-so-dashicon-basetheme-button'
			),
	
			//The $control_options array, which is passed through to WP_Widget
			array(
			),
	
			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'content' => array(
					'type' => 'tinymce',
					'default_editor' => 'tmce',
					'label' => __('Content', 'basetheme'),
					'description' => 'Optional content above video.',
					'default' => ''
				),
				'embed' => array(
					'type' => 'tinymce',
					'default_editor' => 'html',
					'label' => __('Video Embed', 'basetheme'),
					'description' => 'iframe, video, embed, or object tag. Or another element with .embed-responsive-item class',
					'default' => ''
				),
				'ratio' => array(
					'type' => 'radio',
					'label' => __('Aspect Ratio', 'basetheme'),
					'options' => array('16by9' => '16:9', '4by3' => '4:3'),
					'default' => '16by9'
				),
				'class_custom' => array(
					'type' => 'text',
					'label' => __('Custom classes', 'basetheme'),
					'default' => ''
				),
			),
	
			//The $base_folder path string.
			plugin_dir_path(__FILE__)
		);
	}
	
	function get_template_name($instance) {
		return 'default';
	}
	
	function get_style_name($instance) {
		return '';
	}
}

siteorigin_widget_register('bt-responsive-video-widget', __FILE__, 'BT_Responsive_Video_Widget');
?>
<?php
/*
Widget Name: AD: Image and Content Rows
Description: Add rows of thumbnails + content.
Author: Atomicdust
Author URI: http://atomicdust.com
*/

class BT_ImageAndContentRow_Widget extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

		$form_options = array(
			'content' => array(
				'type' => 'tinymce',
				'default_editor' => 'tmce',
				'label' => __('Content', 'basetheme'),
				'description' => 'Optional content above rows.',
				'default' => ''
			),
			'rows' => array(
				'type' => 'repeater',
				'label' => __( 'An image + content row.' , 'basetheme' ),
				'item_name'  => __( 'Row', 'basetheme' ),
				'fields' => array(
					'thumbnail' => array(
						'type' => 'media',
						'label' => __( 'Thumbnail', 'basetheme' )
					),
					'content' => array(
						'type' => 'tinymce',
						'default_editor' => 'tmce',
						'label' => __( 'Content', 'basetheme' )
					)
				)
			)
		);
			
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'bt-image-and-content-rows-widget',
	
			// The name of the widget for display purposes.
			__('AD: Image and Content Rows', 'basetheme'),
	
			// The $widget_options array, which is passed through to WP_Widget.
			array(
				'description' => __('A widget for displaying rows of thumbnails + content.', 'basetheme'),
				'panels_icon' => 'widget-icon dashicons basetheme-so-dashicon basetheme-so-dashicon-image-and-content-rows'
			),
	
			//The $control_options array, which is passed through to WP_Widget
			array(
			),
	
			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			$form_options,
	
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

siteorigin_widget_register('bt-image-and-content-rows-widget', __FILE__, 'BT_ImageAndContentRow_Widget');
?>
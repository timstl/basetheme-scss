<?php
/*
Widget Name: AD: Button
Description: Add a button with bootstrap and custom classes.
Author: Atomicdust
Author URI: http://atomicdust.com
*/

class BT_Button_Widget extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.
	
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'bt-button-widget',
	
			// The name of the widget for display purposes.
			__('AD: Button', 'basetheme'),
	
			// The $widget_options array, which is passed through to WP_Widget.
			array(
				'description' => __('A single button with bootstrap and custom classes.', 'basetheme'),
				'panels_icon' => 'widget-icon dashicons basetheme-so-dashicon basetheme-so-dashicon-basetheme-button'
			),
	
			//The $control_options array, which is passed through to WP_Widget
			array(
			),
	
			//The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
			array(
				'text' => array(
					'type' => 'text',
					'label' => __('Button Text', 'basetheme'),
					'default' => 'Click Here'
				),
				'link' => array(
					'type' => 'text',
					'label' => __('Button Link', 'basetheme'),
					'default' => ''
				),
				'target' => array(
					'type' => 'checkbox',
					'label' => __('Open in a new window', 'basetheme'),
					'default' => false
				),
				'class' => array(
					'type' => 'select',
					'label' => __('Bootstrap Class', 'basetheme'),
					'options' => array('btn-primary' => 'btn-primary', 'btn-default' => 'btn-default', 'btn-success' => 'btn-success', 'btn-info' => 'btn-info', 'btn-warning' => 'btn-warning', 'btn-danger' => 'btn-danger'),
					'default' => 'btn-primary'
				),
				'class_ol' => array(
					'type' => 'checkbox',
					'label' => __('Add \'outlined\' style (class: btn-ol)', 'basetheme'),
					'default' => false
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

siteorigin_widget_register('bt-button-widget', __FILE__, 'BT_Button_Widget');
?>
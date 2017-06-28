<?php
/*
Widget Name: AD: Bootstrap Column Widget
Description: Add columns with bootstrap column structure (slightly customized) and classes.
Author: Atomicdust
Author URI: http://atomicdust.com
*/

class BT_BootstrapColumn_Widget extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

		$form_options = array(
			'content' => array(
				'type' => 'tinymce',
				'default_editor' => 'tmce',
				'label' => __('Content - Above Columns', 'basetheme'),
				'description' => 'Optional content above columns.',
				'default' => ''
			),
			'columns' => array(
				'type' => 'repeater',
				'label' => __( 'A bootstrap row with columns.' , 'basetheme' ),
				'item_name'  => __( 'Column', 'basetheme' ),
				'fields' => array(
					'content' => array(
						'type' => 'tinymce',
						'default_editor' => 'tmce',
						'label' => __( 'Column Content', 'basetheme' )
					),
					'classes' => array(
						'type' => 'text',
						'label' => __( 'Column classes (Based on 24 column Grid)', 'basetheme' )
					)
				)
			),
			'content_below' => array(
				'type' => 'tinymce',
				'default_editor' => 'tmce',
				'label' => __('Content - Below Columns', 'basetheme'),
				'description' => 'Optional content below columns.',
				'default' => ''
			),
			'container' => array(
				'type' => 'checkbox',
				'label' => __('Wrap columns in a bootstrap .container.', 'basetheme'),
				'default' => false
			)
		);
			
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'bt-bootstrap-column-widget',
	
			// The name of the widget for display purposes.
			__('AD: Bootstrap Columns', 'basetheme'),
	
			// The $widget_options array, which is passed through to WP_Widget.
			array(
				'description' => __('A widget for inserting bootstrap columns.', 'basetheme'),
				'panels_icon' => 'widget-icon dashicons basetheme-so-dashicon basetheme-so-dashicon-bootstrap-column'
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

siteorigin_widget_register('bt-bootstrap-column-widget', __FILE__, 'BT_BootstrapColumn_Widget');
?>
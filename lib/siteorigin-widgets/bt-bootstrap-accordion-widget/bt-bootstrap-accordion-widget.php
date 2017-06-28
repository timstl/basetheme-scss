<?php
/*
Widget Name: AD: Bootstrap Accordion Widget
Description: Add accordions with bootstrap panel structure (slightly customized) and classes.
Author: Atomicdust
Author URI: http://atomicdust.com
*/

class BT_BootstrapAccordion_Widget extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

		$form_options = array(
			'content' => array(
				'type' => 'tinymce',
				'default_editor' => 'tmce',
				'label' => __('Content', 'basetheme'),
				'description' => 'Optional content above accordions.',
				'default' => ''
			),
			'accordion' => array(
				'type' => 'repeater',
				'label' => __( 'A bootstrap accordion.' , 'basetheme' ),
				'item_name'  => __( 'Accordion Item', 'basetheme' ),
				'fields' => array(
					'title' => array(
						'type' => 'text',
						'label' => __( 'Title / Trigger', 'basetheme' )
					),
					'subtitle' => array(
						'type' => 'text',
						'label' => __( 'Subtitle', 'basetheme' )
					),
					'content' => array(
						'type' => 'tinymce',
						'label' => __( 'Content', 'basetheme' )
					),
					'open' => array(
						'type' => 'checkbox',
						'label' => __( 'Open on load.', 'basetheme' ),
						'description' => __( 'Note: Only one accordion should be marked to open on load.', 'basetheme' ),
						'default' => false
					)
				)
			)
		);
			
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'bt-bootstrap-accordion-widget',
	
			// The name of the widget for display purposes.
			__('AD: Accordion', 'basetheme'),
	
			// The $widget_options array, which is passed through to WP_Widget.
			array(
				'description' => __('An accordion widget using customized bootstrap panels.', 'basetheme'),
				'panels_icon' => 'widget-icon dashicons basetheme-so-dashicon basetheme-so-dashicon-bootstrap-accordion'
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

siteorigin_widget_register('bt-bootstrap-accordion-widget', __FILE__, 'BT_BootstrapAccordion_Widget');
?>
<?php
/*
Widget Name: AD: Cycle Slideshow Widget
Description: Add slideshows that use the cycle2 slideshow library.
Author: Atomicdust
Author URI: http://atomicdust.com
*/

class BT_CycleSlideshow_Widget extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

		$form_options = array(
			'timeout' => array(
				'type' => 'number',
				'label' => __( 'Slideshow timeout in milliseconds (0 to disable auto-slide)' , 'basetheme' ),
				'default' => 0
			),
			'controls' => array(
				'type' => 'radio',
				'label' => __( 'Display previous and next buttons', 'basetheme' ),
				'default' => 'yes',
				'options' => array(
					'yes' => __( 'Yes', 'basetheme' ),
					'no' => __( 'No', 'basetheme' )
				)
			),
			'slides' => array(
				'type' => 'repeater',
				'label' => __( 'Cycle Slideshow' , 'basetheme' ),
				'item_name'  => __( 'Slide', 'basetheme' ),
				'fields' => array(
					'image' => array(
						'type' => 'media',
						'label' => __( 'Image', 'basetheme' )
					)
				)
			)
		);
			
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'bt-cycle-slideshow-widget',
	
			// The name of the widget for display purposes.
			__('AD: Cycle2 Slideshow', 'basetheme'),
	
			// The $widget_options array, which is passed through to WP_Widget.
			array(
				'description' => __('A slideshow widget using cycle2.', 'basetheme'),
				'panels_icon' => 'widget-icon dashicons basetheme-so-dashicon basetheme-so-dashicon-cycle-slideshow'
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

siteorigin_widget_register('bt-cycle-slideshow-widget', __FILE__, 'BT_CycleSlideshow_Widget');
?>
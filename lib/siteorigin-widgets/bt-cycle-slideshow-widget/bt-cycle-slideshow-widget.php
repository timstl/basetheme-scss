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
					'slide_type'	=> array(
						'type'	=> 'select',
						'default' => 'image',
						'label'   => __( 'Slide Type', 'basetheme' ),
						'options' => array(
							'image'		=> __( 'Image', 'basetheme' ),
							'embed'		=> __( 'Embed', 'basetheme' ),
							'editor'	=> __( 'Editor', 'basetheme' ),
						),
						'state_emitter' => array(
							'callback' => 'select',
							'args' => array( 'slide_type_{$repeater}' )
						),
					),
					'image' => array(
						'type' => 'media',
						'label' => __( 'Image', 'basetheme' ),
						'state_handler' => array(
							'slide_type_{$repeater}[image]' => array('show'),
							'_else[slide_type_{$repeater}]' => array( 'hide' ),
						)
					),
					'embed' => array(
						'type' => 'tinymce',
						'default_editor' => 'html',
						'label' => __('Video Embed', 'basetheme'),
						'description' => 'iframe, video, embed, or object tag. Or another element with .embed-responsive-item class',
						'default' => '',
						'state_handler' => array(
							'slide_type_{$repeater}[embed]' => array('show'),
							'_else[slide_type_{$repeater}]' => array( 'hide' ),
						)
					),
					'ratio' => array(
						'type' => 'radio',
						'label' => __('Aspect Ratio', 'basetheme'),
						'options' => array('16by9' => '16:9', '4by3' => '4:3'),
						'default' => '16by9',
						'state_handler' => array(
							'slide_type_{$repeater}[embed]' => array('show'),
							'_else[slide_type_{$repeater}]' => array( 'hide' ),
						)
					),
					'editor' => array(
						'type' => 'tinymce',
						'default_editor' => 'html',
						'label' => __('Content', 'basetheme'),
						'description' => '',
						'default' => '',
						'state_handler' => array(
							'slide_type_{$repeater}[editor]' => array('show'),
							'_else[slide_type_{$repeater}]' => array( 'hide' ),
						)
					)
				)
			),
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
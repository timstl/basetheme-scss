<?php
/*
Widget Name: AD: Gravity Form
Description: Add a Gravity Form.
Author: Atomicdust
Author URI: http://atomicdust.com
*/

class BT_GravityForm_Widget extends SiteOrigin_Widget {

	function __construct() {
		//Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

		$choices = array();
		//Show notice if Gravity Forms is not activated
		if (class_exists('RGFormsModel')) {
			
			$forms = RGFormsModel::get_forms(1);
			
		}	else {
			echo "<font style='color:red;font-weight:bold;'>Warning: Gravity Forms is not installed or activated. This field does not function without Gravity Forms!</font>";
		}
		
		//Prevent undefined variable notice
		if(isset($forms)) {
			foreach( $forms as $form ) {
				$choices[ intval($form->id) ] = ucfirst($form->title);
			}
		}

		$form_options = array(
			'gform_content' => array(
				'type' => 'tinymce',
				'label' => __( 'Content before form' , 'basetheme' ),
			),
			'gform' => array(
				'type' => 'select',
				'label' => __( 'Gravity Form' , 'basetheme' ),
				'options' => $choices
			),
			'gform_title' => array(
				'type' => 'checkbox',
				'label' => __( 'Display form title' , 'basetheme' ),
				'default' => false
			),
			'gform_description' => array(
				'type' => 'checkbox',
				'label' => __( 'Display form description' , 'basetheme' ),
				'default' => false
			),
			'gform_ajax' => array(
				'type' => 'checkbox',
				'label' => __( 'Enable AJAX' , 'basetheme' ),
				'default' => true
			),
			'class_custom' => array(
				'type' => 'text',
				'label' => __('Custom classes', 'basetheme'),
				'default' => ''
			),
		);
			
		//Call the parent constructor with the required arguments.
		parent::__construct(
			// The unique id for your widget.
			'bt-gravity-form-widget',
	
			// The name of the widget for display purposes.
			__('AD: Gravity Form', 'basetheme'),
	
			// The $widget_options array, which is passed through to WP_Widget.
			array(
				'description' => __('A widget for displaying a gravity form.', 'basetheme'),
				'panels_icon' => 'widget-icon dashicons basetheme-so-dashicon basetheme-so-dashicon-gravity-form'
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

siteorigin_widget_register('bt-gravity-form-widget', __FILE__, 'BT_GravityForm_Widget');
?>
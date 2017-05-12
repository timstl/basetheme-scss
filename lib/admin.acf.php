<?php
/* ACF Options Page */
if(function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' 	=> 'Site Settings',
		'menu_title'	=> 'Site Settings',
		'menu_slug' 	=> 'site-general-settings',
		'capability'	=> 'manage_options',
		'redirect'		=> false
	));
}

/* Custom Scripts Field Groups */
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_58c94f4463370',
	'title' => 'Custom Scripts',
	'fields' => array (
		array (
			'key' => 'field_58c94f4a25008',
			'label' => 'Custom Header Scripts and CSS',
			'name' => 'custom_header_scripts',
			'type' => 'textarea',
			'instructions' => 'Outputs after wp_head(). Include &lt;script&gt; and &lt;style&gt; tags.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array (
			'key' => 'field_58c94fbf25009',
			'label' => 'Custom Footer Scripts and CSS',
			'name' => 'custom_footer_scripts',
			'type' => 'textarea',
			'instructions' => 'Outputs after wp_footer(). Include &lt;script&gt; and &lt;style&gt; tags.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'directory',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'tribe_events',
			),
		),
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 99,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_58c950368b253',
	'title' => 'Custom Scripts (Site-wide)',
	'fields' => array (
		array (
			'key' => 'field_58c950368f6c7',
			'label' => 'Custom Header Scripts and CSS',
			'name' => 'custom_header_scripts',
			'type' => 'textarea',
			'instructions' => 'Outputs after wp_head(). Include &lt;script&gt; and &lt;style&gt; tags.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array (
			'key' => 'field_58c950368f7cc',
			'label' => 'Custom Footer Scripts and CSS',
			'name' => 'custom_footer_scripts',
			'type' => 'textarea',
			'instructions' => 'Outputs after wp_footer(). Include &lt;script&gt; and &lt;style&gt; tags.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'site-general-settings',
			),
		),
	),
	'menu_order' => 99,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;
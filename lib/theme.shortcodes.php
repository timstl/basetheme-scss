<?php
/* button shortcode */
function _basetheme_bootstrap_button_shortcode($atts) {
	$a = shortcode_atts( array(
		'class' => '',
		'href' => '',
		'text' => '',
		'target' => '',
		'link' => ''
	), $atts );
	
	$target = '';
	
	if ($a['class'] != '') { 
		$a['class'] = ' ' . $a['class'];
	} else {
		$a['class'] = ' btn-primary';
	}
	
	if ($a['href'] == '' && $a['link'] != '') {
		$a['href'] = $a['link'];
	}
	
	if ($a['target'] != '') {
		$target = ' target="' . strip_tags($a['target']) . '"';
	}
	
	return '<a href="' . esc_url($a['href']) . '" class="btn' . strip_tags($a['class']) . '"'.$target.'><span>' . esc_attr($a['text']) . '</span></a>';
}
add_shortcode('button', '_basetheme_bootstrap_button_shortcode');

/* button group shortcode */
function _basetheme_bootstrap_buttongroup_shortcode($atts = [], $content = null) {
	// Remove HTML from buttons. This kills all BRs, but there shouldn't be HTML in your buttons anyway.
	// Could modify later if we find we want to add SVG support within buttons.
	$content = strip_tags($content);
	$content = do_shortcode($content);
	return '<div class="btn-group" role="group" aria-label="button group">'.$content.'</div>';
}
add_shortcode('buttongroup', '_basetheme_bootstrap_buttongroup_shortcode');
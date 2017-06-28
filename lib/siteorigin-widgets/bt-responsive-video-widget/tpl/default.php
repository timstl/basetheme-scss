<?php 
if ($instance['content']) { 
	echo wpautop($instance['content']); 
}

$classes = array('embed-responsive', 'embed-responsive-'.strip_tags($instance['ratio']));
if ($instance['class_custom']) {
	$classes[] = strip_tags($instance['class_custom']);
}
?>
<div class="<?php echo implode(' ', $classes); ?>"><?php echo $instance['embed']; ?></div>
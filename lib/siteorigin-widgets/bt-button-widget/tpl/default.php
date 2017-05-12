<?php
if ($instance['target']) {
	$target = ' target="_blank"';
}

$class = array(strip_tags($instance['class']));

if ($instance['class_ol']) {
	$class[] = 'btn-ol';
}

if ($instance['class_custom']) {
	$class[] = strip_tags($instance['class_custom']);
}
?>
<a href="<?php echo esc_url($instance['link']); ?>" class="btn <?php echo implode(' ', $class); ?>"<?php echo $target; ?>><?php echo esc_attr($instance['text']); ?></a>
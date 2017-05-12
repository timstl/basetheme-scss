<div class="btn-group" role="group" aria-label="button group">
<?php 
foreach( $instance['buttons'] as $i => $button ) :
	if ($button['target']) {
		$target = ' target="_blank"';
	}
	
	$class = array(strip_tags($button['class']));
	
	if ($button['class_ol']) {
		$class[] = 'btn-ol';
	}
	
	if ($button['class_custom']) {
		$class[] = strip_tags($button['class_custom']);
	}
	?>
	<a href="<?php echo esc_url($button['link']); ?>" class="btn <?php echo implode(' ', $class); ?>"<?php echo $target; ?>><?php echo esc_attr($button['text']); ?></a>
<?php endforeach; ?>
</div>
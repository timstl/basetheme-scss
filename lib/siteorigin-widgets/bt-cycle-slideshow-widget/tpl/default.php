<div class="cycle-slideshow" data-cycle-slides="> .slide" data-cycle-swipe="true" data-cycle-fx="scrollHorz" data-cycle-auto-height="calc" data-cycle-timeout="<?php echo intval($instance['timeout']); ?>"<?php if ($instance['controls'] != 'no') { ?> data-cycle-next="> .cycle-controls > .cycle-next" data-cycle-prev="> .cycle-controls > .cycle-prev"<?php } ?>>
	<?php foreach( $instance['slides'] as $i => $slide ) : ?>
	<div class="slide">
		<?php
		switch ($slide['slide_type']) {
			
			case 'embed':
				if ($slide['embed']) {
					$classes = array('embed-responsive', 'embed-responsive-'.strip_tags($slide['ratio']));
					?><div class="<?php echo implode(' ', $classes); ?>"><?php echo $slide['embed']; ?></div><?php
				}
			break;
			
			case 'editor':
				if ($slide['editor']) {
					echo $slide['editor'];
				}			
			break;

			case 'image':
			default:
				if ($slide['image']) { echo wp_get_attachment_image($slide['image'], 'full'); }
			break;
		}
		?>
	</div>
	<?php endforeach; ?>
	
	<?php if ($instance['controls'] != 'no') : ?>
	<div class="cycle-controls">
		<div class="cycle-prev"><?php include(get_template_directory() . '/img/icons/chevron.svg'); ?></div>
		<div class="cycle-next"><?php include(get_template_directory() . '/img/icons/chevron.svg'); ?></div>
	</div>
	<?php endif; ?>
</div>
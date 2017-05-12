<?php
$form_id = intval($instance['gform']);
if (function_exists('gravity_form') && $form_id) :
	
	$classes = array('bt-gravity-form-widget');
	if ($instance['class_custom']) {
		$classes[] = strip_tags($instance['class_custom']);
	}
	?>
	<div class="<?php echo implode(' ', $classes); ?>">
		<div class="in">
			<?php
			if ($instance['gform_content']) { 
				echo $instance['gform_content'];
			}
			
			gravity_form_enqueue_scripts($form_id, true);
			gravity_form( $form_id, $instance['gform_title'], $instance['gform_description'], false, null, $instance['gform_ajax'], $tabindex, true );
			?>
		</div>
	</div>
<?php endif; ?>
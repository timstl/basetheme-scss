<?php if ($instance['content']) { echo wpautop($instance['content']); } ?>
<div class="panel-group" id="accordion-<?php echo $instance['panels_info']['widget_id']; ?>" role="tablist" aria-multiselectable="true">
<?php foreach( $instance['accordion'] as $i => $accordion ) : ?>
	<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="heading-<?php echo $instance['panels_info']['widget_id']; ?>-<?php echo $i; ?>">
		<h2 class="panel-title">
			<a role="button" data-toggle="collapse" data-parent="#accordion-<?php echo $instance['panels_info']['widget_id']; ?>" href="#collapse-<?php echo $instance['panels_info']['widget_id']; ?>-<?php echo $i; ?>" aria-expanded="<?php if ($accordion['open']) { ?>true<?php } else { ?>false<?php } ?>" aria-controls="collapse-<?php echo $instance['panels_info']['widget_id']; ?>-<?php echo $i; ?>">
				<span class="title"><?php echo esc_attr($accordion['title']); ?><?php include(get_template_directory() . '/img/icons/triangle.svg'); ?></span>
				<?php if ($accordion['subtitle']) { ?><br /><span class="subtitle"><?php echo esc_attr($accordion['subtitle']); ?></span><?php } ?>
			</a>
		</h2>
	</div>
	<div id="collapse-<?php echo $instance['panels_info']['widget_id']; ?>-<?php echo $i; ?>" class="panel-collapse collapse<?php if ($accordion['open']) { ?> in<?php } ?>" role="tabpanel" aria-labelledby="heading-<?php echo $i; ?>">
		<div class="panel-body">
			<?php echo wpautop($accordion['content']); ?>
		</div>
	</div>
	</div>
<?php endforeach; ?>
</div>
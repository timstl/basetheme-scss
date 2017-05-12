<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
<?php foreach( $instance['accordion'] as $i => $accordion ) : ?>
	<div class="panel panel-default">
	<div class="panel-heading" role="tab" id="heading-<?php echo $i; ?>">
		<h4 class="panel-title">
			<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse-<?php echo $i; ?>">
				<span><?php echo esc_attr($accordion['title']); ?><?php include(get_template_directory() . '/img/icons/triangle.svg'); ?></span>
			</a>
		</h4>
	</div>
	<div id="collapse-<?php echo $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo $i; ?>">
		<div class="panel-body">
			<?php echo $accordion['content']; ?>
		</div>
	</div>
	</div>
<?php endforeach; ?>
</div>
<?php if ($instance['container']) { ?><div class="container"><?php } ?>
<?php if ($instance['content']) { ?><div class="row"><div class="col col-sm-24"><?php echo wpautop($instance['content']); ?></div></div><?php } ?>
<div class="row bt-bootstrap-column-widget-row">
<?php foreach( $instance['columns'] as $column ) : ?>
	<?php 
	$class = 'col'; 
	if ($column['classes'])	{
		$class .= ' ' . $column['classes'];
	}
	?>
	<div class="<?php echo $class; ?>">
		<div class="in">
			<?php echo wpautop($column['content']); ?>
		</div>
	</div>
<?php endforeach; ?>
</div>
<?php if ($instance['content_below']) { echo wpautop($instance['content_below']); } ?>
<?php if ($instance['container']) { ?></div><?php } ?>

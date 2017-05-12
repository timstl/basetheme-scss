<?php if ($instance['container']) { ?><div class="container"><?php } ?>
<?php if ($instance['content']) { echo $instance['content']; } ?>
<div class="row">
<?php foreach( $instance['columns'] as $column ) : ?>
	<?php 
	$class = 'col'; 
	if ($column['classes'])	{
		$class .= ' ' . $column['classes'];
	}
	?>
	<div class="<?php echo $class; ?>">
		<?php echo $column['content']; ?>
	</div>
<?php endforeach; ?>
</div>
<?php if ($instance['content_below']) { echo $instance['content_below']; } ?>
<?php if ($instance['container']) { ?></div><?php } ?>

<?php if ($instance['content']) { echo $instance['content']; } ?>
<?php foreach( $instance['rows'] as $i => $row ) : ?>
	<div class="content-row">
		<div class="row">
			<div class="col col-sm-10 img">
				<?php echo wp_get_attachment_image($row['thumbnail'], 'full'); ?>
			</div>
			<div class="col col-sm-14 content">
				<?php echo $row['content']; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
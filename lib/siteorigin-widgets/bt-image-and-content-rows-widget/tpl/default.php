<?php if ($instance['content']) { echo wpautop($instance['content']); } ?>
<?php foreach( $instance['rows'] as $i => $row ) : ?>
	<div class="content-row">
		<div class="row">
			<?php 
			$contentcol = 'col-sm-18';
			if ($row['thumbnail']) : 
				$contentcol = 'col-sm-14';	
			?>
			<div class="col col-sm-10 img">
				<?php echo wp_get_attachment_image($row['thumbnail'], 'full'); ?>
			</div>
			<?php endif; ?>
			<div class="col <?php echo $contentcol; ?> content">
				<?php echo wpautop($row['content']); ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
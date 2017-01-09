<div class="col-md-12 main">
	<?php if(isset($notVisible)): ?>
		<div class='404'>
			Page not found.
		</div>
	<?php else: ?>
		<?php if($result['display_title'] == 1):?>
			<?php
				$class = 'align_' . $result['text_placement'];
			?>
			<h2 class="form-signin-heading <?php echo $class; ?>"><?php echo TextSelector($title, $title_fr); ?></h2>
		<?php endif; ?>
			<?php echo TextSelector($content, $content_fr); ?>
	<?php endif; ?>
</div>
<div class="container confirmationPage">
	<?php if(!isset($error)): ?>

	<p class="bg-success" style="border-radius: 10px; padding: 5px;">
	Your registration request was successfully processed.</p> 
	
	<?php if(isset($ConfMail)): ?>
	<div class='confirmationMail'>
		<?php echo $ConfMail; ?>
	</div>
	<?php endif; ?>
	<?php else: ?>
		<div class='error'><?php echo $error; ?></div>
	<?php endif; ?>

</div>

<div class="main">

	<?php 
		if(isset($success) && $success == 1 && isset($_POST)){
			echo "<h2 id='success'>Your e-mail has been sent successfully!</h2>";
			?>
			<script> setTimeout(function(){ $('#success').fadeOut('slow'); }, 1000); </script>
			<?php
		}
	
	?>
	
	
	<h2 class="form-signin-heading"><?php echo TextSelector("Contact Us", "Contactez Nous"); ?></h2>
		<div class="col-md-12">
			<?php if(isset($contactInfo)): ?>
				<address>
					<?php
						$line = $contactInfo['city'] . ", " . $contactInfo['provinceState'] . ", " . $contactInfo['postal'];
						if($line == ", , "){
							$line = "";
						}
					?>
					<strong><?php echo $contactInfo['title']; ?></strong><br>
					<?php echo $contactInfo['address']; ?><br>
					<?php echo $line; ?>
				</address>
			<?php endif; ?>
		</div>
		<form action="" method="post" role="form" id="contactForm">
			<div class="col-md-12">
				<label><?php echo TextSelector("Your Email*", "Votre Adresse Electronique*"); ?></label>
				<input type="text" class="form-control" name="sender_email" id="sender_email" value="<?php if(isset($_POST['sender_email'])){ echo $_POST['sender_email']; } ?>" required/>
			</div>
			<div class="col-md-12">
				<label><?php echo TextSelector("Subject*", "Sujet*"); ?></label>
				<input type="text" class="form-control" name="sender_subject" id="sender_subject" value="<?php if(isset($_POST['sender_subject'])){ echo $_POST['sender_subject']; } ?>" required/>
			</div>
			<div class="col-md-12">
				<label>Message*</label>
				<textarea class="form-control" name="sender_message" id="sender_message" rows="10" required><?php if(isset($_POST['sender_message'])){ echo $_POST['sender_message']; } ?></textarea>
			</div>
			<div class="col-md-12"></div>
			<div class="col-md-12">
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="send_message" id="send_message"><?php echo TextSelector("Send Message", "Envoyer"); ?></button>
			</div>
		</form>

<script>
$("#contactForm").validate({
	rules:{
		sender_email:{
			required:true,
			email:true
		},
		sender_subject:"required",
		sender_message:"required"
	},
	messages:{
		sender_email: {
			required: "We need your e-mail address to contact you back",
			email: "Your email address must be in the format of name@domain.com"
		},
		sender_subject:"Please enter a subject to your message",
		sender_message:"Please enter a message"
	},
	invalidHandler: function(event, validator) {
	    // 'this' refers to the form
	    var errors = validator.numberOfInvalids();
	    if (errors) {
	      var message = errors == 1
	        ? 'You missed 1 field. It has been highlighted'
	        : 'You missed ' + errors + ' fields. They have been highlighted';
	      alert(message);
	      
	    } else {
	      $("div.error").hide();
	    }
      }
});
</script>

</div>
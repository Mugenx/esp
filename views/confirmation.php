<?php
// FileName:     confirmation.php
// Author:       EventSystemPro
// Copyright:    © EVENTSYSTEMPRO 2016. ALL RIGHTS RESERVED.
// Web Version:  3.0000
// Date:         12/10/2016
?>
<?php if (intval($eventDetails['payment_processor']) == 1): ?>
<?php

	// **********************************************************************************************************//
	// This is Moneris.
	// **********************************************************************************************************//

	// ******* THERE IS NO MONERIS PROCESSING CODE AT THIS TIME ************************//

?>
<?php elseif (intval($eventDetails['payment_processor']) == 2): ?>
<?php

	// **********************************************************************************************************//
	// This is Beanstream.
	// **********************************************************************************************************//

?>
<div class="container confirmationPage">
	<?php if(!isset($error)): ?>
	<h2>Registration Confirmation: <?php echo $title; ?></h2>
<?php if($regInfo['event_option'] != "No Value"): ?>
	<p class="bg-success" style="border-radius: 10px; padding: 5px;">
	Your registration was saved successfully. <strong>Please click on the link below to open your invoice in a new window and print it off for processing.</strong></p>
	
	<div class="invoiceLink">
		<a href="<?php echo $eventDetails['directory_name']; ?>/invoice/<?php echo $regInfo['reguniqid']; ?>" target="_blank" class="btn btn-primary">View Invoice</a>
	</div>
	<div id="payment">
	<h3>Payment</h3>
	<?php if($registrant[0]['paid'] == 0): ?>
	<p>
		</p>
		<?php
			//Check if billing info exists
			if($eventDetails['pay_to_name'] != "" && $eventDetails['pay_to_address'] != ""):
		?>
			<p>Please make cheques payable to:<br>
			<?php echo $eventDetails['pay_to_name'];?><br>
			<?php echo explode('|', $eventDetails['pay_to_address'])[0]; ?> <?php echo explode('|', $eventDetails['pay_to_address'])[1]; ?>, <?php echo explode('|', $eventDetails['pay_to_address'])[2]; ?>, <?php echo explode('|', $eventDetails['pay_to_address'])[3]; ?><br>
			<?php if($eventDetails['business_number'] != ""):?>
				<p>HST/GST <?php echo $eventDetails['business_number']; ?></p>
			<?php endif; ?>
		 <?php endif; ?>
		</p>				
		<form action="<?php echo THESITE; ?>/<?php echo $eventDetails['directory_name']; ?>/payment/<?php echo $regInfo['registrant_id']; ?>" method="POST"><input type="hidden" name="invoice_id" value="<?php echo $invoiceInfo['invoice_id']; ?>"><input type="hidden" name="reg_id" value="<?php echo $regInfo['registrant_id']; ?>">			
		<p>To pay your invoice via Credit Card, please click the "Pay Now" button below.<br><img src="https://www.verney.ca/images/visa.gif" style="position: relative; top: 5px;"> <img src="https://www.verney.ca/images/mastercard.gif" style="position: relative; top: 5px;"> <img src="https://www.verney.ca/images/amex.gif" style="position: relative; top: 5px;"> <br><input type="submit" name="btnPayNow" value="Pay Now" style="margin-top:10px;" id="paynowbutton" class="btn btn-primary"></p></form>
	<?php else: ?>
		<p>Paid</p>
		<p><?php echo str_replace("|", ", ", $regInfo['pd_comments']); ?></p>									
	<?php endif; ?>		
	</div>
	<?php endif; ?>
	<?php if(isset($ConfMail)): ?>
	<div class='confirmationMail'>
		<?php echo $ConfMail; ?>
	</div>
	<?php endif; ?>
	<?php else: ?>
		<div class='error'><?php echo $error; ?></div>
	<?php endif; ?>
</div>
<?php elseif (intval($eventDetails['payment_processor']) == 3): ?>
<?php

	// **********************************************************************************************************//
	// This is Stripe.
	// **********************************************************************************************************//

?>
	<div class="esp_container confirmationPage">
		<h1><?php echo $title.": ".$eventDetails['etitle']; ?></h1>
		<p>Your registration for <?php echo $eventDetails['etitle']; ?> has been successfully saved!</p>
<?php if($regInfo['event_option'] != "No Value"): //There is a charge for registering. ?>
		<p>Please click on the View Invoice button to open your invoice in a new window so that you may print it for payment processing.</p>
		<div class="invoiceLink">
			<a href="<?php echo THESITE."/".$eventDetails['directory_name']; ?>/invoice/<?php echo $regInfo['reguniqid']; ?>" target="_blank" class="btn btn-primary">View Invoice</a>
		</div>
<?php
	$paymentLink = "<a href=\"".THESITE."/".$eventDetails['directory_name']."/payment_stripe/".$regInfo['registrant_id']."\" target=\"_top\">here</a>";
?>
		<p>To pay your invoice now, click <?php echo $paymentLink; ?> to be taken to our payment page.</p>
<?php endif; //event_option ?>
		<p>Thank you for registering for the <?php echo $eventDetails['etitle']; ?>. We look forward to seeing you there!</p>
	</div>
<?php endif; //global if statement ?>

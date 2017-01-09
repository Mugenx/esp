<?php
// FileName:     payment_declined.php
// Author:       EventSystemPro
// Copyright:    © EVENTSYSTEMPRO 2016. ALL RIGHTS RESERVED.
// Web Version:  3.0000
// Date:         12/9/2016
// **********************************************************************************//
// IMPORTANT:    This version is customized specifically for the Maritech2017 event. //
// **********************************************************************************//
?>
	<div class="esp_container confirmationPage">
		<h1><?php echo $title.": ".$eventInfo['etitle']; ?></h1>
		<p>Your registration for <?php echo $eventInfo['etitle']; ?> has been successfully saved!</p>
		<p>Please click on the View Invoice button to open your invoice in a new window so that you may print it for payment processing.</p>
		<div class="invoiceLink">
			<a href="<?php echo THESITE."/".$eventInfo['directory_name']; ?>/invoice/<?php echo $regInfo['reguniqid']; ?>" target="_blank" class="btn btn-primary">View Invoice</a>
		</div>
		<p>To pay your invoice now with another credit card, click <a href="<?php echo THESITE."/".$eventInfo['directory_name']; ?>/payment_stripe/<?php echo $regInfo['registrant_id']; ?>" target="_top">here</a> to be taken back to our payment page.</p>
		<p>If you would like to pay your invoice by cheque, please contact us at <?php echo $eventInfo['pay_to_tel']; ?> to advise us that you will be sending a cheque, or send us an email by clicking on this link: <a href="mailto:<?php echo $eventInfo['eEmail']; ?>"><?php echo $eventInfo['eEmail']; ?></a></p>
		<p>Thank you for registering for the <?php echo $eventInfo['etitle']; ?>. We look forward to seeing you there!</p>
	</div>

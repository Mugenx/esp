<?php
// FileName:     payment_confirmation.php
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
		<p>Your registration for <?php echo $eventInfo['etitle']; ?> has been successfully saved, and your payment has been received!</p>
		<p>Please click on the View Invoice button to open your invoice in a new window so that you may print it for your records.</p>
		<div class="invoiceLink">
			<div class="esp-btn-center">
				<a href="<?php echo THESITE."/".$eventInfo['directory_name']; ?>/invoice/<?php echo $regInfo['reguniqid']; ?>" target="_blank" class="btn btn-primary">View Invoice</a>
			</div>
		</div>
		<p>Thank you for registering for the <?php echo $eventInfo['etitle']; ?>. We look forward to seeing you there!</p>
	</div>
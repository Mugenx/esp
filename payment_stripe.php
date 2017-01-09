<?php
// FileName:     payment_stripe.php
// Author:       EventSystemPro
// Copyright:    © EVENTSYSTEMPRO 2016. ALL RIGHTS RESERVED.
// Web Version:  3.0000
// Date:         12/9/2016
// **********************************************************************************//
// IMPORTANT:    This version is customized specifically for the Maritech2017 event. //
// **********************************************************************************//
?>
	<div class="esp_container">
<?php if ((isset($errors)) && (!empty($errors))): ?>
<?php
echo "			<ul class=\"list-group\">\n";
foreach ($errors as $e) {
	echo "				<li class=\"list-group-item list-group-item-danger\">".$e."</li>\n";
} //end of foreach
echo "			</ul>\n";
?>
<?php else: ?>
	<link href="css/invoice2.css" rel="stylesheet">
	<h1><?php echo $eventInfo['etitle'];?></h1>
	<h3>Payment Form: Invoice No. <?php echo $regInfo['confcode'];?></h3>
<?php if ($eventInfo['force_payment'] == 1): ?>
	<p>Please click on the PAY NOW button to pay this invoice by credit card. <img src="https://www.verney.ca/images/visa.gif" style="position: relative;"> <img src="https://www.verney.ca/images/mastercard.gif" style="position: relative;"> <img src="https://www.verney.ca/images/amex.gif" style="position: relative;"></p>
<?php else: ?>
	<p>Please click on the PAY NOW button to apply a payment by credit card to this Invoice. <img src="https://www.verney.ca/images/visa.gif" style="position: relative;"> <img src="https://www.verney.ca/images/mastercard.gif" style="position: relative;"> <img src="https://www.verney.ca/images/amex.gif" style="position: relative;"></p>
<?php endif; ?>
	<h4>Summary of Charges for Invoice No. <?php echo $regInfo['confcode'];?></h4>
	<table class="invoiceTbl">
		<thead>
			<tr>
				<th id="eventcol" class="invoiceTblHdg" width="60%">Event / Sélection</th>
				<th id="confcol" class="invoiceTblHdg" width="25%">Confirmation No. / N° de Confirmation</th>
				<th id="costcol" class="invoiceTblHdg" width="15%">Cost / Prix</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td headers="eventcol" class="invoiceItems" width="60%">
<?php echo "					<p>".$eventInfo['etitle']."</p>\n"; ?>
<?php
// Start with leader
$leaderStr = $regInfo['first_name'] . " " . $regInfo['last_name'];
$selection = "";
if (strlen($regselect['range']) > 0) {
	$selection = " <span class=\"b\">(" . $regselect['range'] . ")</span>";
} //end of if
echo "					<p>".$leaderStr.": ".$regselect['name'].$selection."</p>\n";
if ($regInfo['promo_code_used'] != "") {
	$promoUsed = strtoupper($regInfo['promo_code_used']);
	echo "					<p>".$leaderStr.": Promocode [".$promoUsed."]</p>\n";
} //end of if
if (!empty($regEO)) {
	foreach($regEO as $eo) {
		$eoSelection = "";
		if (strlen($eo['range']) > 0) {
			$eoSelection = " <span class=\"b\">(".$eo['range'].")</span>";
		} //end of if
		echo "					<p>".$leaderStr.": ".$eo['name'].$eoSelection."</p>\n";
	} //end of foreach
} //end of if
if (!empty($delegates)) {
	foreach($delegates as $delegate) {
		$delStr = $delegate['name'];
		$delselection = "";
		if (strlen($delegate['selectionRange']) > 0) {
			$delselection = " <span class=\"b\">(".$delegate['selectionRange'].")</span>";
		} //end of if
		echo "					<p>".$delegate['name'].": ".$delegate['selection'].$delselection."</p>\n";
		if (!empty($delegate['extraOptions'])) {
			foreach($delegate['extraOptions'] as $deo) {
				$deoSelection = "";
				if (strlen($deo['range']) > 0) {
					$deoSelection = " <span class=\"b\">(".$deo['range'].")</span>";
				} //end of if
				echo "					<p>".$delegate['name'].": ".$deo['name'].$deoSelection."</p>\n";
			} //end of foreach
		} //end of if
		if (!empty($delegate['discount'])) {
			$promoUsed = strtoupper($delegate['discount']['promo']);
			echo "					<p>".$delStr.": Promocode [".$promoUsed."]</p>\n";
		} //end of if
	} //end of foreach
} //end of if
if ($invoiceInfo['customDiscount'] != 0.00) {
	echo "					<p>Custom Discount</p>\n";
	} elseif($invoiceInfo['gd_used'] == 1 && $invoiceInfo['discount'] == 0.00) {
	echo "					<p>Group Discount</p>\n";
} //end of if
if ($regInfo['paid']) {
	echo "					<p><img src=\"img/paid.jpg\" alt=\"paid\" /></p>\n";
} //end of if
?>
				</td>
				<td headers="confcol" class="invoiceItems" width="25%"><p><?php echo $regInfo['confcode']; ?></p></td>
				<td headers="costcol" class="invoiceItems" align="right" width="15%">
<?php echo "					<p align=\"right\">&nbsp;</p>\n"; ?>
<?php
$price = number_format($regselect['price'], 2, '.', ',');
echo "					<p align=\"right\">$ ".$price."</p>\n";
if ($regInfo['promo_code_used'] != "") {
	$discount = number_format($promoDiscount, 2, '.', ',');
	echo "					<p align=\"right\"><span class=\"red\">- $ ".$discount."</span></p>\n";
} //end of if
if (!empty($regEO)) {
	foreach($regEO as $eo) {
		$price = number_format($eo['price'], 2, '.', ',');
		echo "					<p align=\"right\">$ ".$price."</p>\n";
	} //end of foreach
} //end of if
if (!empty($delegates)) {
	foreach($delegates as $delegate) {
		$price = number_format($delegate['price'], 2, '.', ',');
		echo "					<p align=\"right\">$ ".$price."</p>\n";
		if (!empty($delegate['extraOptions'])) {
			foreach($delegate['extraOptions'] as $deo) {
				$extraCost = number_format($deo['price'], 2, '.', ',');
				echo "					<p align=\"right\">$ ".$extraCost."</p>\n";
			} //end of foreach
		} //end of if
		if (!empty($delegate['discount'])) {
			$discount = number_format($delegate['discount']['amount'], 2, '.', ',');
			echo "					<p align=\"right\"><span class=\"red\">- $ ".$discount."</span></p>\n";
		} //end of if
	} //end of foreach
} //end of if
if ($invoiceInfo['customDiscount'] != 0.00) {
	$discount = number_format($invoiceInfo['customDiscount'], 2, '.', ',');
	echo "					<p align=\"right\"><span class=\"red\">- $ ".$discount."</span></p>\n";
	} elseif ($invoiceInfo['gd_used'] == 1 && $invoiceInfo['discount'] == 0.00) {
	$discount = number_format($realGRP, 2, '.', ',');
	echo "					<p align=\"right\"><span class=\"red\">- $ ".$discount."</span></p>\n";
} //end of if
?>
				</td>
			</tr>
<?php 
$taxAmount = $invoiceInfo['invoice_tax_cost'];
if ($regInfo['tax_exempt'] == 1) {
	$taxAmount = "Exempt";
} else {
	$taxAmount = "$ " . number_format($taxAmount, 2, '.', ',');
} //end of if
?>
<?php if ($invoiceInfo['discount'] != 0.00): ?>
			<tr>
				<td id="gstcol" colspan="2" class="invoiceTotalHdgs" width="85%">Total Discount / Rabais Total:</td>
				<td headers="gstcol costcol" class="invoiceTotalVals" width="15%"><span class="red">- $ <?php echo number_format($invoiceInfo['discount'], 2, '.', ','); ?></span>span></td>
			</tr>
<?php endif; ?>
			<tr>
				<td id="gstcol" colspan="2" class="invoiceTotalHdgs" width="85%">Sub-Total / Sous-Total:</td>
				<td headers="gstcol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format($invoiceInfo['invoice_cost'], 2, '.', ','); ?></td>
			</tr>
			<tr>
				<td id="gstcol" colspan="2" class="invoiceTotalHdgs" width="85%"><?php echo $eventInfo['tax_desc']." (".($invoiceInfo['invoice_tax_rate'] * 100)."%)"; ?>:</td>
				<td headers="gstcol costcol" class="invoiceTotalVals" width="15%"><?php echo $taxAmount; ?></td>
			</tr>
<?php if($regInfo['paid'] == 0 && $regInfo['amount_paid'] == 0.00): ?>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Total (<?php echo $invoiceInfo['invoice_currency']; ?>$):</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format($invoiceInfo['invoice_total_cost'], 2, '.', ','); ?></td>
			</tr>
<?php else: ?>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Total (<?php echo $invoiceInfo['invoice_currency']; ?>$):</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format($invoiceInfo['invoice_total_cost'], 2, '.', ','); ?></td>
			</tr>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Amount Paid / Paiements antérieurs:</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format($invoiceInfo['paid_amount'], 2, '.', ','); ?></td>
			</tr>
<?php
// Alternative line for amount to be paid...
/*			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Balance Due / Solde dû (<?php  echo $invoiceInfo['invoice_currency']; ?>$):</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format((floatval($invoiceInfo['invoice_total_cost']) - floatval($invoiceInfo['paid_amount'])), 2, '.', ','); ?></td>
			</tr>*/
?>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Please pay this amount / Montant à payer (<?php  echo $invoiceInfo['invoice_currency']; ?>$):</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format((floatval($invoiceInfo['invoice_total_cost']) - floatval($invoiceInfo['paid_amount'])), 2, '.', ','); ?></td>
			</tr>
<?php endif; ?>
		</tbody>
	</table>
<?php //This is the PAY NOW button.  ?>
	<div class="stripeButton">
		<div class="esp-btn-right">
			<form action="<?php echo THESITE."/".$eventInfo['directory_name']; ?>/do_payment_stripe/<?php echo $regID; ?>" id="payment-form" method="post">
				<input type="hidden" name="invoice_id" value="<?php echo $invID; ?>">
				<input type="hidden" name="reg_id" value="<?php echo $regID; ?>">
				<input type="hidden" name="custemail" value="<?php echo $regInfo['email']; ?>">
				<input type="hidden" name="invcurr" value="<?php echo $invoiceInfo['invoice_currency']; ?>">
				<input type="hidden" name="amt" value="<?php echo ($invoiceInfo['invoice_total_cost'] - $invoiceInfo['paid_amount']) * 100; ?>">
				<script src="https://checkout.stripe.com/checkout.js" class="stripe-button" 
							data-key="<?php echo $stripe_key; ?>" 
							data-image="https://creativerelationsplanners.ca/uploads/images/CreativeRelationsLogo.png" 
							data-name="<?php echo $eventInfo['etitle'];?>" 
							data-description="Invoice No. <?php echo $regInfo['confcode'];?>" 
							data-amount="<?php echo ($invoiceInfo['invoice_total_cost'] - $invoiceInfo['paid_amount']) * 100; ?>" 
							data-locale="en" 
							data-currency="<?php echo strtolower($invoiceInfo['invoice_currency']); ?>" 
							data-zip-code="true" 
							data-label="PAY NOW" 
							data-allow-remember-me="false">
				</script>
			</form>
		</div>
	</div>
	<div style="margin-top:20px;text-align:center;height:70px;">
<?php //Dec 9/16 - This Starfieldtech SSL Seal is specific to CreativeRelationsPlanners.ca  Barry Watt ?>
		<div style="float:left; width:50%;"><span id="siteseal"><script async type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=6yS7aOQC2jjyb8lQaseheKvSFO8UM2xSFKz9w7Wk8li52MA7Zr0dE5oLldF9"></script></span></div>
		<div style="float:left;  width:50%;"><table width="135" border="0" cellpadding="1" cellspacing="1" style="display:inline"><tr><td width="135" align="center"><script src="https://sealserver.trustkeeper.net/compliance/seal_js.php?code=w6otlmxxrpqOQRKHKImBsdOFgYY9qj&style=invert&size=105x54&language=en"></script><noscript><a href="https://sealserver.trustkeeper.net/compliance/cert.php?code=w6otlmxxrpqOQRKHKImBsdOFgYY9qj&style=invert&size=105x54&language=en" target="hATW"><img src="https://sealserver.trustkeeper.net/compliance/seal.php?code=w6otlmxxrpqOQRKHKImBsdOFgYY9qj&style=invert&size=105x54&language=en" border="0" alt="Trusted Commerce"/></a></noscript></td></tr></table></div>
	</div>
	</div>
<?php endif; ?>

<?php
// FileName:     invoice.php
// Author:       EventSystemPro
// Copyright:    © EVENTSYSTEMPRO 2016. ALL RIGHTS RESERVED.
// Web Version:  3.0000
// Date:         12/13/2016
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<base href="<?php echo THESITE; ?>" />
	<title><?php echo ucwords($title); ?></title>
	<link href="css/invoice.css" rel="stylesheet" />
	<meta name="revision" content="3.0000" />
	<meta name="date" content="12/10/2016" />
	<meta name="expires" content="Mon, 1 Jan 1996 01:00:00 GMT" />
	<meta name="copyright" content="© EventSystemPro <?php echo date('Y'); ?>. All Rights Reserved." />
	<meta name="keywords" content="" />
	<meta name="description" content="<?php if(isset($description)){ echo ucwords($description); } ?>" />
	<meta name="author" content="EventSystemPro" />
</head>
<body>
<?php
?>
<?php if(isset($eventInfo) && isset($registrantInfo)): ?>
<div id="noprint"><button class="printBtn" onClick="javascript:print();">Print / Imprimer</button></div>
<div class="clearFix"></div>
<div id="invoice">
	<div id="invoice-header">
		<div id="invoice-company">
<?php if ($eventInfo['logoImg'] != "") { echo "			<img id=\"invoiceLogo\" src=\"".$eventInfo['logoImg']."\" />\n"; } ?>
<?php if ($eventInfo['pay_to_name'] != "") {
	$payToCompany = "			<div class=\"invoiceCompName\">".$eventInfo['pay_to_name']."</div>\n";
	echo $payToCompany;
} //end of if
?>
<?php
if ($eventInfo['pay_to_address'] != "") {
	//Explode the string into distinct address segments: [0] = street address, [1] = city, [2] = province/state, [3] = postal/zip code.
	$addressParts = explode('|', $eventInfo['pay_to_address']);
	$payTo = "			<div class=\"invoiceAddress\">\n"
				."				<p>".$addressParts[0]."</p>\n"
				."				<p>".$addressParts[1].", ".$addressParts[2]."</p>\n"
				."				<p>".$addressParts[3]."</p>\n"
				."			</div>\n";
	$payToPayment = "			<div class=\"invoiceAddress\">"
				."<p>".$addressParts[0]."</p>"
				."<p>".$addressParts[1].", ".$addressParts[2]."</p>"
				."<p>".$addressParts[3]."</p>"
				."</div>\n";
	echo $payTo;
} //end of if
?>
<?php
$tel = "";
$fax = "";
if ($eventInfo['pay_to_tel'] != "") {
	$tel = "			<div class=\"invoiceTelFax\"><span class=\"b\">Tel/Tél:</span> ".$eventInfo['pay_to_tel']."</div>\n";
	echo $tel;
} //end of if
if (($eventInfo['pay_to_fax'] != "") && ($eventInfo['pay_to_fax'] != "NA") && ($eventInfo['pay_to_fax'] != "N/A")) {
	$fax = "			<div class=\"invoiceTelFax\"><span class=\"b\">Fax:</span> ".$eventInfo['pay_to_fax']."</div>\n";
	echo $fax;
} //end of if
?>
<?php
$busNum = "";
if ($eventInfo['business_number'] != "") {
	$busNum = "			<div class=\"invoiceBusNum\"><span class=\"b\">GST/HST:</span> ".$eventInfo['business_number']."</div>\n";
	echo $busNum;
} //end of if
?>
		</div><!--/invoice-company -->
		<div id="invoice-details">
			<div class="invoiceHeading">Invoice / Facture</div>
			<div class="invoiceNo">No. / N°: <?php echo $registrantInfo['confcode']; ?></div>
			<table class="invoiceDetailsTbl">
				<tr>
					<td class="invoiceDetailsTblHdg">Date:</td>
					<td class="invoiceDetailsTblVal"><?php echo $invoiceInfo['invoice_date']; ?></td>
				</tr>
				<tr>
					<td class="invoiceDetailsTblHdg">Terms / Termes:</td>
					<td class="invoiceDetailsTblVal">Due on / Dû à: <?php echo $startDate; ?></td>
				</tr>
			</table>
		</div><!--/invoice-details -->
	</div><!--/invoice-header -->
	<div class="clearFix"></div>
	<div id="billTo-header">
		<div id="billToBox">
			<div class="billToHeading">Bill To / Facturer à</div>
			<div class="billToClient">
<?php
echo "				<p>".$registrantInfo['first_name']." ". $registrantInfo['last_name']."</p>\n"
		."				<p>".$registrantInfo['organization']."</p>\n"
		."				<p>".$registrantInfo['address1']."</p>\n"
		."				<p>".$registrantInfo['city'].", ".$registrantInfo['province']."</p>\n"
		."				<p>".$registrantInfo['postal']."</p>\n";
?>
			</div> <!-- .billToClient -->
		</div> <!-- .billToBoz -->
	</div> <!-- .billTo-header -->
	<div class="clearFix"></div>
	<table class="invoiceTbl">
		<thead>
			<tr>
				<th id="eventcol" class="invoiceTblHdg" width="60%">Event / Sélection</th>
				<th id="confcol" class="invoiceTblHdg" width="25%">Confirmation No. / N° de Confirmation</th>
				<th id="costcol" class="invoiceTblHdg" width="15%">Cost / Prix</th>
			</tr>
		</thead>
		<tbody>
			<tr class="invoiceHeight">
				<td headers="eventcol" class="invoiceItems" width="60%">
<?php echo "					<p>".$eventInfo['etitle']."</p>\n"; ?>
<?php
// Start with leader
$leaderStr = $registrantInfo['first_name'] . " " . $registrantInfo['last_name'];
$selection = "";
if (strlen($regselect['range']) > 0) {
	$selection = " <span class=\"b\">(" . $regselect['range'] . ")</span>";
} //end of if
echo "					<p>".$leaderStr.": ".$regselect['name'].$selection."</p>\n";
if ($registrantInfo['promo_code_used'] != "") {
	$promoUsed = strtoupper($registrantInfo['promo_code_used']);
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
if ($registrantInfo['paid'] == 1) {
	echo "					<p><img src=\"img/paid.jpg\" alt=\"paid\" /></p>\n";
} //end of if
?>
				</td>
				<td headers="confcol" class="invoiceItems" width="25%"><p><?php echo $registrantInfo['confcode']; ?></p></td>
				<td headers="costcol" class="invoiceItems right" width="15%">
<?php echo "					<p>&nbsp;</p>\n"; ?>
<?php
$price = number_format($regselect['price'], 2, '.', ',');
echo "					<p>$ ".$price."</p>\n";
if ($registrantInfo['promo_code_used'] != "") {
	$discount = number_format($promoDiscount, 2, '.', ',');
	echo "					<p><span class=\"red\">- $ ".$discount."</span></p>\n";
} //end of if
if (!empty($regEO)) {
	foreach($regEO as $eo) {
		$price = number_format($eo['price'], 2, '.', ',');
		echo "					<p>$ ".$price."</p>\n";
	} //end of foreach
} //end of if
if (!empty($delegates)) {
	foreach($delegates as $delegate) {
		$price = number_format($delegate['price'], 2, '.', ',');
		echo "					<p>$ ".$price."</p>\n";
		if (!empty($delegate['extraOptions'])) {
			foreach($delegate['extraOptions'] as $deo) {
				$extraCost = number_format($deo['price'], 2, '.', ',');
				echo "					<p align=\"right\">$ ".$extraCost."</p>\n";
			} //end of foreach
		} //end of if
		if (!empty($delegate['discount'])) {
			$discount = number_format($delegate['discount']['amount'], 2, '.', ',');
			echo "					<p><span class=\"red\">- $ ".$discount."</span></p>\n";
		} //end of if
	} //end of foreach
} //end of if
if ($invoiceInfo['customDiscount'] != 0.00) {
	$discount = number_format($invoiceInfo['customDiscount'], 2, '.', ',');
	echo "					<p><span class=\"red\">- $ ".$discount."</span></p>\n";
	} elseif ($invoiceInfo['gd_used'] == 1 && $invoiceInfo['discount'] == 0.00) {
	$discount = number_format($realGRP, 2, '.', ',');
	echo "					<p><span class=\"red\">- $ ".$discount."</span></p>\n";
} //end of if
?>
				</td>
			</tr>
<?php 
$taxAmount = $invoiceInfo['invoice_tax_cost'];
if ($registrantInfo['tax_exempt'] == 1) {
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
				<td id="gstcol" colspan="2" class="invoiceTotalHdgs" width="85%"><?php echo $invoiceInfo['invoice_tax_type']." (".($invoiceInfo['invoice_tax_rate'] * 100)."%)"; ?>:</td>
				<td headers="gstcol costcol" class="invoiceTotalVals" width="15%"><?php echo $taxAmount; ?></td>
			</tr>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Total (<?php echo $invoiceInfo['invoice_currency']; ?>$):</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format($invoiceInfo['invoice_total_cost'], 2, '.', ','); ?></td>
			</tr>
<?php if ($invoiceInfo['refund_amount'] > 0): ?>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Credit (Refunded) / Crédit (Remboursé):</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%"><span class="red">- $ <?php echo number_format($invoiceInfo['refund_amount'], 2, '.', ','); ?></span></td>
			</tr>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Amount Paid / Paiements antérieurs:</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format($invoiceInfo['paid_amount'], 2, '.', ','); ?></td>
			</tr>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Please pay this amount / Montant à payer (<?php  echo $invoiceInfo['invoice_currency']; ?>$):</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format((floatval($invoiceInfo['invoice_total_cost'] - $invoiceInfo['paid_amount'])), 2, '.', ','); ?></td>
			</tr>
<?php elseif($invoiceInfo['paid_amount'] > 0.00): ?>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Amount Paid / Paiements antérieurs:</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format($invoiceInfo['paid_amount'], 2, '.', ','); ?></td>
			</tr>
			<tr>
				<td id="paycol" colspan="2" class="invoiceTotalHdgs" width="85%">Please pay this amount / Montant à payer (<?php  echo $invoiceInfo['invoice_currency']; ?>$):</td>
				<td headers="paycol costcol" class="invoiceTotalVals" width="15%">$ <?php echo number_format((floatval($invoiceInfo['invoice_total_cost'] - $invoiceInfo['paid_amount'])), 2, '.', ','); ?></td>
			</tr>
<?php endif; ?>
		</tbody>
	</table>
	<div id="paymentCancellation">
		<div id="paymentBox">
			<div class="paymentHeading">Payment / Paiement</div>
			<div class="paymentDetails">
<?php if($registrantInfo['paid'] == 0): ?>
				<p>Please make cheques payable to / Veuillez faire les chèques payables à:</p>
	<?php echo $payToCompany; ?>
	<?php echo $payToPayment; ?>
	<?php echo $busNum; ?>
<?php
if (intval($eventInfo['payment_processor']) == 1) {
	//This is Moneris.
	// ******* THERE IS NO MONERIS PROCESSING CODE AT THIS TIME ************************//
	} elseif (intval($eventInfo['payment_processor']) == 2) {
	//This is Beanstream. ?>
				<form action="<?php echo THESITE; ?>/<?php echo $eventInfo['directory_name']; ?>/payment" method="POST"><input type="hidden" name="invoice_id" value="<?php echo $invoiceInfo['invoice_id']; ?>"><input type="hidden" name="reg_id" value="<?php echo $invoiceInfo['registrant_id']; ?>">
					<p>To pay your invoice by Credit Card, please click the "Pay Now" button below.</p>
					<p>Pour payez par carte de crédit, s'il vous plaît cliquez sur le bouton "Payer maintenant" ci-dessous.</p>
					<p><img src="https://www.verney.ca/images/visa.gif" style="position: relative; top: 5px;"> <img src="https://www.verney.ca/images/mastercard.gif" style="position: relative; top: 5px;"> <img src="https://www.verney.ca/images/amex.gif" style="position: relative; top: 5px;"></p>
					<p><input type="submit" name="btnPayNow" value="Pay Now / Payer maintenant" style="margin-top:10px;" id="paynowbutton"></p>
				</form>
<?php	} elseif (intval($eventInfo['payment_processor']) == 3) {
	//This is Stripe. ?>
				<p>To pay your invoice by Credit Card, please click the "Pay Now" button below.</p>
				<p>Pour payez par carte de crédit, s'il vous plaît cliquez sur le bouton "Payer maintenant" ci-dessous.</p>
				<a href="<?php echo THESITE; ?>/<?php echo $eventInfo['directory_name']; ?>/payment_stripe/<?php echo $invoiceInfo['registrant_id']; ?>" target="_top"><button name="btnPayNow" id="paynowbutton" style="margin-top:10px;">Pay Now / Payer maintenant</button></a>
				<p><img src="https://www.verney.ca/images/visa.gif" style="position: relative; top: 5px;"> <img src="https://www.verney.ca/images/mastercard.gif" style="position: relative; top: 5px;"> <img src="https://www.verney.ca/images/amex.gif" style="position: relative; top: 5px;"></p>
<?php } //end of if ?>
<?php else: ?>
<?php 
// Dec 8/16 - This is redundant information for the invoice. Barry Watt
//if ($invoiceInfo['paid_type'] != "" && $invoiceInfo['paid_date'] != "0000-00-00 00:00:00") {
//	$populatedComments = "				<p>Paid by / Payé par ".$invoiceInfo['paid_type']." on / à la ".$invoiceInfo['paid_date']."</p>\n";
//} //end of if
$populatedComments = "";
if ($invoiceInfo['paid_type'] == "Cheque") {
	$chequeNumber = $invoiceInfo['cheque_number'];
	$chequeDate = $invoiceInfo['cheque_date'];
	if ($chequeNumber != "" && $chequeDate != "0000-00-00") {
		$populatedComments .= "				<p>Cheque No. / N° du chèque: ".$chequeNumber."</p>\n"
									."				<p>Cheque Date / Date du  chèque: ".$chequeDate."</p>\n";
	} //end of if
} //end of if
// This is from the payments table.
$paymentAmounts = "";
if ((isset($payments)) && (is_array($payments)) && (!empty($payments))) {
	$paymentAmounts = "				<div>\n";
	$paymentAmounts .= "					<p>Payments Received / Paiements Reçu</p>\n";
	foreach($payments as $payment) {
		$paymentAmounts .= "					<p>$ ".number_format($payment['amount'], 2, '.', ',')." by / par ".$payment['type']." on / à la  ".$payment['date']."</p>\n";
	} //end of foreach
	$paymentAmounts .= "				</div>\n";
} //end of if
// Dec 8/16 - This is redundant information for the invoice. Barry Watt
//if (isset($invoiceInfo['moneris_ref']) && $invoiceInfo['moneris_ref'] != "") {
//	$populatedComments .= "				<p>Payment ID / ID du paiement: ".$invoiceInfo['moneris_ref']."</p>\n";
//} //end of if
// This is from the refunds table.
$refundsElement = "";
if ((isset($refunds)) && (!empty($refunds))) {
	$refundsElement = "				<div>\n";
	foreach($refunds as $ref) {
		$refAmount = floatval($ref['refund_amount']) + floatval($ref['refund_taxes']);
		$refDate = $ref['refund_date'];
		$refConf = $ref['confirmation'];
		$refundsElement .= "					<p>Refund of / Remboursement de $ ".number_format($refAmount, 2, '.', ',')." applied on / effectué le ".$refDate." | Confirmation No. / N° de Confirmation: ".$refConf."</p>\n";
	} //end of foreach
	$refundsElement .= "				</div>\n";
} //end of if
?>
<?php
if($populatedComments != "") {
	echo $populatedComments;
} //end of if
if($paymentAmounts != "") {
	echo $paymentAmounts;
} //end of if
if($refundsElement != "") {
	echo $refundsElement;
} //end of if
/*
if($invoiceInfo['pd_comments'] != "") {
	$pdComments = "<p>".$invoiceInfo['pd_comments']."</p>";
	$pdComments1 = str_replace("<p><p><p>", "<p>", $pdComments);
	$pdComments2 = str_replace("<p><p>", "<p>", $pdComments1);
	$pdComments3 = str_replace("</p></p></p>", "</p>", $pdComments2);
	$pdComments4 = str_replace("</p></p>", "</p>", $pdComments3);
	echo "				".$pdComments4."\n";
} //end of if*/
?>
<?php endif; ?>		
			</div><!--/paymentDetails -->
		</div><!--/paymentBox -->
		<div id="cancellationBox">
			<div class="cancellationHeading">Cancellation Policy / Politique d'annulation</div>
			<div class="cancellationDetails">
<?php if($eventInfo['cancelation'] != ""): ?>
<?php
	//A little code conversion because the fonts used do not have a Bold font weight, they have a separate font designation.
	$canPol = html_entity_decode($eventInfo['cancelation']);
	$canPol1 = str_replace("<strong>", "<span class=\"b\">", $canPol);
	$canPol2 = str_replace("</strong>", "</span>", $canPol1);
	echo $canPol2."\n";
?>
<?php else: ?>
				<p>&bull; All cancellations must be received in writing before event. / Toutes les annulations doivent être reçues par écrit avant l'événement.</p>
				<p>&bull; More than 10 business days, full refund or credit note. / Plus de 10 jours ouvrables, remboursement intégral ou note de crédit.</p>
				<p>&bull; 6 - 10 business days, 10% service charge. / 6 - 10 jours ouvrables, frais de service de 10%.</p>
				<p>&bull; 5 business days or less, no refund or credit note. / 5 jours ouvrables ou moins, aucun remboursement ou note de crédit.</p>
<?php endif; ?>
			</div><!--/cancellationDetails -->
		</div><!--/cancellationBox -->
	</div><!--/paymentCancellation -->
	<div class="clearFix"></div>
</div><!--/invoice -->
<?php endif; ?>
</body>
</html>
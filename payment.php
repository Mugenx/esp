<link href="<?php echo THESITE; ?>/css/formfields.css" rel="stylesheet">
	<?php if(isset($success)): ?>
		<div class="successMsg"><p>Transaction Success - Thank you for your payment.</p></div>
	<?php elseif(isset($failure)): ?>
		<div class="errorMsg"><p>Transaction Failed: <?php echo $msg; ?></p></div>
<div class="error">To try again, press the back button and you will get back to the payment form</div>
		
		<form method="post">
<input type="hidden" name="invoice_id" value="<?php echo $invID; ?>">
<input type="hidden" name="reg_id" value="<?php echo $regID; ?>">
<button class="backBtn" type="submit">Back</button>
</form>
	<?php elseif(!empty($errors)): ?>
		<?php
		foreach($errors as $error){
			echo "<div class='error'> $error </div>";
		}
		?>
	<?php else: ?>
	<?php if ($regInfo['paid'] == '1') { ?>
	<p>The invoice has been paid. Thank You.</p>
	<?php } else { ?>
<form id="registration-form" method="post" onload="document.getElementById('cvd').value=''">
	<h1>Payment Form: <?php echo $regInfo['confcode'];?></h1>


	<p>Please fill in the following form to apply a payment by credit card to the Invoice #<?php echo $regInfo['confcode']; ?>.</p>
	
	<fieldset style="width:100%">
		<legend>Invoice Details</legend>
		<table width="95%" border="0" cellspacing="0" cellpadding="2">
			<tr >
				<td align="left" width="80%" style="border-bottom: 1px solid #000"><strong>Registration Option</strong></td>
				<td align="left" width="20%" style="border-bottom: 1px solid #000"><strong>Cost</strong></td>
			</tr>
			<?php
					$leaderStr = $regInfo['first_name'] . " " . $regInfo['last_name'];
					$selection = "(" . $regselect['range'] . ")";
					
				?>
				<tr>
					<td align="left"><?php echo $leaderStr.  " :  " . $regselect['name'] .  "<strong> $selection </strong>";?></td>
					<td align="left"><?php echo "$" . $regselect['price'];?></td>
				</tr>
				<?php
					if(!empty($regEO)){
						foreach($regEO as $eo){
							echo "<tr>
								<td align='left'> $leaderStr : " . $eo['name'] . "<strong>" .  $eo['range'] . "</strong></td>
								<td align='left'> $". $eo['price'] . "</td>
							</tr>";
						}
					}
				?>
				<?php
				if($regInfo['promo_code_used'] != ""){
					$promoUsed = strtoupper($regInfo['promo_code_used']);
					echo "<tr><td align='left'>$leaderStr : Promocode [$promoUsed] </td>";
					echo "<td align='left' style='color:red;'> - $$promoDiscount </td></tr>";
				}
				?>
				
			<?php if(!empty($delegates)){
			
				foreach($delegates as $delegate){
						$delStr = $delegate['name'];
						echo "<tr>";
						echo "<td align='left'>" . $delStr . " : " . $delegate['selection'] . "<strong> (" . $delegate['selectionRange'] . ") </strong></td>";
						echo "<td align='left'> $" . $delegate['price']. "</td>";
						echo "</tr>";
						if(!empty($delegate['discount'])){
							$promoUsed = strtoupper($delegate['discount']['promo']);
							$promoPrice = $delegate['discount']['amount'];
								
							echo "<tr><td align='left'>" . $delStr . " : Promocode [$promoUsed] </td>";
							echo "<td align='left' style='color:red;'>- $$promoPrice</span></td></tr>";
						}
				}
				/*
				$Costs = explode("##", $invoiceInfo['extra_costs']); 
				foreach($Costs as $cost){
					$c = explode("||", $cost);
					$costName = $c[0];
					$costPrice = (isset($c[1]) && $c[1] != "") ? $c[1] : "";
					//$costPrice = 0.00;
					
					echo "<tr>
						<td align='left'>$costName</td>";
					if($costPrice != ""){
						if($costPrice < 0){
							$price = trim($costPrice, "-");
							echo"<td align='left' style='color:red;'>-&#36;$price </td>";
						}else{
							echo"<td align='left'>&#36;$costPrice</td>";
						}
					}
					echo "</tr>";
				}
				*/
			} ?>
			<tr style='height:30px'>

			</tr>
			<tr style='height:25px'>
				<td align="left" width="85%"><strong>Discount </strong></td>
				<td align="left" width="15%"><strong> <?php echo "$".$invoiceInfo['discount']; ?></strong></td>
			</tr>
			<tr style='height:25px'>
				<td align="left" width="85%"><strong>Sub-Total </strong></td>
				<td align="left" width="15%"><strong> <?php echo "$".$invoiceInfo['invoice_cost']; ?></strong></td>
			</tr>
			<?php 
				$taxAmount = "$" . $invoiceInfo['invoice_tax_cost'];
				if($regInfo['tax_exempt'] == 1){
					$taxAmount = "Exempt";
				}
			?>
			<tr style='height:25px'>
				<td align="left" width="85%"><strong>Tax (<?php echo $invoiceInfo['invoice_tax_type'].": ".($invoiceInfo['invoice_tax_rate'] * 100)."%"; ?>) </strong></td>
				<td align="left" width="15%"><strong><?php echo $taxAmount; ?></strong></td>
			</tr>
			<?php if($regInfo['amount_paid'] > 0.00): ?>
			<tr style='height:25px'>
				<td align="left" width="85%"><strong>Previous Payments Received</strong></td>
				<td align="left" width="15%"><strong> <?php echo "$". $invoiceInfo['paid_amount']; ?></strong></td>
			</tr>
			<?php endif; ?>
			<tr style='height:25px'>
				<td align="left" width="85%"><strong>Total </strong></td>
				<td align="left" width="15%"><strong><?php echo "$". ($invoiceInfo['invoice_total_cost'] - $invoiceInfo['paid_amount']); ?></strong></td>
			</tr>
		</table>
	</fieldset>
	<fieldset id="personal" class="half_left">
		<legend>Billing To:</legend>
		<div>
			<label for="fm-forename" class="width100">First Name: </label>
			<input type="text" name="f_first_name" id="fm-forename" value="<?php echo $regInfo['first_name'];?>"/>
		</div>
		<div>
			<label for="fm-surname" class="width100">Last Name: </label>
			<input type="text" name="f_last_name" id="fm-surname" value="<?php echo $regInfo['last_name'];?>" />
		</div>
	
		<div>
			<label for="fm-telephone" class="width100">Telephone: </label>
			<input type="text" id="fm-telephone" name="f_telephone" value="<?php echo $regInfo['telephone'];?>" />
		</div>
		<div>
			<label for="fm-email" class="width100">Email: </label>
			<input type="text" id="fm-email" name="f_email" value="<?php echo $regInfo['email'];?>" />
		</div>		
	</fieldset>
	<fieldset id="address" class="half_right">
		<legend>Billing Address:</legend>
		<div>
			<label for="fm-addr" class="width100">Address: </label>
			<input type="text" id="fm-addr" name="f_address1" value="<?php echo $regInfo['address1'];?>" />
		</div>
		<div>
			<label for="fm-city" class="width100">Town or city: </label>
			<input type="text" id="fm-city" name="f_city" value="<?php echo $regInfo['city'];?>" />
		</div>			
		<div>
			<label for="fm-prov" class="width100">Province: </label>
			<input type="text" id="fm-prov" name="f_province" value="<?php echo $regInfo['province'];?>" />
		</div>
		<div>
			<label for="fm-postal" class="width100">Postal Code:  </label>
			<input type="text" id="fm-postal" name="f_postal" value="<?php echo $regInfo['postal'];?>" />
		</div>
	</fieldset>
	<div style="clear:both;"></div>	
	<fieldset style="width:100%">
		<legend>Credit Card Information:</legend>
		<div><div class="cclabel">Card Type:</div> <input type="radio" name="card_type" id="visa" value="Visa" style="width:15px"><label for="visa" style="display:inline;"><img src="https://www.verney.ca/images/visa.gif"></label>&nbsp;&nbsp;<input type="radio" name="card_type" id="mastercard" value="MC" style="width:15px;"><label for="mastercard" style="display:inline"><img src="https://www.verney.ca/images/mastercard.gif"></label>&nbsp;&nbsp;
		<input type="radio" name="card_type" id="amex" value="AMEX" style="width:15px;"><label for="amex" style="display:inline"><img src="https://www.verney.ca/images/amex.gif"></label></div> 
			
		
		<div><div class="cclabel">Card Number:</div> <input type="text" name="card_number" style="width:150px" maxlength="20" value=""></div>
		<div><div class="cclabel">Expiry Date (MM/YY):</div> <input type="text" name="exp_month" style="width:20px" maxlength="2" value=""> / <input type="text" name="exp_year" style="width:20px" maxlength="2" value=""></div>
		<div><div class="cclabel">CVD:</div> <input type="text" name="cvd" id="cvd" style="width:40px" maxlength="5" value=""></div>
	</fieldset>
	<input type="hidden" name="invoice_id" value="<?php echo $invoiceInfo['invoice_id']; ?>"><input type="hidden" name="reg_id" value="<?php echo $invoiceInfo['registrant_id']; ?>"><input type="hidden" name="client_id" value="VerneyTest">			
<p><input type="submit" name="submitbutton" id="submitbutton" value="Submit Payment" style="margin-top:5px; width:100%;" class="btn-primary btn"/> </p>
<p><strong>* Click the Submit button only Once! *<br>* Clicking on the button multiple times or refreshing the page may result in multiple transactions! *</strong></p>
<div style="margin-top:20px;text-align:center;height:70px;">
	<div style="float:left; width:50%;"><span id="siteseal"><script async type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=6yS7aOQC2jjyb8lQaseheKvSFO8UM2xSFKz9w7Wk8li52MA7Zr0dE5oLldF9"></script></span></div>
	<div style="float:left;  width:50%;"><table width="135" border="0" cellpadding="1" cellspacing="1" style="display:inline"><tr><td width="135" align="center"><script src="https://sealserver.trustkeeper.net/compliance/seal_js.php?code=w6otlmxxrpqOQRKHKImBsdOFgYY9qj&style=invert&size=105x54&language=en"></script><noscript><a href="https://sealserver.trustkeeper.net/compliance/cert.php?code=w6otlmxxrpqOQRKHKImBsdOFgYY9qj&style=invert&size=105x54&language=en" target="hATW"><img src="https://sealserver.trustkeeper.net/compliance/seal.php?code=w6otlmxxrpqOQRKHKImBsdOFgYY9qj&style=invert&size=105x54&language=en" border="0" alt="Trusted Commerce"/></a></noscript></td></tr></table></div>

</div>
</form>

<?php } ?>
<?php endif; ?>
<script>
$("#registration-form").validate();
</script>
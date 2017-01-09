<?php
// FileName:     invitational.php
// Author:       EventSystemPro
// Copyright:    © EVENTSYSTEMPRO 2016. ALL RIGHTS RESERVED.
// Web Version:  3.0000
// Date:         12/9/2016
?>
<?php
if ($lang == "en") {
	setlocale(LC_NUMERIC, 'C');
	setlocale(LC_ALL, 'en_EN');
	} else {
	setlocale(LC_NUMERIC, 'C');
	setlocale(LC_ALL, 'fr_FR');
echo "		<script>\n"
		."			$.extend( $.validator.messages, {\n"
		."					required: \"Ce champ est obligatoire.\",\n"
		."					remote: \"Veuillez corriger ce champ.\"\n"
		."			});\n"
		."		</script>";
} //end of if
?>
<?php if(isset($errorBrowser)): ?>
		<div class='errorBrowser'>
<?php 
	echo TextSelector("			Outdated browser detected: To use this registration form, please upgrade your browser to Internet Explorer 11 or higher, alternatively you can also use Chrome or Firefox.\n", "			Navigateur web pas à jour! S'il vous plaît mettre à jour votre navigateur - Internet Explorer 11 ou plus, ou alternativement Chrome ou Firefox.\n");
?>
		</div>
<?php elseif(isset($error)): ?>
<?php 
	echo "		<div class=\"error\">".$error."</div>\n";
?>
<?php else: ?>
	<h1><?php echo TextSelector("Request for registration for ".$title, "Demande d'inscription pour ".$title); ?></h1>
	<div>
<?php if ($eventDetails['is_soldout'] == 0): ?>
<?php if ($eventDetails['inv_preamble'] != ""): ?>
		<div class="bg-info" style="padding: 10px; border-radius: 10px;">
			<?php echo TextSelector(htmlspecialchars_decode($eventDetails['inv_preamble']), htmlspecialchars_decode($eventDetails['inv_preamble_fr'])); ?>
		</div>
<?php endif; //end of if ($eventDetails['inv_preamble'] != "") ?>
		<p class="bg-danger" style="padding: 10px; border-radius: 10px;"><?php echo TextSelector("Required fields are marked <i class='glyphicon glyphicon-exclamation-sign'></i>", "Les champs obligatoires sont indiqu&eacute;s <i class='glyphicon glyphicon-exclamation-sign'></i>");?></p>
	</div>
	<div id="invitational-form">
		<form method="post" id="reg" class="reg">
			<input type="hidden" id="dir" name="event_dir" value="<?php echo $eventDetails['directory_name']; ?>" />
			<input type="hidden" name="srce" value="registration" />
			<input type="hidden" name="lang" value="<?php echo $lang; ?>" />
			<input type="hidden" name="invited" value="1" />
			<input type="hidden" name="event_id" value="<?php echo $eventID; ?>" />
<?php
// BEGINNING OF MAIN INVITATIONAL FORMBLOCK

// Variables for use.
$countries = "Canada;United States;---------------;Afghanistan;Albania;Algeria;Andorra;Angola;Antigua & Deps;Argentina;Armenia;Australia;Austria;Azerbaijan;Bahamas;Bahrain;Bangladesh;Barbados;Belarus;Belgium;Belize;Benin;Bhutan;Bolivia;Bosnia Herzegovina;Botswana;Brazil;Brunei;Bulgaria;Burkina;Burundi;Cambodia;Cameroon;Cape Verde;Central African Rep;Chad;Chile;China;Colombia;Comoros;Congo;Congo {Democratic Rep};Costa Rica;Croatia;Cuba;Cyprus;Czech Republic;Denmark;Djibouti;Dominica;Dominican Republic;East Timor;Ecuador;Egypt;El Salvador;Equatorial Guinea;Eritrea;Estonia;Ethiopia;Fiji;Finland;France;Gabon;Gambia;Georgia;Germany;Ghana;Greece;Grenada;Guatemala;Guinea;Guinea-Bissau;Guyana;Haiti;Honduras;Hungary;Iceland;India;Indonesia;Iran;Iraq;Ireland {Republic};Israel;Italy;Ivory Coast;Jamaica;Japan;Jordan;Kazakhstan;Kenya;Kiribati;Korea North;Korea South;Kosovo;Kuwait;Kyrgyzstan;Laos;Latvia;Lebanon;Lesotho;Liberia;Libya;Liechtenstein;Lithuania;Luxembourg;Macedonia;Madagascar;Malawi;Malaysia;Maldives;Mali;Malta;Marshall Islands;Mauritania;Mauritius;Mexico;Micronesia;Moldova;Monaco;Mongolia;Montenegro;Morocco;Mozambique;Myanmar, {Burma};Namibia;Nauru;Nepal;Netherlands;New Zealand;Nicaragua;Niger;Nigeria;Norway;Oman;Pakistan;Palau;Panama;Papua New Guinea;Paraguay;Peru;Philippines;Poland;Portugal;Qatar;Romania;Russian Federation;Rwanda;St Kitts & Nevis;St Lucia;Saint Vincent & the Grenadines;Samoa;San Marino;Sao Tome & Principe;Saudi Arabia;Senegal;Serbia;Seychelles;Sierra Leone;Singapore;Slovakia;Slovenia;Solomon Islands;Somalia;South Africa;South Sudan;Spain;Sri Lanka;Sudan;Suriname;Swaziland;Sweden;Switzerland;Syria;Taiwan;Tajikistan;Tanzania;Thailand;Togo;Tonga;Trinidad & Tobago;Tunisia;Turkey;Turkmenistan;Tuvalu;Uganda;Ukraine;United Arab Emirates;United Kingdom;Uruguay;Uzbekistan;Vanuatu;Vatican City;Venezuela;Vietnam;Yemen;Zambia;Zimbabwe";
$countriesArr = explode(";", $countries);
$usStates = "AL;AK;AZ;AR;CA;CO;CT;DE;FL;GA;HI;ID;IL;IN;IA;KS;KY;LA;ME;MD;MA;MI;MN;MS;MO;MT;NE;NV;NH;NJ;NM;NY;NC;ND;OH;OK;OR;PA;RI;SC;SD;TN;TX;UT;VT;VA;WA;WV;WI;WY;GU;PR;VI";
$usStatesArr = explode(";", $usStates);
$provinces = "AB;BC;MB;NB;NL;NT;NS;NU;ON;PE;QC;SK;YT";
$provincesArr = explode(";", $provinces);

for ($I = 0; $I < sizeof($categories); $I++) {
	if ($categories[$I]['cat_name'] == "personal") {
		$personalCat = $categories[$I]['cat_text'];
		$personalCatFr = htmlspecialchars_decode($categories[$I]['cat_text_fr'], ENT_QUOTES);
		} elseif ($categories[$I]['cat_name'] == "address") {
		$addressCat = $categories[$I]['cat_text'];
		$addressCatFr = htmlspecialchars_decode($categories[$I]['cat_text_fr'], ENT_QUOTES);
		} elseif ($categories[$I]['cat_name'] == "contact") {
		$contactCat = $categories[$I]['cat_text'];
		$contactCatFr = htmlspecialchars_decode($categories[$I]['cat_text_fr'], ENT_QUOTES);
		} elseif ($categories[$I]['cat_name'] == "special") {
		$specialCat = $categories[$I]['cat_text'];
		$specialCatFr = htmlspecialchars_decode($categories[$I]['cat_text_fr'], ENT_QUOTES);
		} elseif ($categories[$I]['cat_name'] == "casl") {
		$caslCat = $categories[$I]['cat_text'];
		$caslCatFr = htmlspecialchars_decode($categories[$I]['cat_text_fr'], ENT_QUOTES);
		} elseif ($categories[$I]['cat_name'] == "extra") {
		$extraCat = $categories[$I]['cat_text'];
		$extraCatFr = htmlspecialchars_decode($categories[$I]['cat_text_fr'], ENT_QUOTES);
	} //end of if
} //end of for

// The function to create the main section.
function CreateSection($section, $questions, $reg_answers, $extra_answers, $sectors, $countriesArr, $usStatesArr, $provincesArr, $catName, $catNameFr) {

	//Create the section title variable and check for the section type.
	$catTitle = TextSelector($catName, $catNameFr);
	if ($section == "personal") {
		$openDiv = "				<div class=\"col-md-6\">\n";
		$closeDiv = "				</div>\n";
		} elseif ($section == "address") {
		$openDiv = "				<div class=\"col-md-6\">\n";
		$closeDiv = "				</div>\n";
		} elseif ($section == "contact") {
		$openDiv = "				<div class=\"col-md-6\">\n";
		$closeDiv = "				</div>\n";
		} elseif($section == "special") {
		$openDiv = "				<div class=\"col-md-6\">\n";
		$closeDiv = "				</div>\n";
		} elseif($section == "casl") {
		$openDiv = "";
		$closeDiv = "";
		} elseif($section == "extra") {
		$openDiv = "";
		$closeDiv = "";
	} //end of if

	//Open the section's div.
	echo $openDiv;

	//Output the section title.
	echo "					<h2>".$catTitle."</h2>\n";

	//Iterate through the data and output accodingly.	
	foreach ($questions as $q) {

		//Variable required throughout this function.
		$reqIcon = "";
		$requiredStr = "";
		$v = "";

		//Check if this is an extra question.
		if ($section == "extra") {
			$defaultName = "extra_".$q['id'];
			} else {
			$defaultName = "reg_".$q['id'];
		} //end of if

		//Check if this is a required field.
		if ($q['is_required'] == 1) {
			$reqIcon = "&nbsp;<span class=\"glyphicon glyphicon-exclamation-sign\"></span>";
			$requiredStr = " required";
		} //end of if

		//Every field has a label.
		echo "					<div class=\"question\">\n"
				."						<label>".TextSelector($q['title'], html_entity_decode($q['title_fr'], ENT_QUOTES))."</label>".$reqIcon."<br>\n";

		//Check if this is an extra question.
		if ($section == "extra") {
			//Check if the $extra_answers array is not null.
			if ($extra_answers != null) {
				//Iterate through the answers array until we get to the current field id, and then populate the value.
				foreach ($extra_answers as $a) {
					if ($a['question_id'] == $q['id']) {
						$v = html_entity_decode($a['answer'], ENT_QUOTES);
						break;
					} //end of if
				} //end of foreach
			} //end of if
			} else {
			//Check if the $reg_answers array is not null.
			if ($reg_answers != null) {
				$v = html_entity_decode($reg_answers[$q['code']], ENT_QUOTES);
			} //end of if
		} //end of if

		if (TextSelector($q['extra_text'], $q['extra_text_fr']) != "") {
			echo "						<div class=\"extraText\">".TextSelector($q['extra_text'], $q['extra_text_fr'])."</div>\n";
		} //end of if
		
		//Check if this is a textbox field.
		if ($q['question_type'] == "textbox") {
			echo "						<input type=\"text\" id=\"".$q['code']."\" class=\"form-control formInput\" name=\"".$defaultName."\"".$requiredStr." value=\"".$v."\" />\n";
		} //end of if

		//Check if this is the country field.
		if ($q['question_type'] == "country") {
			$CYS = "						<select class=\"form-control formInput\" name=\"".$defaultName."\"".$requiredStr." id=\"countryQ\">";
			$CYS .= "<option value=\"\">".TextSelector("Please select make a selection", "Veuillez faire une sélection")."</option>";
			//Iterate through the countries to populate the options.
			foreach ($countriesArr as $country) {
				$country = trim($country);
				$sel = "";
				if ($v == $country) {
					$sel = " selected";
				} //end of if
				//Added a separator so that the preferred countries would be at the top.
				if ($country == "---------------") {
					$CYS .= "<option disabled value=\"".$country."\">".$country."</option>";
					} else {
					$CYS .= "<option value=\"".$country."\"".$sel.">".$country."</option>";
				} //end of if
			}
			$CYS .= "<option value=\"other\">".TextSelector("Other", "Autre")."</option>";
			$CYS .= "</select>\n";
			echo $CYS;
		} //end of if

		//Check if this is the Province and State field.
		if ($q['question_type'] == "province") {
			$PRST = "						<select class=\"form-control formInput\" name=\"".$defaultName."\"".$requiredStr." id=\"provinceQ\">"
						."<option value=\"\">".TextSelector("Please select make a selection", "Veuillez faire une sélection")."</option>";
			//Check if this is the CA.
			if ($q['ca'] == 1) {
				$PRST .= "<option disabled class=\"PROV\"> Provinces </option>";
				//Iterate through the Canadian provinces.
				foreach ($provincesArr as $prov) {
					$prov = trim($prov, " ");
					$sel = "";
					if ($v == $prov) {
						$sel = " selected";
					} //end of if
					$PRST .= "<option value=\"".$prov."\" class=\"PROV\"".$sel.">".$prov."</option>";
				} //end of foreach
			} //end of if
			if ($q['us'] == 1) {
				$PRST .= "<option disabled class=\"STATE\"> States </option>";
				//Iterate through the US states.
				foreach ($usStatesArr as $state) {
					$state = trim($state, " ");
					$sel = "";
					if ($v == $state) {
						$sel = " selected";
					} //end of if
					$PRST .= "<option value=\"".$state."\" class=\"STATE\"".$sel.">".$state."</option>";
				} //end of foreach
			} //end of if
			$PRST .= "<option value=\"other\">".TextSelector("Other", "Autre")."</option></select>\n";
			echo $PRST;
		} //end of if

		//Check if this is a textarea field.
		if ($q['question_type'] == "textarea") {
			//If $q['word_limit'] != 0
			$limitClass = "";
			if ($q['word_limit'] > 0) {
				$limitClass= " limitedArea";
				echo "						<span>Word count:</span><span id=\"count_".$q['id']."\">0</span>\n";
			}
			echo "						<textarea  id=\"".$q['code']."\" class=\"form-control formInput".$limitClass."\" name=\"".$defaultName."\"".$requiredStr." limit=\"".$q['word_limit']."\">".$v."</textarea>\n";
		} //end of if

		//Check if this is an emcheck field.
		if ($q['question_type'] == "emcheck") {
			//There is only one option - this is for the CASL Email question. Trim just in case...
			$options = rtrim($q['options'], "||");
			$options_fr = rtrim($q['options_fr'], "||");
			//Output the option.
			echo "						<input type=\"checkbox\" class=\"formInput\" name=\"casl\" id=\"casl\" value=\"".TextSelector($options, html_entity_decode($options_fr, ENT_QUOTES))."\"".$requiredStr." /> <label for=\"casl\">".TextSelector($options, html_entity_decode($options_fr, ENT_QUOTES))."</label><br>\n";
		} //end of if

		//Check if this is a checkbox field.
		if ($q['question_type'] == "checkbox") {
			//Explode the options into arrays.
			$options = explode("||", $q['options']);
			$options_fr = explode("||", $q['options_fr']);
			//Set $answerArr to a null value, and if there is a value in $v, and when exploded into array values, 
			//there is more than 1 array item, then populate $answerArr with it.
			$answerArr = null;
			if (count(explode("||", $v)) > 1) {
				$answerArr = explode("||", $v);
			} //end of if
			//Set $NI to 1.
			$NI = 1;
			//Iterate through the options, checking for the values that match as we go.
			foreach ($options as $k=>$o) {
				$isCheck = "";
				if ($answerArr != null) {
					foreach ($answerArr as $a) {
						if ($a == $o || $a == $options_fr[$k]) {
							$isCheck =  "checked";
							break;
						} //end of if
					} //end of foreach
					} else {
					if ($v == $o || $v == $options_fr[$k]) {
						$isCheck = " checked";
					} //end of if
				} //end of if
				//Output the option.
				echo "						<input type=\"checkbox\" class=\"formInput\" name=\"".$defaultName."[]\" id=\"".$q['code'].$NI."\" value=\"".TextSelector($options[$k], $options_fr[$k])."\"".$requiredStr.$isCheck." /> <label for=\"".$q['code'].$NI."\">".TextSelector($options[$k], html_entity_decode($options_fr[$k]), ENT_QUOTES)."</label><br>\n";
				//Increment $NI by 1.
				$NI += 1;
			} //end of foreach
		} //end of if

		//Check if this is a radio field.
		if($q['question_type'] == "radio"){
			//Explode the options into arrays.
			$options = explode("||", $q['options']);
			$options_fr = explode("||", $q['options_fr']);
			//Set $answerArr to a null value, and if there is a value in $v, and when exploded into array values, 
			//there is more than 1 array item, then populate $answerArr with it.
			$answerArr = null;
			if(count(explode("||", $v)) > 1){
				$answerArr = explode("||", $v);
			} //end of if
			//Set $NI to 1.
			$NI = 1;
			//Iterate through the options, checking for the values that match as we go.
			foreach ($options as $k=>$o) {
				$isCheck = "";
				if ($answerArr != null) {
					foreach ($answerArr as $a) {
						if ($a == $o || $a == $options_fr[$k]) {
							$isCheck =  "checked";
							break;
						} //end of if
					} //end of foreach
					} else {
					if ($v == $o || $v == $options_fr[$k]) {
						$isCheck = " checked";
					} //end of if
				} //end of if
				//Output the option.
				echo "						<input type=\"radio\" class=\"formInput\" name=\"".$defaultName."[]\" id=\"".$q['code'].$NI."\" value=\"".TextSelector($options[$k], $options_fr[$k])."\"".$requiredStr.$isCheck." /> <label for=\"".$q['code'].$NI."\">".TextSelector($options[$k], html_entity_decode($options_fr[$k]), ENT_QUOTES)."</label><br>\n";
				//Increment $NI by 1.
				$NI += 1;
			} //end of foreach
		} //end of if

		//Check if this is a select field.
		if($q['question_type'] == "select"){
			//Explode the options into arrays.
			$options = explode("||", $q['options']);
			$options_fr = explode("||", $q['options_fr']);
			//Set $answerArr to a null value, and if there is a value in $v, and when exploded into array values, 
			//there is more than 1 array item, then populate $answerArr with it.
			$answerArr = null;
			if(count(explode("||", $v)) > 1){
				$answerArr = explode("||", $v);
			} //end of if
			//Start populating the variable.
			$SLCT = "						<select name=\"".$defaultName."\" class=\"form-control formInput\" id=\"".$q['code']."\"".$requiredStr.">";
			$SLCT .= "<option value=\"\">".TextSelector("Please select make a selection", "Veuillez faire une sélection")."</option>";
			//Iterate through the drop-down's options.
			foreach ($options as $k=>$o) {
				$isCheck = "";
				if ($answerArr != null) {
					foreach ($answerArr as $a) {
						if ($a == $o  || $a == $options_fr[$k]) {
							$isCheck = " selected";
							break;
						} //end of if
					} //end of foreach
					} else {
					if ($v == $o || $v == $options_fr[$k]) {
						$isCheck = " selected";
					} //end of if
				} //end of if
				$SLCT .= "<option value=\"".TextSelector($options[$k], $options_fr[$k])."\"".$isCheck.">".TextSelector($options[$k], $options_fr[$k])."</option>";
			} //end of foreach
			$SLCT .= "</select>\n";
			//Output the select.
			echo $SLCT;
		} //end of if

		//Check if this is an images.
		if($q['question_type'] == "image") {
			echo "						<input type=\"file\" class=\"form-control formInput\" name=\"". $defaultName."\" value=\"".$v."\"><br>\n";
			if($v != "") {
				echo "						<input type=\"hidden\" name=\"". $defaultName."\" value=\"".$v."\"><br>\n";
				echo "						<img src=\"".$v."\" class=\"spkrImg\">\n";
			} //end of if
		} //end of if

		//Check if this is the sector field, and if so, if $sectors isset.
		if ($q['question_type'] == "sector") {
			if (isset($sectors)) {
				$SECTR = "						<select name=\"".$defaultName."\" class=\"form-control formInput\" id=\"".$q['code']."\"".$requiredStr.">";
				$SECTR .= "<option value=\"\">".TextSelector("Please select make a selection", "Veuillez faire une sélection")."</option>";
				//Iterate through the sectors to populate the options.
				foreach ($sectors as $sector) {
					$sID = $sector['id'];
					$sName = $sector['sector_name'];
					$sNameFR = $sector['sector_name_fr'];
					$sTitle = htmlspecialchars_decode(TextSelector($sName, $sNameFR), ENT_QUOTES);
					$selected = "";
					if($v == $sID){
						$selected = " selected";
					} //end of if
					$SECTR .= "<option value=\"".$sID."\"".$selected.">".$sTitle."</option>";
				} //end of foreach
				$SECTR .= "</select>\n";
				echo $SECTR;
			} //end of if
		} //end of if

		//The item was a label only which has already been output at the top of this foreach statement.
		if($q['question_type'] == "label") {
			//No input to add, just output a <br>.
			echo "						<br>\n";
		} //end of if

		//echo "<br>";	
		echo "						<br>\n";	
		echo "					</div>\n";	

	} //end of foreach

	//Close the section's div.
	echo $closeDiv;

} //end of function CreateSection($section, $questions, $answers, $sectors)

if (!isset($reg_answers)) {
	$reg_answers = array();
} //end of if
if (!isset($extra_answers)) {
	$extra_answers = array();
} //end of if

if (((isset($personalQuestions)) && (!empty($personalQuestions))) || ((isset($addressQuestions)) && (!empty($addressQuestions)))) {
	echo "			<div class=\"col-md-12 formBlock\">\n";
	if (isset($personalQuestions) && !empty($personalQuestions)) {
		$catName = $personalCat;
		$catNameFr = $personalCatFr;
		CreateSection("personal", $personalQuestions, $reg_answers, $extra_answers, $sectors, $countriesArr, $usStatesArr, $provincesArr, $catName, $catNameFr);
	} //end of if
	if (isset($addressQuestions) && !empty($addressQuestions)) {
		$catName = $addressCat;
		$catNameFr = $addressCatFr;
		CreateSection("address", $addressQuestions, $reg_answers, $extra_answers, $sectors, $countriesArr, $usStatesArr, $provincesArr, $catName, $catNameFr);
	} //end of if
	//close the formblock div.
	echo "			</div>\n";
} //end of if

if (((isset($contactQuestions)) && (!empty($contactQuestions))) || ((isset($specialQuestions)) && (!empty($specialQuestions)))) {
	echo "			<div class=\"col-md-12 formBlock\">\n";
	if (isset($contactQuestions) && !empty($contactQuestions)) {
		$catName = $contactCat;
		$catNameFr = $contactCatFr;
		CreateSection("contact", $contactQuestions, $reg_answers, $extra_answers, $sectors, $countriesArr, $usStatesArr, $provincesArr, $catName, $catNameFr);
	} //end of if
	if (isset($specialQuestions) && !empty($specialQuestions)) {
		$catName = $specialCat;
		$catNameFr = $specialCatFr;
		CreateSection("special", $specialQuestions, $reg_answers, $extra_answers, $sectors, $countriesArr, $usStatesArr, $provincesArr, $catName, $catNameFr);
	} //end of if
	//close the formblock div.
	echo "			</div>\n";
} //end of if

if ((isset($caslQuestions)) && (!empty($caslQuestions))) {
	echo "			<div class=\"col-md-12 formBlock\">\n";
		$catName = $caslCat;
		$catNameFr = $caslCatFr;
		CreateSection("casl", $caslQuestions, $reg_answers, $extra_answers, $sectors, $countriesArr, $usStatesArr, $provincesArr, $catName, $catNameFr);
	//Close the formblok div.
	echo "			</div>\n";
} //end of if

if ((isset($extraQuestions)) && (!empty($extraQuestions))) {
	echo "			<div class=\"col-md-12 formBlock\">\n";
		$catName = $extraCat;
		$catNameFr = $extraCatFr;
		CreateSection("extra", $extraQuestions, $reg_answers, $extra_answers, $sectors, $countriesArr, $usStatesArr, $provincesArr, $catName, $catNameFr);
	//Close the formblok div.
	echo "			</div>\n";
} //end of if

// END OF MAIN INVITATIONAL FORMBLOCK
?>
			<div class="col-md-12 formBlock">
				<h2><?php echo TextSelector("Terms and Conditions", "Termes et conditions"); ?></h2>
<?php
for ($i=0; $i < count($eventTerms); $i++) { 
	echo "				<h3>".TextSelector($eventTerms[$i]['title'], $eventTerms[$i]['title_fr'])."</h3>\n"
			."				".TextSelector(html_entity_decode($eventTerms[$i]['content'], ENT_QUOTES), html_entity_decode($eventTerms[$i]['content_fr'], ENT_QUOTES))."\n";
	if ($eventTerms[$i]['term_type'] == "radio") {
		$theOptions = html_entity_decode(TextSelector($eventTerms[$i]['options'], $eventTerms[$i]['options_fr']), ENT_QUOTES, 'UTF-8');
		$multiOptions = explode("||", $theOptions);
		foreach ($multiOptions as $option) {
			echo "				<input type=\"radio\" class=\"terms_radio\" name=\"term_".$eventTerms[$i]['term_id']."\" id=\"term_".$eventTerms[$i]['term_id']."\" value=\"".$option."\" required /> <label for=\"term_".$eventTerms[$i]['term_id']."\">".$option."</label><br>\n";
		} //end of foreach
		} else {
		echo "				<input type=\"checkbox\" class=\"terms\" name=\"term_".$eventTerms[$i]['term_id']."\" id=\"term_".$eventTerms[$i]['term_id']."\" value=\"".TextSelector("I accept ".$eventTerms[$i]['title'], "J'accepte la ".html_entity_decode($eventTerms[$i]['title_fr'], ENT_QUOTES))."\" required /> <label for=\"term_".$eventTerms[$i]['term_id']."\">".TextSelector("I accept ".$eventTerms[$i]['title'], "J'accepte la ".html_entity_decode($eventTerms[$i]['title_fr'], ENT_QUOTES))."</label>\n";
	} //end of if
} //end of for
?>
			</div>
			<div class="col-md-12 formBlock">
				<br><p><strong><?php echo TextSelector("Please note: ", "Veuillez noter: "); ?></strong><?php echo TextSelector("In order to complete your registration you must prove you are not a robot maliciously auto filling forms by checking the \"I'm not a Robot\" box.", "Afin de compléter votre inscription, vous devez prouver que vous n'êtes pas un robot en cochant la \"Je ne suis pas un robot\"."); ?></p><br>
				<div class="g-recaptcha" id="recaptcha" data-type="image" data-sitekey="<?php echo SITKEY; ?>"></div>
			</div>
			<div>
				<button type="submit" class="btn btn-primary" name="saveInv" id="saveInv" align="right"><?php echo TextSelector("Save and Continue", "Soumettre et continuer"); ?></button>
			</div>
		</form>
	</div><!--/invitational-form -->
	<script>
		if($("#countryQ").length){
			if($("#provinceQ").length){
				//Check country val and load provinces
				$(".STATE").hide();
				$(".PROV").hide();
				if($("#countryQ").val() == "Canada"){
					$(".PROV").show();
				}
				if($("#countryQ").val() == "United States"){
					$(".STATE").show();
				}
			}
		}
		$("#countryQ").change(function(){
			var cVal = $(this).val();
			$(".STATE").hide();
			$(".PROV").hide();
			if(cVal == "Canada"){
				$(".PROV").show();
			}
			if(cVal == "United States"){
				$(".STATE").show();
			}
		});
	</script>
<?php else: ?>
		<div class="soldout">
			<p><?php echo TextSelector($eventDetails['sold_out_msg'], $eventDetails['sold_out_msg_fr']); ?></p>
		</div>
	</div>
<?php endif; ?>
<?php endif; ?>

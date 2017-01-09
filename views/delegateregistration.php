<?php
// FileName:     delegateregistration.php
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
<?php 
	//Populate variables and arrays.
	$titleSplit = explode(" ", $eventDetails['etitle']);
	$dateStart = explode("-", $eventDetails['start_date']);
	$dateEnd = explode("-", $eventDetails['end_date']);
	$dateString = "";

	//Date calculations.
	if($dateStart[1] == $dateEnd[1]) {
		$dateObj   = DateTime::createFromFormat('!m', $dateEnd[1]);
		$monthName = $dateObj->format('F'); 
		$dateString = $monthName . " " . ltrim($dateStart[2], '0') . "th - " . ltrim($dateEnd[2], '0') . "th, " . $dateEnd[0] ;
		} else {
		$startMonthName = DateTime::createFromFormat('!m', $dateStart[1])->format('F');
		$endMonthName = DateTime::createFromFormat('!m', $dateEnd[1])->format('F');
		$dateString = $startMonthName . " " . $dateStart[2] . " - " . $endMonthName . " " . $dateEnd[2] . ", " . $dateEnd[0] ;
	} //end of if
	$locationString = $eventDetails['location'];
	$infoString = $dateString . " | " . $locationString;
	$description = $eventDetails['edescription'];

	//Display Today's date
	$currentTime = date('F j, Y', time());

	//Evaluate super early and early birds.
	$earlyDate=date('F j, Y', strtotime($eventDetails['early_date']));
	$superEarlyDate=date('F j, Y', strtotime($eventDetails['super_early_date']));
	$diffEarly = strtotime($earlyDate) - time();
	$diffSuperEarly = strtotime($superEarlyDate) - time();
	$isSuperSaver = false;
	$isEarlyBird = false;

	//Define Early Bird and Super Saver as true or false for later use.
	if ($diffSuperEarly > 0) {
		$isSuperSaver = true;
		$isEarlyBird = false;
		} elseif ($diffEarly > 0) {
		$isSuperSaver = false;
		$isEarlyBird = true;
		} else {
		$isSuperSaver = false;
		$isEarlyBird = false;
	} //end of if
?>
	<h1><?php echo TextSelector("Delegate Registration for ".$title, "Inscription des délégués pour ". $eventDetails['etitle_fr']); ?></h1>
	<div>
<?php if ($eventDetails['is_soldout'] == 0): ?>
<?php if ($eventDetails['reg_preamble'] != ""): ?>
		<div class="bg-info" style="padding: 10px; border-radius: 10px;">
			<?php echo TextSelector(htmlspecialchars_decode($eventDetails['reg_preamble']),htmlspecialchars_decode($eventDetails['reg_preamble_fr'])); ?>
		</div>
<?php endif; //end of if ($eventDetails['reg_preamble'] != "") ?>
		<p class="bg-danger" style="padding: 10px; border-radius: 10px;"><?php echo TextSelector("Required fields are marked <i class='glyphicon glyphicon-exclamation-sign'></i>", "Les champs obligatoires sont indiqu&eacute;s <i class='glyphicon glyphicon-exclamation-sign'></i>");?></p>
<?php
if (!empty($delegates)) {
echo "		<div id=\"delegates\">\n"
		."			<h3>".TextSelector("Registered users in your group", "Membres dans votre groupe")."</h3>\n";
	//Iterate through the delegates to populate the values.
	foreach ($delegates as $delegate) {
		echo "			<p>".$delegate['first_name']." ".$delegate['last_name']."</p>\n";
	} //end of foreach
echo "		</div>\n";
} //end of of
?>
	</div>
	<div id="registration-form">
		<form method="post" id="reg" class="reg">
			<input type="hidden" id="dir" name="event_dir" value="<?php echo $eventDetails['directory_name']; ?>" />
			<input type="hidden" name="srce" value="registration" />
			<input type="hidden" name="lang" value="<?php echo $lang; ?>" />
			<input type="hidden" name="invited" value="0" />
			<input type="hidden" name="ruid" value="<?php echo $id; ?>" />
			<input type="hidden" name="event_id" value="<?php echo $eventID; ?>" />
<?php
// BEGINNING OF MAIN REGISTRATION FORMBLOCK

// Check if the costs should be displayed at the top - if so, call the functions now.
if ((!empty($eventCost)) && ($eventDetails['cost_display_top'] == 1)) {
echo "			<div class=\"col-md-12 formBlock\">\n";
CreateCostOptionsForm($eventDetails, $eventCost, $costCategories, $days);
CreateExtraCosts($isSuperSaver, $isEarlyBird, $eventExtraCost);
echo "			</div>\n";
} //end of if

// Variables for use.
$countries = "Canada;United States;---------------;Afghanistan;Albania;Algeria;Andorra;Angola;Antigua & Deps;Argentina;Armenia;Australia;Austria;Azerbaijan;Bahamas;Bahrain;Bangladesh;Barbados;Belarus;Belgium;Belize;Benin;Bhutan;Bolivia;Bosnia Herzegovina;Botswana;Brazil;Brunei;Bulgaria;Burkina;Burundi;Cambodia;Cameroon;Cape Verde;Central African Rep;Chad;Chile;China;Colombia;Comoros;Congo;Congo {Democratic Rep};Costa Rica;Croatia;Cuba;Cyprus;Czech Republic;Denmark;Djibouti;Dominica;Dominican Republic;East Timor;Ecuador;Egypt;El Salvador;Equatorial Guinea;Eritrea;Estonia;Ethiopia;Fiji;Finland;France;Gabon;Gambia;Georgia;Germany;Ghana;Greece;Grenada;Guatemala;Guinea;Guinea-Bissau;Guyana;Haiti;Honduras;Hungary;Iceland;India;Indonesia;Iran;Iraq;Ireland {Republic};Israel;Italy;Ivory Coast;Jamaica;Japan;Jordan;Kazakhstan;Kenya;Kiribati;Korea North;Korea South;Kosovo;Kuwait;Kyrgyzstan;Laos;Latvia;Lebanon;Lesotho;Liberia;Libya;Liechtenstein;Lithuania;Luxembourg;Macedonia;Madagascar;Malawi;Malaysia;Maldives;Mali;Malta;Marshall Islands;Mauritania;Mauritius;Mexico;Micronesia;Moldova;Monaco;Mongolia;Montenegro;Morocco;Mozambique;Myanmar, {Burma};Namibia;Nauru;Nepal;Netherlands;New Zealand;Nicaragua;Niger;Nigeria;Norway;Oman;Pakistan;Palau;Panama;Papua New Guinea;Paraguay;Peru;Philippines;Poland;Portugal;Qatar;Romania;Russian Federation;Rwanda;St Kitts & Nevis;St Lucia;Saint Vincent & the Grenadines;Samoa;San Marino;Sao Tome & Principe;Saudi Arabia;Senegal;Serbia;Seychelles;Sierra Leone;Singapore;Slovakia;Slovenia;Solomon Islands;Somalia;South Africa;South Sudan;Spain;Sri Lanka;Sudan;Suriname;Swaziland;Sweden;Switzerland;Syria;Taiwan;Tajikistan;Tanzania;Thailand;Togo;Tonga;Trinidad & Tobago;Tunisia;Turkey;Turkmenistan;Tuvalu;Uganda;Ukraine;United Arab Emirates;United Kingdom;Uruguay;Uzbekistan;Vanuatu;Vatican City;Venezuela;Vietnam;Yemen;Zambia;Zimbabwe";
$countriesArr = explode(";", $countries);
$usStates = "AL;AK;AZ;AR;CA;CO;CT;DE;FL;GA;HI;ID;IL;IN;IA;KS;KY;LA;ME;MD;MA;MI;MN;MS;MO;MT;NE;NV;NH;NJ;NM;NY;NC;ND;OH;OK;OR;PA;RI;SC;SD;TN;TX;UT;VT;VA;WA;WV;WI;WY;GU;PR;VI";
$usStatesArr = explode(";", $usStates);
$provinces = "AB;BC;MB;NB;NL;NT;NS;NU;ON;PE;QC;SK;YT";
$provincesArr = explode(";", $provinces);

// This is the Delegate Registration. There is no CASL to be shown as the Delegate has not personally agreed to receive email.

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
		//} elseif ($categories[$I]['cat_name'] == "casl") {
		//$caslCat = $categories[$I]['cat_text'];
		//$caslCatFr = htmlspecialchars_decode($categories[$I]['cat_text_fr'], ENT_QUOTES);
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
		//} elseif($section == "casl") {
		//$openDiv = "";
		//$closeDiv = "";
		} elseif($section == "extra") {
		$openDiv = "";
		$closeDiv = "";
	} //end of if

	//Open the section's div.
	echo $openDiv;

	//Output the section title.
	echo "					<h2>".$catTitle."</h2>\n";

	//Iterate through the data and output accodingly.	
	foreach($questions as $q){

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

/*		//Check if this is an emcheck field.
		if ($q['question_type'] == "emcheck") {
			//There is only one option - this is for the CASL Email question. Trim just in case...
			$options = rtrim($q['options'], "||");
			$options_fr = rtrim($q['options_fr'], "||");
			//Output the option.
			echo "						<input type=\"checkbox\" class=\"formInput\" name=\"casl\" id=\"casl\" value=\"".TextSelector($options, html_entity_decode($options_fr, ENT_QUOTES))."\"".$requiredStr." /> <label for=\"casl\">".TextSelector($options, html_entity_decode($options_fr, ENT_QUOTES))."</label><br>\n";
		} //end of if*/

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
/*
if ((isset($caslQuestions)) && (!empty($caslQuestions))) {
	echo "			<div class=\"col-md-12 formBlock\">\n";
		$catName = $caslCat;
		$catNameFr = $caslCatFr;
		CreateSection("casl", $caslQuestions, $reg_answers, $extra_answers, $sectors, $countriesArr, $usStatesArr, $provincesArr, $catName, $catNameFr);
	//Close the formblok div.
	echo "			</div>\n";
} //end of if*/

if ((isset($extraQuestions)) && (!empty($extraQuestions))) {
	echo "			<div class=\"col-md-12 formBlock\">\n";
		$catName = $extraCat;
		$catNameFr = $extraCatFr;
		CreateSection("extra", $extraQuestions, $reg_answers, $extra_answers, $sectors, $countriesArr, $usStatesArr, $provincesArr, $catName, $catNameFr);
	//Close the formblok div.
	echo "			</div>\n";
} //end of if

// END OF MAIN REGISTRATION FORMBLOCK
?>
<?php if ((!empty($eventCost)) && ($eventDetails['cost_display_top'] == 0)): ?>
			<div class="col-md-12 formBlock">
<?php
CreateCostOptionsForm($eventDetails, $eventCost, $costCategories, $days);
CreateExtraCosts($isSuperSaver, $isEarlyBird, $eventExtraCost);
?>
			</div>
<?php endif; //end of if (!empty($eventCost)) ?>
<?php if (!empty($eventWorkshop)): ?>
			<div class="col-md-12 formBlock">
<?php
createWorkshops($eventWorkshop);
?>
			</div>
<?php endif; //end of if (!empty($eventWorkshop)) ?>
<?php if (!empty($eventCost)): ?>
			<div class="col-md-12 formBlock">
				<h2><?php echo TextSelector("Promo Code", "Code d'inscription"); ?></h2>
				<label><?php echo TextSelector("Please enter your promo code if applicable:", "Si vous avez un code d'inscription, veuillez l'enscrire ici :");?> <input type="text" name="promo_code_used" /></label>
				<p id="codes">&nbsp;</p>
			</div>
<?php endif; //end of if (!empty($eventCost)) ?>
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
<?php if ($eventDetails['allow_group']): ?>
				<button type="submit" class="btn btn-primary" name="addDel" id="addDel"><?php echo TextSelector("Save and Add Delegate", "Enregistrer et ajouter un délégué"); ?></button>
<?php endif; //end of if ($eventDetails['allow_group']) ?>
				<button type="submit" class="btn btn-primary" name="saveDel" id="saveDel" align="right"><?php echo TextSelector("Save and Continue", "Soumettre et continuer"); ?></button>
			</div>
			<br><br><br><br>
		</form>
	</div><!--/registration-form -->
	<div id="registrants" style="display:none;"></div>
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
			console.log("Changed country to : " + cVal);
			$(".STATE").hide();
			$(".PROV").hide();
			if(cVal == "Canada"){
				console.log("Country is canada");
				$(".PROV").show();
			}
			if(cVal == "United States"){
				$(".STATE").show();
			}
		});
	</script>
<?php if ($eventDetails['use_cost_cat'] == 1): ?>
	<script>
		var catChoice = $('input[name=catRadio]:checked').val();
		$(".costOption").hide();
		$(".catRadio").change(function(){
			var catChoice = $('input[name=catRadio]:checked').val().replace(" ", "_");
			catChoice = catChoice.replace(/\(/g,"");
			catChoice = catChoice.replace(/\)/g,"");
			catChoice = catChoice.replace(/\//g,"");
			catChoice = catChoice.replace(/ /g,"_");
			//catChoice = catChoice.replace("\\","");
			$(".costOption").hide();
			$(".emptyCosts").hide();
			$("." + catChoice).show();
		});
	</script>
<?php endif; ?>
<?php else: ?>
		<div class="soldout">
			<p><?php echo TextSelector($eventDetails['sold_out_msg'], $eventDetails['sold_out_msg_fr']); ?></p>
		</div>
	</div>
<?php endif; ?>
<?php endif; ?>
<?php 
function CreateCostOptionsForm($eventDetails, $eventCost, $costCategories, $days) {

if (!empty($eventCost)) {
	echo "				<div class='costOptionsForm'><h2>".TextSelector("Conference Choice (Required)", "Choix d'atelier (obligatoire)")." <span class=\"glyphicon glyphicon-exclamation-sign\"></span></h2>\n";

	//Display Today's date.
	$currentTime = date('F j, Y', time());

	//Need to evaluate super early and early bird.
	$earlyDate=date('F j, Y', strtotime($eventDetails['early_date']));
	$superEarlyDate=date('F j, Y', strtotime($eventDetails['super_early_date']));
	$diffEarly = strtotime($earlyDate) - time();
	$diffSuperEarly = strtotime($superEarlyDate) - time();
	$isSuperSaver = false;
	$isEarlyBird = false;
	$taxRate = $eventDetails['tax_rate'];
	$taxDesc = $eventDetails['tax_desc'];

	if ($diffSuperEarly > 0) {
		echo "					<p>Super Saver - Valid Until ".$superEarlyDate."</p>\n";
		$isSuperSaver = true;
		$isEarlyBird = false;
		} elseif($diffEarly > 0) {
		echo "					<p>Early Bird - Valid Until ".$earlyDate."</p>\n";
		$isSuperSaver = false;
		$isEarlyBird = true;
		} else {
		echo "					<p>Today's date is: <strong>".$currentTime."</strong></p>\n";
		$isSuperSaver = false;
		$isEarlyBird = false;
	} //end of if

	//Display Cost Options with ID and prices
	$countCost = count($eventCost);
	$eventCostDisp = $eventDetails['cost_display'];

	if ($eventDetails['use_cost_cat'] == 1) {
		$catChoices = "						<table class=\"table table-responsive\">\n"
							."							<tr>\n";
		foreach($costCategories as $cat){
			$catChoices .= "								<td class=\"costCatTD\" width=\"5%\"><input type=\"radio\" name=\"catRadio\" class=\"catRadio\" value=\"".$cat['category_id']."\"></td>\n"
								."								<td class=\"costCatTD\" width=\"95%\"><label>".TextSelector($cat['category_name'], $cat['category_name_fr'])."</label></td>\n";
		} //end of foreach
		$catChoices .= "							</tr>\n"
						."						</table>\n";
		echo "					<div class=\"category-pick\"><h3>".TextSelector("Pick a conference category", "Veuillez choisir une catégorie")."</h3>\n"
				.$catChoices
				."					</div>\n";
	} //end of if

	if ($eventCostDisp == "grid") {
		echo "					<table class=\"table table-bordered\" style=\"table-layout: auto !important;\">\n"
				."						<tr>\n"
				."							<td><strong>".TextSelector("Conference Choice", "Choix de conférence")."</strong></td>\n"
				."							<td><strong>".TextSelector("Cost", "Prix")."</strong></td>\n"
				."							<td><strong>".TextSelector("Tax", "Taxe")."</strong></td>\n"
				."							<td><strong>".TextSelector("Total", "Total")."</strong></td>\n"
				."						</tr>\n";
		if ($eventDetails['use_cost_cat'] == 1) {
			echo "						<tr class=\"emptyCosts\">\n"
					."							<td><strong>".TextSelector("No options for selected category", "Aucune option pour cette catégorie")."</strong></td>\n"
					."							<td></td>\n"
					."							<td></td>\n"
					."							<td></td>\n"
					."						</tr>\n";
		} //end of if
		} else {
		//Display is NOT grid.
		echo "					<div class=\"emptyCosts\"><strong>".TextSelector("No options for selected category", "Aucune option pour cette catégorie")."</strong></div>\n";
	} //end of if ($eventCostDisp == "grid")

	for ($i = 0; $i < $countCost; $i++) {
		$costType = $eventCost[$i]['cost_regular'];
		$costCategory =  $eventCost[$i]['cost_category'];
		$costOneday = $eventCost[$i]['is_oneday'];
		if ($isSuperSaver) {
			$costType = $eventCost[$i]['cost_super_early_bird'];
		} //end of if
		if ($isEarlyBird) {
			$costType = $eventCost[$i]['cost_early_bird'];
		} //end of if
		$class = "costOptionBox";
		$cID = "";
		if ($costOneday == 1) {
			$class .= " oneday";
		} //end of if
		if (($eventCost[$i]['nDays'] != "") && ($eventCost[$i]['nDays'] != 0)) {
			$cID = $eventCost[$i]['nDays'];
		} //end of if
		setlocale(LC_MONETARY, 'en_CA');
		if ($eventCostDisp == "grid") {
			$cChoice = TextSelector($eventCost[$i]['cost_level'], $eventCost[$i]['cost_level_fr']);
			$radioInput = "<input type=\"radio\" name=\"event_option\" class=\"".$class."\" value=\"".$eventCost[$i]['event_cost_option_id']."\" id=\"".$cID."\" /> <label for=\"".$cID."\">".$cChoice."</label>";
			$cost = TextSelector("$".number_format($costType, 2, '.', ','), number_format($costType, 2, ',', ' ')." $");
			$tax = $taxDesc." ".$taxRate;
			$total = "<strong>".TextSelector("$".number_format(round(($taxRate*$costType)+$costType), 2, '.', ','), number_format(round(($taxRate*$costType)+$costType), 2, ',', ' ')." $")."</strong>";
			$hiddenWW = "<input type=\"hidden\" id=\"wwc_".$eventCost[$i]['event_cost_option_id']."\" value=\"".$eventCost[$i]['workshop_score']."\">";
			echo "						<tr class=\"".$costCategory." costOption\">\n"
					."							<td>".$radioInput.$hiddenWW."</td>\n"
					."							<td>".$cost."</td>\n"
					."							<td>".$tax."</td>\n"
					."							<td>".$total."</td>\n"
					."						</tr>\n";
			} else {
			$taxVal = $taxRate*$costType;
			$totalPrice = $costType + $taxVal;
			$hiddenWW = "<input type=\"hidden\" id=\"ww_".$eventCost[$i]['event_cost_option_id']."\" value=\"".$eventCost[$i]['workshop_score']."\">";
			echo "					<input type=\"hidden\" name=\"ev_cost\" value=\"".$costType."\" />"
					."<input type=\"hidden\" name=\"ev_tax_type\" value=\"".$taxDesc."\" />"
					."<input type=\"hidden\" name=\"ev_tax_val\" value=\"".$taxVal."\" />"
					."<input type=\"hidden\" name=\"ev_total_cost\" value=\"".$totalPrice."\" />\n"
					."					<label class=\"".$costCategory." costOption\" style=\"width: 100%;\"><input type=\"radio\" name=\"event_option\" value=\"".$eventCost[$i]['event_cost_option_id']."\" class=\"".$class."\" id=\"".$cID."\" /><span>".TextSelector($eventCost[$i]['cost_level'], $eventCost[$i]['cost_level_fr'])."</span>: $".$costType." + ".$taxDesc." ".$taxRate." = ".TextSelector("$".number_format(round(($taxRate*$costType)+$costType), 2, '.', ','), number_format(round(($taxRate*$costType)+$costType), 2, ',', ' ')." $")."</label>".$hiddenWW."\n";
		} //end of if ($eventCostDisp == "grid")
	} //end of for
	if ($eventCostDisp == "grid") {
		echo "					</table>\n";
	} //end of if

	echo "				</div>\n";	

	$daySelect = "";
	$J = 1;
	foreach ($days as $day) {
		$dayDate = new DateTime($day);
		$dayStr = strftime("%A %e %B %G", strtotime($day));
		$daySelect .= "					<input type=\"checkbox\" name=\"day_option[]\" id=\"day_option_".$J."\" class=\"dayselector\" value=\"".$day."\"> <label for=\"day_option_".$J."\">".$dayStr."</label><br>\n";
		$J += 1;
	} //end of foreach
	
	echo "				<div class=\"daySelection\" style=\"display:none;\">\n"
			."					<h3>Select a date: <span class='glyphicon glyphicon-exclamation-sign'></span></h3>\n"
			.$daySelect
			."				</div>\n";
} //end of if

} //end of function CreateCostOptionsForm($eventDetails, $eventCost, $costCategories, $days)

function createWorkshops($eventWorkshop) {

global $lang;

if (!empty($eventWorkshop)) {
	echo "				<h2>".TextSelector(" Workshop Selection ", "Ateliers ")."</h2>\n"
			."				<div class=\"note\" style=\"background-color: rgba(255, 255, 255, 0.72); padding: 5px; border: 1px solid rgba(0, 0, 0, 0.26); border-radius: 5px;\">\n"
			."					".TextSelector("To change your selections please click the reset selections button", "Pour changer vos séléctions, cliquer le boutton ci-dessous")."<br><br>\n"
			."					<button type=\"button\" class=\"btn btn-secondary\" id=\"resetWorkshops\">".TextSelector("Reset Workshop Selection", "Réinitialiser les ateliers")."</button>\n"
			."				</div>\n";

	foreach ($eventWorkshop as $day=>$sessionDay) {
		$dayTable = "				<div id=\"day_".$day."\" class=\"wwDay\">\n"
						."					<table class=\"table dayTable\">\n";
		$dayDate = new DateTime($day);
		$dayStr = strftime("%A %e %B %G", strtotime($day));
		$dayTable .= "						<tr>\n"
						."							<td><strong>".$dayStr."</strong></td>\n"
						."						</tr>\n";
		$dayTable .= "					</table>";
		echo $dayTable;
		$sessionTable = "					<table class=\"table table-responsive\" style=\"table-layout: fixed;\">\n";
		foreach ($sessionDay as $time=>$rsessions) {
			$timeStr = explode("_", $time);
			$timeStart = new DateTime($timeStr[0]);
			$timeEnd = new DateTime($timeStr[1]);
			if ($lang == "fr") {
				$timeStart = $timeStart->format("H\\hi");
				$timeEnd = $timeEnd->format("H\\hi");
				} else {
				$timeStart = $timeStart->format("H:i");
				$timeEnd = $timeEnd->format("H:i");
			} //end of if
			$rowStr = "						<tr>\n"
						."							<td colspan=\"1\">".$timeStart." - ".$timeEnd."</td>\n"
						."							<td colspan=\"3\" style=\"padding: 0px;\">\n";

			$spkrStr = "";
			$spkrStr2 = "";
			foreach ($rsessions as $session) {
				$sessionTitle = TextSelector($session['session_title'], $session['session_title_fr']);
				$sessionID = $session['session_id'];
				$sessionCode = $session['session_code'];
				$sessionSpeakers = $session['speakers'];
				$containedSessions = $session['containedSessions'];
				$scStr = "";
				$spkrStr = "";
				$containedStr = "";

				$scStr = "";
				if (!empty($sessionSpeakers)) {
					$spkrStr = "								<div class=\"session_speakers\">\n"
									."									<h4>".TextSelector("Featuring:", "Animé Par:")."</h4>\n";
					$spkrStr2 = "								<div class=\"session_speakers\">\n"
									."									<h4>".TextSelector("Featuring:", "Animé Par:")."</h4>\n";
					foreach ($sessionSpeakers as $spkr) {
						$spkrName = $spkr['speaker_first_name'] . " " . $spkr['speaker_last_name'];
						$spkrTitle = TextSelector($spkr['speaker_title'], $spkr['speaker_title_fr']);
						$spkrCompany = TextSelector($spkr['speaker_company'], $spkr['speaker_company_fr']);
						$spkrBio = TextSelector($spkr['speaker_bio'], $spkr['speaker_bio_fr']);
						$spkrStr .= "									<div class=\"spkrInfo\">\n"
										."										<strong>".$spkrName."</strong><br>\n"
										."										<span>".$spkrTitle.", ".$spkrCompany."</span><br>\n"
										."										<span class=\"spkrBio\">".$spkrBio."</span>\n"
										."									</div><br>\n";
						$spkrStr2 .= "									<div class=\"spkrInfo\">\n"
										."										<strong>".$spkrName."</strong><br>\n"
										."										<span>".$spkrTitle.", ".$spkrCompany."</span>\n"
										."									</div><br>\n";
					} //end of foreach
					$spkrStr .= "								</div>\n";
				} //end of if

				if ($sessionCode != "") {
					$scStr = "									".$sessionCode." : ";
				} //end of if
				$sessionDesc = html_entity_decode(TextSelector($session['session_description'], $session['session_description_fr']), ENT_QUOTES, 'UTF-8');
				$sessionRoom = $session['roomName'];
				$sessionType = $session['session_type'];
				$sessionColor = $session['color'];
				$sessionWW =$session['workshop_weight'];
				$hiddenWW = "<input type=\"hidden\" class=\"workshopweight\" id=\"ww_$sessionID\" value=\"".$sessionWW."\">";
				$selectBox= "";
				$checked = "";
				$sessionInfoStr = "									<h4><strong>".$sessionTitle."</strong></h4>\n"
										."									".$sessionDesc."\n"
										.$spkrStr;

				$shortSpkr = "";
				if (!empty($containedSessions)) {
					$containedStr = "									<div class=\"contained_sessions\">\n"
										."										<h2>".TextSelector("Grouped Session", "Session en groupe")."</h2>\n";
					foreach ($containedSessions as $cSession) {
						$cSpkrs = $cSession['speakers'];
						$cspStr = "";
						if (!empty($cSpkrs)) {
							$cspStr = "											<div class=\"session_speakers\">\n"
										."												<h4>".TextSelector("Featuring:", "Animé Par:")."</h4>\n";
							$shortSpkr = "									<div class=\"session_speakers\"><h4>\n"
											."										".TextSelector("Featuring:", "Animé Par:")."</h4>\n";
							foreach ($cSpkrs as $spkr) {
								$spkrName = $spkr['speaker_first_name']." ".$spkr['speaker_last_name'];
								$spkrTitle = TextSelector($spkr['speaker_title'], $spkr['speaker_title_fr']);
								$spkrCompany = TextSelector($spkr['speaker_company'], $spkr['speaker_company_fr']);
								$spkrBio = TextSelector($spkr['speaker_bio'], $spkr['speaker_bio_fr']);
								$cspStr .= "												<div class=\"spkrInfo\">\n"
											."													<strong>".$spkrName."</strong><br>\n"
											."													<span>".$spkrTitle.", ".$spkrCompany."</span><br>\n"
											."													<span class=\"spkrBio\">".$spkrBio."</span>\n"
											."												</div><br>\n";
								$shortSpkr .= "										<div class=\"spkrInfo\">\n"
												."											<strong>".$spkrName."</strong><br>\n"
												."											<span>".$spkrTitle.", ".$spkrCompany."</span>\n"
												."										</div><br>\n";
							} //end of foreach
							$cspStr .= "											</div>\n";
						} //end of if
						$csStr = "										<div class=\"c_session\" style=\"background-color:".$cSession['color'].";\">\n"
									."											<h3>".html_entity_decode(TextSelector($cSession['session_title'], $cSession['session_title_fr']))."</h3>\n"
									."											<p>".html_entity_decode(TextSelector($cSession['session_description'],$cSession['session_description_fr']))."</p>\n"
									.$cspStr
									."										</div>\n";
						$containedStr .= $csStr;
					} //end of foreach
					$containedStr .= "									</div>\n";
					//$sessionInfoStr = $containedStr;
					$sessionInfoStr .= $containedStr;
				} //end of if

				if (isset($selections)) {
					foreach ($selections as $sel) {
						//echo "CHECK IF $sel[session_id] == $sessionID ";
						if ($sel['session_id'] == $sessionID) {
							$checked = " checked";
						} //end of if
					} //end of foreach
				} //end of if
				if ($sessionType != "plenary") {
					if (count($rsessions) > 1) {
						$selectBox = "									<input type=\"radio\" id=\"".$sessionID."\" class=\"selectSession\" name=\"selectWorkshop_".$sessionID."[]\" value=\"".$sessionID."\"".$checked." />";
						} else {
						$selectBox = "									<input type=\"checkbox\" id=\"".$sessionID."\" class=\"selectSession\" name=\"selectWorkshop_".$sessionID."[]\" value=\"".$sessionID."\"".$checked." />";
					} //end of if
				} //end of if
				//This goes nowhere...
				if ($spkrStr != "") {
					$rightSpkr = "<div class=\"spkrs_".$sessionID."\">".$spkrStr2."</div>";
					} else {
					$rightSpkr =  "<div class=\"spkrs_".$sessionID."\">".$shortSpkr."</div>";
				} //end of if
				$showMore = "<span class=\"showMore\" id=\"$sessionID\">".TextSelector("Show Details", "Plus de détails")."</span> <span style=\"font-style: italic;\">".$sessionRoom."</span>";
				$sessionStr = "								<div class=\"session\" style=\"background-color: ".$sessionColor.";\">\n"
								.$selectBox
								.$scStr.$sessionTitle." ".$showMore." ".$hiddenWW."\n"
								//."								</div></div>"; //Why 2 divs...?
								."								</div>\n";
				$details = "								<div id=\"details_".$sessionID."\" class=\"sDetails\" style=\"display: none;\">\n"
								.$sessionInfoStr
								."								</div>\n";
				$rowStr .= $sessionStr;
				$rowStr .= $details;
			} //end of foreach
			//Close the table cell and the row.
			$rowStr .= "							</td>\n"
						."						</tr>\n";
			$sessionTable .= $rowStr;
		} //end of foreach
		$sessionTable .= "					</table>\n"
							."				</div>\n";
		echo $sessionTable;
	} //end of foreach

	//echo "<button type='submit' class='btn btn-primary' name='saveSelections'>Submit</button>";
	//echo "<form>";
} //end of if

} //end of function createWorkshops($eventWorkshop)

function CreateExtraCosts($isSuperSaver, $isEarlyBird, $extraCosts) {

if (!empty($extraCosts)) {
	echo "				<div id=\"extraCosts\" style=\"margin-top: 10px;\">\n"
			."					<ul style=\"list-style: none; padding-left: 0px;\">\n";
	foreach ($extraCosts as $cost) {
		$costID = $cost['extra_event_cost_option_id'];
		$costLabel = TextSelector($cost['cost_level'], $cost['cost_level_fr']);
		$costPrice = $cost['cost_regular'];
		$costText = TextSelector($cost['extra_text'], $cost['extra_text_fr']);
		if ($isEarlyBird) {
			$costPrice = $cost['cost_early_bird'];
		} //end of if
		if ($isSuperSaver) {
			$costPrice = $cost['cost_super_early_bird'];
		} //end of if
		echo "						<li><input type=\"checkbox\" name=\"extraCost[]\" value=\"".$costID."\"> <label style=\"display: inline;\">".$costLabel." - $".$costPrice."</label> <div>".$costText."</div></li>\n";
	} //end of foreach
	echo "					</ul>\n"
			."				</div>\n";
} //end of if

} //end of function CreateExtraCosts($isSuperSaver, $isEarlyBird, $extraCosts)
?>
	<script>
		var nDays = 0;
		var workshopScore = 0;
		var isOneDay = false;
		var totalScore = parseInt(0);
		$("#resetWorkshops").click(function(){
			$(".selectSession").each(function(){
				$(this).prop('checked', false);
			});
			totalScore = 0;
			handleSessions();
		});
		$(".costOptionBox").change(function(){
			var isOneDayChecked = false;
			var checkedOption = null;
			var costID = $(this).val();
			$(".dayselector").each(function(){
				$(this).prop("checked", false);
			});
			$(".selectSession").each(function(){
				$(this).prop('checked', false);
			});
			workshopScore = 0;
			totalScore = 0;
			$(".costOptionBox").each(function(){
				var checked = $(this).prop("checked");
				var costID = $(this).val();
				var costWW = $("#wwc_" + costID).val();
				if($(this).hasClass("oneday")){
					if(checked){
						isOneDayChecked = true;
						isOneDay = true;
						checkedOption = $(this);
					} else {
					}	
				} else {
					if(checked)
						isOneDay = false;
				}
				if(checked){
					workshopScore = costWW;
					handleSessions();
				}
			});
			if(isOneDayChecked){
				//display day selection
				$(".daySelection").fadeIn("fast");
			} else {
				$(".daySelection").fadeOut("fast");
			}
			if(checkedOption != null){
				nDays = parseInt(checkedOption.attr("id"));
				checkDays();
			}
		});
		$(".dayselector").click(function(){
			checkDays();
			handleSessions();
		});
		function checkDays(){
			if(nDays == 0){
				$(".dayselector").attr("disabled", true);
			}else{
				//Get number of selected days
				var nDaysSelected = 0;
				$(".dayselector:checked").each(function(){
					nDaysSelected++;
				});
				if(nDaysSelected == nDays){
					$(".dayselector").each(function(){
						var dayChecked = $(this).prop("checked");
						if(!dayChecked ){
							$(this).attr("disabled", true);
						}
					});
				} else if(nDaysSelected < nDays){
					$(".dayselector").attr("disabled", false);
				}
			}
		}
		$(".showMore").click(function(){
			var id = $(this).attr("id");
			/*
			$(".spkrs_" + id).slideToggle('fast', function(){
				$("#details_" + id).slideToggle('fast');
			});
			*/
			$("#details_" + id).slideToggle('fast');
		});
		var handleSessions = function(){
			if(isOneDay){
				//Get the days selected
				$(".wwDay").hide();
				$(".dayselector").each(function(){
					var sDay = $(this).val();
					var checked = $(this).prop("checked");
					if(checked){
						$("#day_" + sDay).show();
					}
				});
			} else {
				$(".wwDay").show();
			}
			if(totalScore == workshopScore){
				//disable all inpupt that isn't checked
				$(".selectSession").each(function(){
					var sChecked = $(this).prop("checked");
					if(!sChecked){
						$(this).prop("disabled", true);
					}
				});
			} else {
				//enable only selections that don't over the score
				$(".selectSession").each(function(){
					var sChecked = $(this).prop("checked");
					var sID = $(this).attr("id");
					var sScore = parseInt($("#ww_" + sID).val());
					if(!sChecked){
						if(totalScore + sScore > workshopScore){
							$(this).prop("disabled", true);
						} else {
							$(this).prop("disabled", false);
						}
					}
				})
			}
		};
		//Calc total score by checked sessions
		$(".selectSession").each(function(){
			var checked = $(this).prop("checked");
			var id = $(this).attr('id');
			var score = parseInt($("#ww_" + id).val());
			if(checked){
				totalScore += score;
			}
		});
		handleSessions();
		$(".selectSession").click(function(){
			var checked = $(this).prop("checked");
			var id = $(this).attr("id");
			var score = parseInt($("#ww_" + id).val());
			if(checked){
				totalScore += score;
			} else {
				totalScore -= score;
			}
			handleSessions();
		});
	</script>

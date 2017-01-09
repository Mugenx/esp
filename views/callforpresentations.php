<?php
// FileName:     callforpresentations.php
// Author:       EventSystemPro
// Copyright:    © EVENTSYSTEMPRO 2016. ALL RIGHTS RESERVED.
// Web Version:  3.0000
// Date:         11/16/2016
?>
<?php 
			$titleSplit = explode(" ", $eventDetails['etitle']);
			$dateStart = explode("-", $eventDetails['start_date']);
			$dateEnd = explode("-", $eventDetails['end_date']);
			$dateString = "";
			
			if($dateStart[1] == $dateEnd[1]){
				$dateObj   = DateTime::createFromFormat('!m', $dateEnd[1]);
				$monthName = $dateObj->format('F'); 
				$dateString = $monthName . " " . ltrim($dateStart[2], '0') . "th - " . ltrim($dateEnd[2], '0') . "th, " . $dateEnd[0] ;
			} else {
				$startMonthName = DateTime::createFromFormat('!m', $dateStart[1])->format('F');
				$endMonthName = DateTime::createFromFormat('!m', $dateEnd[1])->format('F');
				$dateString = $startMonthName . " " . $dateStart[2] . " - " . $endMonthName . " " . $dateEnd[2] . ", " . $dateEnd[0] ;
			}
			$locationString = $eventDetails['location'];
			$infoString = $dateString . " | " . $locationString;
			$description = $eventDetails['edescription'];
			$eDir = $eventDetails['directory_name'];
			
			$url = explode('/', $_GET['url']);
			$currEventCode = strtolower($url[count($url) -1]);
			
			$uniqID = "";
			if($currEventCode != "" && $currEventCode != "callforpresentations"){
				$uniqID = $currEventCode;
			}
			$actionUrl = "$eDir/cfpSubmit";
			if($uniqID != ""){
				$actionUrl = "$eDir/cfpSubmit/" .$uniqID ;
			}
		 ?>

<script>
jQuery.fn.wordCount = function(params)
{
   var p =  {
   counterElement:"display_count",
   max:"10",
   };
  var total_words;

  if(params) {
      jQuery.extend(p, params);
  }

  //for each keypress function on text areas
 this.bind('input propertychange', function()
  {
    total_words=this.value.split(/[\s]+/).length;
	$("#" + p.counterElement).css("border-radius", "2px");
	$("#" + p.counterElement).css("margin-left", "5px");
	$("#" + p.counterElement).css("padding", "2px");
	if(total_words > p.max){
		$("#" + p.counterElement).css("background-color", "#BF1717");
		$("#" + p.counterElement).css("color", "white");
	}else{
		$("#" + p.counterElement).css("background-color", "transparent");
		$("#" + p.counterElement).css("color", "black");
	}
   jQuery('#'+p.counterElement).html(total_words);
  });
};
</script>
<?php

if ($lang == "" || $lang == "en") {
			
?>
			<div style="padding: 10px; border-radius: 10px;"><?php echo htmlspecialchars_decode($eventDetails['cfp_preamble']); ?></div>
<?php

	} else {
?>
			<div style="padding: 10px; border-radius: 10px;"><?php echo htmlspecialchars_decode($eventDetails['cfp_preamble_fr']); ?></div>
<?php	
	}
	
?>
<form id="cfp-form" method="post" action="<?php echo $actionUrl; ?>" enctype="multipart/form-data">
	<div class="formBlockCFP">
		<h2 class="cfpTitle"><?php echo TextSelector("Call for Abstracts", "Appel de résumés"); ?></h2>
		<p class="bg-danger" style="padding: 10px; border-radius: 10px;"><?php echo TextSelector("Required fields are marked <i class='glyphicon glyphicon-exclamation-sign'></i>", "Les champs obligatoires sont indiqu&eacute;s <i class='glyphicon glyphicon-exclamation-sign'></i>");?></p>
		<input type="hidden" name="event_id" value="<?php echo $eventID; ?>">
<?php

// Check if there are any results
if(isset($results)) {
	//Print submitter questions
	$countries = "Afghanistan;Albania;Algeria;Andorra;Angola;Antigua & Deps;Argentina;Armenia;Australia;Austria;Azerbaijan;Bahamas;Bahrain;Bangladesh;Barbados;Belarus;Belgium;Belize;Benin;Bhutan;Bolivia;Bosnia Herzegovina;Botswana;Brazil;Brunei;Bulgaria;Burkina;Burundi;Cambodia;Cameroon;Canada;Cape Verde;Central African Rep;Chad;Chile;China;Colombia;Comoros;Congo;Congo {Democratic Rep};Costa Rica;Croatia;Cuba;Cyprus;Czech Republic;Denmark;Djibouti;Dominica;Dominican Republic;East Timor;Ecuador;Egypt;El Salvador;Equatorial Guinea;Eritrea;Estonia;Ethiopia;Fiji;Finland;France;Gabon;Gambia;Georgia;Germany;Ghana;Greece;Grenada;Guatemala;Guinea;Guinea-Bissau;Guyana;Haiti;Honduras;Hungary;Iceland;India;Indonesia;Iran;Iraq;Ireland {Republic};Israel;Italy;Ivory Coast;Jamaica;Japan;Jordan;Kazakhstan;Kenya;Kiribati;Korea North;Korea South;Kosovo;Kuwait;Kyrgyzstan;Laos;Latvia;Lebanon;Lesotho;Liberia;Libya;Liechtenstein;Lithuania;Luxembourg;Macedonia;Madagascar;Malawi;Malaysia;Maldives;Mali;Malta;Marshall Islands;Mauritania;Mauritius;Mexico;Micronesia;Moldova;Monaco;Mongolia;Montenegro;Morocco;Mozambique;Myanmar, {Burma};Namibia;Nauru;Nepal;Netherlands;New Zealand;Nicaragua;Niger;Nigeria;Norway;Oman;Pakistan;Palau;Panama;Papua New Guinea;Paraguay;Peru;Philippines;Poland;Portugal;Qatar;Romania;Russian Federation;Rwanda;St Kitts & Nevis;St Lucia;Saint Vincent & the Grenadines;Samoa;San Marino;Sao Tome & Principe;Saudi Arabia;Senegal;Serbia;Seychelles;Sierra Leone;Singapore;Slovakia;Slovenia;Solomon Islands;Somalia;South Africa;South Sudan;Spain;Sri Lanka;Sudan;Suriname;Swaziland;Sweden;Switzerland;Syria;Taiwan;Tajikistan;Tanzania;Thailand;Togo;Tonga;Trinidad & Tobago;Tunisia;Turkey;Turkmenistan;Tuvalu;Uganda;Ukraine;United Arab Emirates;United Kingdom;United States;Uruguay;Uzbekistan;Vanuatu;Vatican City;Venezuela;Vietnam;Yemen;Zambia;Zimbabwe";
	$countriesArr = explode(";", $countries);
	$usStates = "AL;AK;AZ;AR;CA;CO;CT;DE;FL;GA;HI;ID;IL;IN;IA;KS;KY;LA;ME;MD;MA;MI;MN;MS;MO;MT;NE;NV;NH;NJ;NM;NY;NC;ND;OH;OK;OR;PA;RI;SC;SD;TN;TX;UT;VT;VA;WA;WV;WI;WY;GU;PR;VI";
	$usStatesArr = explode(";", $usStates);
	$provinces = "AB;BC;MB;NB;NL;NT;NS;NU;ON;PE;QC;SK;YT";
	$provincesArr = explode(";", $provinces);
	$subQuestions = isset($results['submitter']) ? $results['submitter'] : array();
	$sesQuestions = isset($results['session']) ? $results['session'] : array();
	$spkQuestions = isset($results['speaker']) ? $results['speaker'] : array();
	$rK = 0;
	if(!isset($answers)){
		$answers = array();
	}
	if(!isset($spkrAnswers)) {
		$spkrAnswers = array();
	}
	if(!empty($subQuestions)) {
		handleSection($subQuestions, $answers, "submitter", $countriesArr, $usStatesArr, $provincesArr, null);
	}
	if(!empty($sesQuestions)) {
		handleSection($sesQuestions, $answers, "submitter", $countriesArr, $usStatesArr, $provincesArr, null);
	}
	if(!empty($spkQuestions)) {
		if(!empty($spkrAnswers)) {
			foreach($spkrAnswers as $k => $speakerAns) {
				$rK = $k + 1;
				handleSection($spkQuestions, $speakerAns, "speaker", $countriesArr, $usStatesArr, $provincesArr, $rK);
			} //end of foreach
			} else {
			handleSection($spkQuestions, null, "speaker", $countriesArr, $usStatesArr, $provincesArr, 1);
		} //end of if
		echo "		<div id=\"extraSpeakers\"></div><input type=\"hidden\" name=\"last_id\" id=\"last_num\" value=\"" . $rK . "\">\n";
		echo "		<button type=\"button\" class=\"btn btn-lg btn-block\" id=\"addSpkrForm\">" . TextSelector("Add an Extra Presenter", "Ajouter un(e) autre Animateur/trice") . "</button><br>\n";
	}
	echo "		<div class=\"g-recaptcha\" data-type=\"image\" data-sitekey=\"".SITKEY."\"></div>\n";
	echo "		<br><br><button class=\"btn btn-lg btn-primary btn-block\" type=\"submit\" name=\"submit_cfp\" id=\"submit\">" . TextSelector("Submit", "Soumettre") . "</button><br>\n";
}

// The function to handle the output of the questions and answers labels and field elements, based on the definitions provided in the design of this form.
function handleSection($questions, $answers, $questionCat, $countriesArr, $usStatesArr, $provincesArr, $spIndex) {

	$spkrStr = "";
	$pre = "cfp";

	if($questionCat == "submitter") {
		echo "		<div class=\"cfpForm_section\" id=\"section_" . $questionCat. "\">\n";
		echo "			<h3>". TextSelector("Submitter Information", "Renseignements sur le déposant") . "</h3>\n";
	} //end of if
	if($questionCat == "session") {
		echo "		<div class=\"cfpForm_section\" id=\"section_" . $questionCat. "\">\n";
		echo "			<h3>". TextSelector("Session Information", "Renseignements sur la présentation") . "</h3>\n";
	} //end of if
	if($questionCat == "speaker") {
		echo "		<div class=\"cfpForm_section\" id=\"section_speaker\"><a class=\"btn-lg\" id=\"removeSpkr\" style=\"float: right; cursor:pointer; display:none\"> <span class=\"glyphicon glyphicon-remove\"></span></a>\n";
		echo "			<h3>". TextSelector("Presenter Information", "Renseignements sur l’animateur/trice") . "</h3>\n";
		echo "			<input type=\"checkbox\" class=\"same_as_button\"><label>" . TextSelector("Same as submitter information", "Mêmes renseignements que l’auteur(e) de la soumission") . "</label><br>\n";;
		$spkrStr = "[]";
		$pre = "spkr";
	} //end of if

	$sI = "";
	if($spIndex != null) {
		$sI = "_" . $spIndex;
	} //end of if

	//Iterate through the questions, matching them up to the answers.
	foreach($questions as $q){

		$isReq = "";
		$requiredStr = "";
		$defaultID = "";
		$v = "";

		//Output the field label

		if($q['is_required'] == 1){
			$isReq = "&nbsp;<span class=\"glyphicon glyphicon-exclamation-sign\"></span><br>\n";
			$requiredStr = " required";
			} else {
			$isReq = "<br>\n";
		} //end of if

		echo "			<label>" . TextSelector($q['title'],html_entity_decode($q['title_fr'])) . "</label>" . $isReq;

		if($answers != null) {
			foreach($answers as $answer){
				if($answer['question_id'] == $q['id']){
					$v = $answer['answer'];
				} //end of if
			} //end of foreach
		} //end of if

		if($q['code'] != ""){
			$defaultID = $q['code'];
		} //end of if

		if(TextSelector($q['extra_text'], $q['extra_text_fr']) != "") {
			echo "			<div class=\"extraText\">" . TextSelector($q['extra_text'], $q['extra_text_fr']) . "</div>\n";
		} //end of if

		//Start loading inputs

		//This is for an edit box.
		if($q['question_type'] == "textbox") {
			echo "			<input type=\"text\" id=\"" . $defaultID . "\" class=\"form-control formInput\" name=\"" . $pre  . "_" . $q['id'] . $sI . "\"" . $requiredStr  . " value=\"" . $v . "\" >\n";
		} //end of if

		//This is for the Country selector.
		if($q['question_type'] == "country") {
			$CYS = "			<select class=\"form-control formInput\" name=\"" . $pre . "_" . $q['id'] . $sI  . "\"" . $requiredStr . " id=\"countryQ\">"
							."<option value=\"\">Please select make a selection</option>";
			//Iterate through the Countries.
			foreach($countriesArr as $country) {
				$country = trim($country, " ");
				$sel = "";
				if($v == $country){
					$sel = " selected";
				} //end of if
				$CYS .= "<option value=\"$country\"" . $sel . ">" . $country . "</option>";
			} //end of foreach
			$CYS .= "<option value=\"other\">Other</option>"
							."</select>\n";
			echo $CYS;
		} //end of if

		//This is for the State and Province Selector.
		if($q['question_type'] == "province"){
			$PRST = "			<select class=\"form-control formInput\" name=\"" . $pre . "_" . $q['id'] . $sI  . "\"" . $requiredStr . " id=\"provinceQ\">"
							."<option value=\"\">Please select make a selection</option>";
			//Check if this is the US.
			if($q['us'] == 1){
				$PRST .= "<option disabled class=\"STATE\"> States </option>";
				//Iterate through the US states.
				foreach($usStatesArr as $state){
					$state = trim($state, " ");
					$sel = "";
					if($v == $state){
						$sel = " selected";
					} //end of if

					$PRST .= "<option value=\"$state\" class=\"STATE\"". $sel .">$state</option>";
				} //end of foreach
			} //end of if
			if($q['ca'] == 1){
				$PRST .= "<option disabled class=\"PROV\"> Provinces </option>";
				//Iterate through the Canadian provinces.
				foreach($provincesArr as $prov){
					$prov = trim($prov, " ");
					$sel = "";
					if($v == $prov){
						$sel = " selected";
					} //end of if
					$PRST .= "<option value=\"$prov\" class=\"PROV\"" . $sel . ">$prov</option>";
				} //end of foreach
			} //end of if
			$PRST .= "<option value=\"other\">". TextSelector("Other", "Autre") ."</option></select>\n";
			echo $PRST;
		} //end of if

		//This is for a text area.
		if($q['question_type'] == "textarea"){
			//If $q['word_limit'] != 0
			$limitClass = "";
			if($q['word_limit'] > 0){
				$limitClass= "limitedArea";
				echo "			<span>Word count:</span><span id=\"count_" . $q['id']  . "\">0</span>\n";
			}
			echo "			<textarea  id=\"" . $defaultID. "\" class=\"form-control formInput " . $limitClass . "\" name=\"" . $pre  . "_" . $q['id'] . $sI  . "\"" . $requiredStr  . "  limit=\"" . $q['word_limit'] . "\">" . $v . "\n";
			echo "			</textarea>\n";
		}

		//The checkboxes.
		if($q['question_type'] == "checkbox") {
			$options = explode("||", $q['options']);
			$options_fr = explode("||", $q['options_fr']);
			$answerArr = null;
			if(count(explode("||", $v)) > 1) {
				$answerArr = explode("||", $v);
			} //end of if
			//Iterate through the required checkboxes.
			foreach($options as $k=>$o) {
				$isCheck = "";
				if($answerArr != null) {
					foreach($answerArr as $a) {
						if($a == $o || $a == $options_fr[$k]) {
							$isCheck = " checked";
						} //end of if
					} //end of foreach
					} else {
					if($v == $o || $v == $options_fr[$k]) {
						$isCheck = " checked";
					} //end of if
				} //end of if
				echo "			<input type=\"checkbox\" class=\"formInput\" name=\"" . $pre  . "_" . $q['id'] . $sI . "[]\" value=\"" . TextSelector($options[$k], $options_fr[$k]) . "\"" . $requiredStr . $isCheck . "><label>" . html_entity_decode(TextSelector($options[$k], html_entity_decode($options_fr[$k]))) . "</label><br>\n";
			} //end of foreach
		} //end of if

		//The radio buttons.
		if($q['question_type'] == "radio") {
			$options = explode("||", $q['options']);
			$options_fr = explode("||", $q['options_fr']);
			$answerArr = null;
			if(count(explode("||", $v)) > 1) {
				$answerArr = explode("||", $v);
			} //end of if
			//Iterate through the required radio buttons.
			foreach($options as $k=>$o) {
				$isCheck = "";
				if($answerArr != null) {
					foreach($answerArr as $a) {
						if($a == $o  || $a == $options_fr[$k]) {
							$isCheck = " checked";
						} //end of if
					} //end of foreach
					} else {
					if($v == $o || $v == $options_fr[$k]) {
						$isCheck = " checked";
					} //end of if
				} //end of if
				echo "			<input id=\"" . $defaultID . "\" type=\"radio\" class=\"formInput\" name=\"" . $pre  . "_" . $q['id'] . $sI . "\" value=\"". TextSelector($options[$k], $options_fr[$k]) . "\"" . $requiredStr . $isCheck . "><label>" .  html_entity_decode(TextSelector($options[$k], html_entity_decode($options_fr[$k])), ENT_QUOTES) . "</label><br>\n";
			} //end of foreach
		} //end of if

		//This is for Select drop-downs.
		if($q['question_type'] == "select"){
			$options = explode("||", $q['options']);
			$options_fr = explode("||", $q['options_fr']);
			$answerArr = null;
			if(count(explode("||", $v)) > 1){
				$answerArr = explode("||", $v);
			}
			$SLCT = "			<select name=\"" . $pre  . "_" . $q['id'] . $sI . "\" class=\"form-control formInput\" id=\"" . $defaultID . "\"" . $requiredStr . ">";
			//Iterate through the drop-down's options.
			foreach($options as $k=>$o){
				$isCheck = "";
				if($answerArr != null){
					foreach($answerArr as $a){
						if($a == $o  || $a == $options_fr[$k]){
							$isCheck = " selected";
						} //end of if
					} //end of foreach
					} else {
					if($v == $o || $v == $options_fr[$k]){
						$isCheck = " selected";
					} //end of if
				} //end of if
				$SLCT .= "<option value=\"" . TextSelector($options[$k], $options_fr[$k]) . "\"" . $isCheck . ">" . TextSelector($options[$k], $options_fr[$k]) . "</option>";
			} //end of foreach
			$SLCT .= "</select>\n";
			echo $SLCT;
		} //end of if

		//Obviously for images.
		if($q['question_type'] == "image") {
			echo "			<input type=\"file\" class=\"form-control formInput\" name=\"" . $pre . "_" . $q['id'] . $sI . "\" value=\"" . $v . "\"><br>\n";
			if($v != "") {
				echo "			<input type=\"hidden\" name=\"" . $pre . "_" . $q['id'] . $sI . "\" value=\"" . $v . "\"><br>\n";
				echo "			<img src=\"" . $v . "\" class=\"spkrImg\">\n";
			} //end of if
		} //end of if

		//The item was a label only which has already been output at the top of this foreach statement.
		if($q['question_type'] == "label") {
			// No input to echo;
			echo "			<br>\n";
		} //end of if

		//echo "<br>";	
		echo "			<br>\n";	

	} //end of foreach

	//Close the section's div tag.
	echo "		</div><br>\n";

} //end of function handleSection(...)

?>
	</div>
</form>
</div>
<script>
	function rtrim(str, chr) {
	  var rgxtrim = (!chr) ? new RegExp('\\s+$') : new RegExp(chr+'+$');
	  return str.replace(rgxtrim, '');
	}
	$("textarea").each(function(i, el){
		if($(this).attr("limit") > 0){
			console.log("Textarea " + $(this).attr("name") + " has a limit of " + $(this).attr("limit") + " words.");
			//get id
			var id = $(this).attr("name").split("_")[1];
			id = rtrim(id, "[]");
			id.replace(/\[\d\]$/, "");
			if(id[id.length - 1] == "]"){
				id = id.slice(0, -2);
			}
			console.log("ID: " + id);
			var name = "count_" + id;
			console.log("NAME: " + name);
			$(this).wordCount({max: $(this).attr("limit"), counterElement: name});
		}
	});
	$("#submit").click(function(){
		$(this).preventDefault();
	});
	$("#cfp-form").validate({
		onfocusout: false,
		errorPlacement: function(error, element) {
		//error.prependTo(element.prev().prev());
		element.prop("placeholder", error.html());
		},
		showErrors: function(errorMap, errorList){ 
			//alert("Some required fields are missing");
			this.defaultShowErrors();
		},
		submitHandler: function(form) {
			var valid = true;
			$("textarea").each(function(i, el){
				if($(this).attr("limit") > 0){
					var max = $(this).attr("limit");
					var words = $(this).val().split(/[\s]+/).length;
					if(words > max){
						valid = false;
					}
				}
			});
			if(valid){
				form.submit();
			} else {
				alert("You have entered too many words on a limited text field");
			}
		}
	});
	jQuery(document).ready(function($) {
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
		$("a").each(function(index){
			if($(this).attr('id') == "removeSpkr"){
				$(this).click(function(){
					$(this).parent().remove();
				});
			}
		});
		
		$("#removeSpkr").first().hide();
	
		$(".same_as_button").each(function(index){
			$(this).change(function(){
			console.log("CHANGED: " + $(this).prop("checked"));
			if($(this).prop("checked")){
				copySubToSpk($(this).parent());
			}else{
				clearSpkr($(this).parent());
			}
			});
		});
	
		$("#addSpkrForm").click(function(){
			console.log("Add speaker");
			addSpkrForm();
			var form = $('#cfp-form').get(0);
			$.removeData(form, 'validator');
			$("#cfp-form").validate({
						onfocusout: false,
				errorPlacement: function(error, element) {
					error.prependTo(element.prev().prev());
				}
			});
		});
		function copySubToSpk(elem){
			elem.find("#spkr_first_name").val($("#first_name").val());
			elem.find("#spkr_last_name").val($("#last_name").val());
			elem.find("#spkr_job_title").val($("#job_title").val());
			elem.find("#spkr_salutation").val($("#salutation").val());
			elem.find("#spkr_organization").val($("#organization").val());
			elem.find("#spkr_phone").val($("#phone").val());
			elem.find("#spkr_email").val($("#email").val());
			
		}
		function clearSpkr(elem){
			elem.find("#spkr_first_name").val("");
			elem.find("#spkr_last_name").val("");
			elem.find("#spkr_job_title").val("");
			elem.find("#spkr_organization").val("");
			elem.find("#spkr_phone").val("");
			elem.find("#spkr_email").val("");
		}
		var spkFrm = 0;
		
		function addSpkrForm(){
			var newForm;
			var nNum = parseInt($("#last_num").val());
			newForm = $("#section_speaker").clone();
			newForm.find(".same_as_button").change(function(){
				console.log("CHANGED: " + $(this).prop("checked"));
				if($(this).prop("checked")){
					//copySubToSpk($(this).parent());
					clearSpkr($(this).parent());
				} else {
					clearSpkr($(this).parent());
				}
			});
			newForm.find("#removeSpkr").show();
			newForm.find(".formInput").each(function(){
				var name = $(this).prop("name");
				var nameArr = name.split("_");
				if(nameArr.length == 3){
					nameArr[2] = parseInt(nNum) + 1;
					$(this).prop("name", nameArr.join("_"));
				}
				console.log("This input is a " + $(this).attr("type"));
				if($(this).attr("type") != "radio" && $(this).attr("type") != "checkbox" && $(this).attr("type") != "hidden"){
					$(this).val("");
				} else {
					$(this).prop("checked", false);
				}
			});
			$("#last_num").val(parseInt(nNum)+1);
			newForm.find("img").remove();
			newForm.find("#removeSpkr").click(function(){
				$(this).parent().remove();
			});
			$("#extraSpeakers").append(newForm.append($("		<br>")));
		}
	});
</script>

<div class='main'>
<style>
.inl p{
display:inline;
}
</style>
<?php
	if(isset($errors)){
		foreach($errors as $error){
			echo "<div class='error'>$error</div>";
		}
	}
	if(isset($success)){
		echo "<div class='success'>$success</div>";
	}

	if(!empty($surveyInfo)){
		if(empty($questions)){
			echo "<div class='error'>This survey has no questions</div>";
		} else {
			echo "<div class='survey'>";
			
			echo "<h2>" . TextSelector($surveyInfo[0]['name'], $surveyInfo[0]['name_fr']) . "</h2>";
			if(isset($login)){
				$loginBoxStr = "<form method='post' class='loginMenu'>";
				$loginBoxStr .= "<h2>Login</h2>";
				$loginBoxStr .= "<input type='text' class='form-control' name='email' placeholder='Email'><br>";
				$loginBoxStr .= "<input type='password' class='form-control' name='password' placeholder='Password'><br>";
				$loginBoxStr .= "<button type='submit' class='btn btn-primary' name='login'>Login</button>";
				$loginBoxStr .= "</form>";
				echo $loginBoxStr;
			}else{
				$surveyForm = "<form method='post' class='surveyForm'>";
				echo $surveyForm;
					echo "<table class='table table-striped'>";

					foreach($questions as $question){
//print_r($question);
						$label = html_entity_decode(TextSelector($question['title'], $question['title_fr']));
						$qid = $question['id'];
						
						$input = "";
						$rStr = "";
						$rGlyph = "";
						if($question['is_required'] == 1){
							$rStr = "required";
							$rGlyph = "<span class='glyphicon glyphicon-exclamation-sign'></span>";
						}
						//echo $rGlyph;
						echo "<tr><td class='inl'>$label $rGlyph </td></tr>";
						if($question['question_type'] == "radio"){
							$options = explode("||", $question['options']);
							$option_fr =  explode("||", $question['options_fr']);
							foreach($options as $k=>$o){
								$ofr = isset($option_fr[$k]) ? $option_fr[$k] : "";
								$input .= "<input type='radio' name='q_" . $question['id'] . "' value='" . TextSelector($o, $ofr) . "' $rStr><label>" . TextSelector($o, $ofr) . "</label>   ";
								if($question['alignment'] == "vertical"){
									$input .= "<br>";
								} 
							}	
						}
						if($question['question_type'] == "checkbox"){
							$options = explode("||", $question['options']);
							$option_fr =  explode("||", $question['options_fr']);
							foreach($options as $k=>$o){
								$ofr = isset($option_fr[$k]) ? $option_fr[$k] : "";
								$input .= "<input type='checkbox' name='q_" . $question['id'] . "[]' value='" .  TextSelector($o, $ofr)  . "' $rStr><label>" .  TextSelector($o, $ofr)  . "</label>    ";
								if($question['alignment'] == "vertical"){
									$input .= "<br>";
								} 
							}	
						}
						if($question['question_type'] == "textbox"){
								$input = "<input type='text' name='q_" . $question['id'] . "' class='form-control' $rStr>     ";
								if($question['alignment'] == "vertical"){
									$input .= "<br>";
								} 
						}
						if($question['question_type'] == "textarea"){
								$input = "<textarea ' name='q_" . $question['id'] . "' class='form-control' $rStr></textarea>    ";
								if($question['alignment'] == "vertical"){
									$input .= "<br>";
								} 
						}
						if($question['question_type'] == "rating"){
							//echo "Rating Question ";
							$max = $question['rating_points'];
							
							for($i = 1; $i <= $max; $i++){
								$input .= "<input type='radio' name='q_" . $question['id'] . "' value='$i' $rStr><label>$i</label>    ";
								if($question['alignment'] == "vertical"){
									$input .= "<br>";
								} 
							}
						}
						if($input != ""){
							echo "<tr><td>$input</td></tr>";
						} else {
							//echo "<tr><td>Input empty</td></tr>";
						}
						
					}
					echo "</table>";
					echo "<button type='submit' name='submit' class='btn btn-primary'>" . TextSelector("Submit", "Soumettre") . "</button>";
					echo "</form><br><br>";
			}	
		}
	}
?>
</div>
</div>
<script>
var validOptions = {
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
	      },
	      errorPlacement: function(error, element) {
	      	if(element.attr("type") == "radio" || element.attr("type") == "checkbox"){
	      	 	error.text("<?php echo TextSelector("You must choose an option", "Vous devez choisir l'une des options."); ?>");
	      	}else{
	      	  	error.text("<?php echo TextSelector('This field is required', 'Vous devez remplir ce champ.'); ?>");
	      	}
	      	
	      	error.appendTo(element.parent().parent().prev().find(".glyphicon-exclamation-sign"));
	      	
  		}
};

	$(".surveyForm").validate(validOptions);
</script>
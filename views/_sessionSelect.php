<div class='main'>
	<?php
	//success or fail
	if(isset($errors)){
		foreach($errors as $error){
			echo "<div class='error'>$error</div>";
		}
	}
	if(isset($success)){
		echo "<div class='success'>Your selections have been saved</div>";
	}
	?>
	<?php if(isset($regName) && $regName != ""): ?>
	<h2 class='form-signin-heading'>Session Selection for - <?php echo $regName; ?></h2>
	<p>Selected Option: <strong><?php echo $regOption['cost_level']; ?></strong></p>
	<?php endif; ?>
	<?php if(isset($onedayStr)): ?>
	<p><?php echo $onedayStr; ?></p>
	<?php endif; ?>
	<div>
		<?php if(!empty($sessions) && empty($errors)){
			echo "<form method='post' class='form'>";
			$t = 0;
			foreach($sessions as $day=>$sessionDay){
				$dayTable = "<table class='table dayTable'>";
				$dayDate = new DateTime($day);
				$dayStr = $dayDate->format("l jS F Y");
				$dayTable .= "<tr><td><strong>$dayStr</strong></td></tr>";
				$dayTable .= "</table>";
				echo $dayTable;
				$sessionTable = "<table class='table table-striped sessionTable' style='table-layout:fixed;'>";
				
				
				foreach($sessionDay as $time=>$rsessions){
					$t++;
					$timeStr = explode("_", $time);
					$timeStart = new DateTime($timeStr[0]);
					$timeEnd = new DateTime($timeStr[1]);
					$timeStart = $timeStart->format("g:i a");
					$timeEnd = $timeEnd->format("g:i a");
					$rowStr = "<tr><td colspan='1'>$timeStart - $timeEnd</td><td colspan='3'>";
					foreach($rsessions as $session){
						$sessionTitle = $session['session_title'];
						$sessionID = $session['session_id'];
						$sessionCode = $session['session_code'];
						$sessionSpeakers = isset($session['speakers']) ? $session['speakers'] : "";
						$containedSessions = isset($session['containedSessions']) ? $session['containedSessions'] : "";
						$scStr = "";
						$spkrStr = "";
						$scStr = "";
						if(!empty($sessionSpeakers)){
							$spkrStr = "<div class='session_speakers'><h4>Featuring: </h4>";
							foreach($sessionSpeakers as $spkr){
								$spkrName = $spkr['speaker_first_name'] . " " . $spkr['speaker_last_name'];
								$spkrTitle = $spkr['speaker_title'];
								$spkrCompany = $spkr['speaker_company'];
								$spkrBio = $spkr['speaker_bio'];
								$spkrStr .= "<div class='spkrInfo'><strong>$spkrName</strong><br><span>$spkrTitle, $spkrCompany</span><br>
											<span class='spkrBio'>$spkrBio</span></div><br>";
							}
							$spkrStr .= "</div>";
						}
						if($sessionCode != ""){
							$scStr = "$sessionCode : ";
						}
						$sessionDesc = html_entity_decode($session['session_description']);
						$sessionRoom = $session['roomName'];
						$sessionType = $session['session_type'];
						$sessionColor = $session['color'];
						$sessionWW =$session['workshop_weight'];
						$hiddenWW = "<input type='hidden' class='workshopweight' id='$sessionID' value='$sessionWW'>";
						$selectBox= "";
						$checked = "";
						$sessionInfoStr = $sessionDesc . " " . $spkrStr;
						if(!empty($containedSessions)){
							$containedStr = "<div class='contained_sessions'><h2>Grouped Session</h2>";
							foreach($containedSessions as $cSession){
								$cSpkrs = $cSession['speakers'];
								$cspStr = "";
								if(!empty($cSpkrs)){
									$cspStr = "<div class='session_speakers'><h4>Featuring: </h4>";
									foreach($cSpkrs as $spkr){
										$spkrName = $spkr['speaker_first_name'] . " " . $spkr['speaker_last_name'];
										$spkrTitle = $spkr['speaker_title'];
										$spkrCompany = $spkr['speaker_company'];
										$spkrBio = $spkr['speaker_bio'];
										$cspStr .= "<div class='spkrInfo'><strong>$spkrName</strong><br><span>$spkrTitle, $spkrCompany</span><br>
													<span class='spkrBio'>$spkrBio</span></div><br>";
									}
									$cspStr .= "</div>";
								}

								$csStr = "<div class='c_session' style='background-color:" . $cSession['color'] . ";'><h3>" . html_entity_decode($cSession['session_title']) . "</h3><p>" . html_entity_decode($cSession['session_description']) . "</p>$cspStr</div>";
								$containedStr .= $csStr;
							}
							$containedStr .= "</div>";
							$sessionInfoStr = $containedStr;
						}
						if(isset($selections)){
							foreach($selections as $sel){
								//echo "CHECK IF $sel[session_id] == $sessionID ";
								if($sel['session_id'] == $sessionID){
									$checked = "checked";
								}
							}
						}
						if($sessionType != "plenary"){
							if(count($rsessions) > 1){
								$selectBox =  "<input type='radio' id='$sessionID' class='selectSession' name='selectSession_$t' value='$sessionID' $checked>";
							} else{
								$selectBox =  "<input type='checkbox' id='$sessionID' class='selectSession' name='selectSession_$sessionID' value='$sessionID' $checked>";
							}
						}
						$showMore = "<span class='showMore' id='$sessionID'>Show Details</span> <span style='font-style:italic;'>$sessionRoom</span>";
						$sessionStr = "<div class='session' style='background-color:$sessionColor;'>$selectBox  $scStr $sessionTitle $showMore $hiddenWW</div>";
						$details = "<div id='details_$sessionID' class='sDetails' style='display:none;'>$sessionInfoStr </div>";
						$rowStr .= $sessionStr;
						$rowStr .= $details;
					}
					$rowStr .= "</td></tr>";
					$sessionTable .= $rowStr;
				}
				$sessionTable .= "</table>";
				echo $sessionTable;
			}
			echo "<button type='submit' class='btn btn-primary' name='saveSelections'>Submit</button>";
			echo "<form>";
		} else {
			echo "<div class='error'>Agenda is currently empty</div><br>";
		}
		?>
	</div><br>
	<button id='clearSel' class='btn btn-secondary' type='button'> Clear Selections </button>
</div>
<script>
	$(".showMore").click(function(){
		var id = $(this).attr("id");
		$("#details_" + id).slideToggle();
	});
	var workshopScore = <?php echo $regOption['workshop_score']; ?>;
	$("#clearSel").click(function(){
		$(".selectSession").each(function(){
			$(this).prop("checked", false);
			$(this).prop("disabled", false);
			
		});
	});

</script>
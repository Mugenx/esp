<div class='main'>
	<?php
	//success or fail
	if(isset($errors)){
		foreach($errors as $error){
			echo "<div class='error'>$error</div>";
		}
	}
	?>
	<a id='printReady'>Print ready agenda</a>
	<div id='theAgenda'>
		<h2 class='form-signin-heading'><?php if(isset($eventDetails)){ echo TextSelector($eventDetails['etitle'], $eventDetails['etitle_fr']); } ?> Agenda</h2>
		<div class='agenda_preamble'>
			<?php 
			if(isset($preamble) && $preamble != ""){
				echo htmlspecialchars_decode($preamble, ENT_QUOTES);
			} 
			?>
		</div>
		<div>
			<?php if(!empty($sessions)){
				$dCount = count($sessions);
				$dIndex = 0;
				foreach($sessions as $day=>$sessionDay){
					$dIndex++;
					$dayTable = "<table class='table table-striped dayTable'>";
					$dayDate = new DateTime($day);
					$dayStr = $dayDate->format("l F jS Y");
					$dayTable .= "<tr><td><h2>$dayStr</h2></td></tr>";
					$dayTable .= "</table>";
					echo $dayTable;
					$sessionTable = "<table class='table table-striped sessionTable' style='table-layout:fixed;'>";
					foreach($sessionDay as $time=>$rsessions){
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
							$sessionSpeakers = $session['speakers'];
							$containedSessions = $session['containedSessions'];
							$sessionType = $session['session_type'];

							$scStr = "";
							$spkrStr = "";
							$containedStr = "";
							if(!empty($sessionSpeakers)){
								$spkrStr = "<div class='session_speakers'><h4>Featuring: </h4>";
								$spkrStr2 = "<div class='session_speakers_$sessionID'><h4>". TextSelector("Featuring", "Animé par") . ": </h4>";
								foreach($sessionSpeakers as $spkr){
									$spkrName = $spkr['speaker_first_name'] . " " . $spkr['speaker_last_name'];
									$spkrTitle = $spkr['speaker_title'];
									$spkrCompany = $spkr['speaker_company'];
									$spkrBio = $spkr['speaker_bio'];
									$spkrStr .= "<div class='spkrInfo'><strong>$spkrName</strong><br><i><span>$spkrTitle,<br> $spkrCompany</span></i><br><br>
									<span class='spkrBio'>$spkrBio</span></div><br>";
									$spkrStr2 .= "<div class='spkrInfo'><strong>$spkrName</strong><br><span><i>$spkrTitle</i>, $spkrCompany</span>
								</div>";
							}
							$spkrStr .= "</div>";
						}
						if($sessionCode != ""){
							$scStr = "$sessionCode : ";
						}
						$sessionDesc = html_entity_decode($session['session_description']);
						$sessionRoom = $session['roomName'];
						$sessionColor = $session['color'];
						
						$sessionInfoStr ="<h4><strong>" .  $sessionTitle . "</strong></h4>" . $sessionDesc. " " . $spkrStr ;
						if($sessionType == "breakout"){
							if(empty($containedSessions)){
								$sessionInfoStr ="<h4><strong>" .  $sessionTitle . "</strong></h4><p>" . $sessionDesc . "</p><br/><p>" . $spkrStr . "</p>";
							}else{
								$sessionInfoStr ="<h4><strong>" .  $sessionTitle . "</strong></h4><p>" . $sessionDesc . " " .  $spkrStr . "</p>";
							}
						}
						$shortSpkr = '';
						if(!empty($containedSessions)){
							$containedStr = "<div class='contained_sessions'>";
							foreach($containedSessions as $cSession){
								$cSpkrs = $cSession['speakers'];
								
								$cspStr = "";
								if($sessionType != "breakout"){
									if(!empty($cSpkrs)){
										$cspStr = "<div class='session_speakers'><h4>Featuring: </h4>";
										$shortSpkr = "<div class='session_speakers'><h4>" . TextSelector("Featuring", "Animé par") . ": </h4>";
										foreach($cSpkrs as $spkr){
											$spkrName = $spkr['speaker_first_name'] . " " . $spkr['speaker_last_name'];
											$spkrTitle = $spkr['speaker_title'];
											$spkrCompany = $spkr['speaker_company'];
											$spkrBio = $spkr['speaker_bio'];
											$cspStr .= "<div class='spkrInfo'><strong>$spkrName</strong><br><span><i>$spkrTitle, $spkrCompany<i></span><br><br>
											<span class='spkrBio'>$spkrBio</span></div><br>";
											$shortSpkr .= "<div class='spkrInfo'><strong>$spkrName</strong><br><span>$spkrTitle, $spkrCompany</span></div><br>";
										}
										$cspStr .= "</div>";
									}
									$csStr = "<div class='c_session' id='$sessionType' style='background-color:" . $cSession['color'] . ";'><h4><strong>" . html_entity_decode($cSession['session_title']) . "</strong></h4><p>" . html_entity_decode($cSession['session_description']) . "</p>$cspStr</div>";
								}else{
									$cspStr = "<div class='session_speakers'><h4>Authors: </h4><div><strong>" . $cSession['authors'] . "</strong></div></div>";
									$csStr = "<div class='c_session' id='$sessionType' style='background-color:" . $cSession['color'] . ";'><h4><strong>" . html_entity_decode($cSession['session_title']) . "</strong></h4><p>$cspStr</p><br><p>" . html_entity_decode($cSession['session_description']) . "</p></div>";
								}
								
								$containedStr .= $csStr;
							}
							$containedStr .= "</div>";
							$sessionInfoStr .= $containedStr;
						}
						if($spkrStr != ""){
							$rightSpkr = "<div class='extraSpkrString spkrs_$sessionID'> $spkrStr2 </div>";
						} else {
							$rightSpkr =  "<div class='extraSpkrString  spkrs_$sessionID'> $shortSpkr </div>";
						}
						$showMore = "<span class='showMore' id='$sessionID'>Show Details</span> <strong><span style='font-style:italic;'>$sessionRoom</span></strong>";
						if($sessionType != "" && $sessionType != "none"){
							if($sessionType == "plenary"){
								$sessionStr = "<div class='session' style='background-color:$sessionColor;'>$scStr $sessionTitle $showMore <br> $rightSpkr <br></div>";
							}else{
								$sessionStr = "<div class='session' style='background-color:$sessionColor;'>$scStr $sessionTitle $showMore</div>";
							}
							
						} else {
							$sessionStr = "<div class='session' style='background-color:$sessionColor;'>$scStr $sessionTitle </div>";
						}
						$details = "<div id='details_$sessionID' class='sDetails' style='display:none;'>$sessionInfoStr</div></div>";
						$rowStr .= $sessionStr;
						$rowStr .= $details;
					}
					$rowStr .= "</td></tr>";
					$sessionTable .= $rowStr;
				}
				$sessionTable .= "</table>";
				echo $sessionTable;
				if($dIndex != $dCount){
					echo "<div class='page-break'></div>";
				}
			}
		} else {
			echo "<div class='error'>Agenda is currently empty</div><br>";
		}
		?>
	</div>
</div>
</div>
<script>
	$(".showMore").click(function(){
		var id = $(this).attr("id");
		$("#details_" + id).slideToggle();
		$("#details_" + id).parent().find(".extraSpkrString").slideToggle();
	});
	$("#printReady").click(function(){
		var w = window.open();
		var printButton = $("<button type='button' class='dontPrint' onClick='window.print()'>Print</button>");
		var agendaPage = $("#theAgenda").clone();
		agendaPage.find(".sDetails").show();
		agendaPage.find(".dontPrint").remove();
		agendaPage.find(".sessTime").css("vertical-align", "top");
		agendaPage.find(".session").css("background-color", "transparent");
		agendaPage.find("table").css("width", "100%");
		agendaPage.find(".sessionTable").find("td").css("border","1px solid rgba(0, 0, 0, 0.35)").css("padding","10px");
		agendaPage.prepend(printButton);
		var html = "<div style='width: 100%; margin: 0 auto;'>" + agendaPage.html() + "</div>";
		var cssLink = $("<link rel='stylesheet' type='text/css' href='<?php echo THESITE; ?>/css/cms.css'>");
		$(w.document.head).append(cssLink); 
		$(w.document.body).html(html);
	});
</script>
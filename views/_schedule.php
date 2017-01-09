<div class='main'>
	<?php
	//success or fail
	if(isset($errors)){
		foreach($errors as $error){
			echo "<div class='error'>$error</div>";
		}
	}
	?>
	<?php if(isset($login) && $login == true): ?>
		<form method='post' class='loginMenu'>
			<h2>Login</h2>
			<input type='text' class='form-control' name='email' placeholder='Email'><br>
			<input type='password' class='form-control' name='password' placeholder='Password'><br>
			<button type='submit' class='btn btn-primary' name='login'>Login</button>
		</form>
	<?php elseif(isset($first_login)): ?>
		<form method='post' class='loginMenu'>
			<h2>Set a new password</h2>
			<input type='password' class='form-control' name='oldpass' placeholder='Current password'><br>
			<input type='password' class='form-control' name='newpass' placeholder='New password'><br>
			<input type='password' class='form-control' name='confirmpass' placeholder='Confirm new password'><br>
			<button type='submit' class='btn btn-primary' name='setPass'>Set new password</button>
			<div class='note'>You will have to log back in with your new password after this process is complete.</div>
		</form>
	<?php else: ?>
		<h2 class='form-signin-heading'>My Schedule</h2>
		<div class='usrMenu'>
			<ul>
			<?php if($regInfo[0]['is_group_leader'] == 1): ?>
				<li><a href='invoice/<?php echo $regInfo[0]['reguniqid']; ?>' target='_blank'>My Invoice</a></li>
			<?php endif; ?>
				<li><a href='_sessionSelect/<?php echo $regInfo[0]['reguniqid']; ?>' target='_blank'>Modify Session Selections</a></li>
				<!-- <li><a href='_workshopSelect/<?php echo $regInfo[0]['reguniqid']; ?>' target='_blank'>Modify Workshop Selections</a></li> -->
			</ul> 
			<form method='post'><button type='submit' name='logout' class='btn btn-secondary'>Log out</button></form>
		</div>
	<div>
		<?php if(!empty($sessions)){
			foreach($sessions as $day=>$sessionDay){
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
						$scStr = "";
						$spkrStr = "";
						$containedStr = "";
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
						$sessionColor = $session['color'];
						$sessionInfoStr ="<h4><strong>" .  $sessionTitle . "</strong></h4>" . $sessionDesc . " " . $spkrStr;
						if(!empty($containedSessions)){
							$containedStr = "<div class='contained_sessions'>";
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

								$csStr = "<div class='c_session' style='background-color:" . $cSession['color'] . ";'><h4><strong>" . html_entity_decode($cSession['session_title']) . "</strong></h4><p>" . html_entity_decode($cSession['session_description']) . "</p>$cspStr</div>";
								$containedStr .= $csStr;
							}
							$containedStr .= "</div>";
							$sessionInfoStr .= $containedStr;
						}
						
						$showMore = "<span class='showMore' id='$sessionID'>Show Details</span> <span style='font-style:italic;'>$sessionRoom</span>";
						$sessionStr = "<div class='session' style='background-color:$sessionColor;'>$scStr $sessionTitle $showMore</div>";
						$details = "<div id='details_$sessionID' class='sDetails' style='display:none;'>$sessionInfoStr</div>";
						$rowStr .= $sessionStr;
						$rowStr .= $details;
					}
					$rowStr .= "</td></tr>";
					$sessionTable .= $rowStr;
				}
				$sessionTable .= "</table>";
				echo $sessionTable;
			}
		} else {
			echo "<div class='error'>You haven't made any session or workshop selections.</div><br>";
		}
		?>
	</div>
	<?php endif; ?>
</div>
<script>
	$(".showMore").click(function(){
		var id = $(this).attr("id");
		$("#details_" + id).slideToggle();
	});
</script>
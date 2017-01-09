<?php 
			$titleSplit = explode(" ", $eventDetails['etitle']);
			$dateStart = explode("-", $eventDetails['start_date']);
			$dateEnd = explode("-", $eventDetails['end_date']);
			$dateString = "";
			
			if($dateStart[1] == $dateEnd[1]){
				$dateObj   = DateTime::createFromFormat('!m', $dateEnd[1]);
				$monthName = $dateObj->format('F'); 
				$dateString = $monthName . " " . $dateStart[2] . " - " . $dateEnd[2] . ", " . $dateEnd[0] ;
			} else {
				$startMonthName = DateTime::createFromFormat('!m', $dateStart[1])->format('F');
				$endMonthName = DateTime::createFromFormat('!m', $dateEnd[1])->format('F');
				$dateString = $startMonthName . " " . $dateStart[2] . " - " . $endMonthName . " " . $dateEnd[2] . ", " . $dateEnd[0] ;
			}
			$locationString = $eventDetails['location'];
			$infoString = $dateString . " | " . $locationString;
			$description = $eventDetails['edescription'];
		
		 ?>

		<div class="cfpSubmit">
			<?php
				if(isset($scans)){
					foreach($scans as $k=>$scan){
						$nScan = json_decode($scan['scan'], true);
						$id = $nScan['data_id'];
						$rest_ip = $nScan['rest_ip'];
						$tmpName = $scan['tmpName'];
						$rName = $scan['rName'];
						$uid = $scan['uid'];
						$qCode = $scan['qCode'];
						echo "<input type='hidden' class='scanF' value='$id' id='$rest_ip'>";
						echo "<input type='hidden' id='tmp_$id' value='$tmpName'>";
						echo "<input type='hidden' id='name_$id' value='$rName'>";
						echo "<input type='hidden' id='uid_$id' class='UIDS' value='$uid'>";
						echo "<input type='hidden' id='qcode_$id' class='QCODE' value='$qCode'>";
						echo "<div class='imgScan' id='sc_$id'>";
						echo "<h4  id='loading_$id'>Scanning your image </h4>";
						echo "<p id='details_$id'></p>";
						echo "</div>";
					}
				}
			?>
		
			<?php if(isset($errors) && !empty($errors)){
				foreach($errors as $error){
					echo "<label class='danger error'>$error</label><br>";
				}
				echo "<button onclick='history.go(-1);'>Back </button>";
			}
			if(isset($confContent)){
				echo "<div>" . utf8_encode($confContent) . "</div>";
			}
			
			if(isset($success) && !empty($success)){
				foreach($success as $msg){
					echo "<label class='success'>$msg</label><br>";
				}
			}
			?>
		</div>
		
		<script>
			$(document).ready(function(){
				var uploads = [];
				var count = 0;
				$(".scanF").each(function(i, el){
					count++;
					var id = $(this).val();
					var rIP = $(this).attr("id");
					var tmpName = $("#tmp_" + id).val();
					var rName = $("#name_" + id).val();
					var uid = $("#uid_" + id).val();
					var qCode = $("#qcode_" + id).val();
					
					var container = $("#sc_" + id);
					var t = ".";
					var timer = setInterval(function(){
					
					$("#loading_" + id).html("Scanning in progress for image " + rName+ t);
					t += ".";
					if(t.length >= 4){
						t = ".";
					}
					var xhr = new XMLHttpRequest()
					xhr.open("GET",  "https://" + rIP + "/file/" + id, true);
					xhr.setRequestHeader("apiKey", "0180a46880edc556d14a0f5b9937d568");
					xhr.onprogress = function () {
					  console.log("PROGRESS:", xhr.responseText);
					  var response = xhr.responseText;
					  response =JSON.parse(response);
					  if(response['scan_results']['in_queue'] != 0){
				  			details = "This file [" + rName + "] is in queue for scanning, current position: " + response['scan_results']['in_queue'];
				  			$("#details_"+id).html(details);
				  	}
					  if(response['scan_results']['progress_percentage'] == 100){
					  	//console.log("Scan end!");
					  	$("#loading_" + id).html("Scanning is finished!");
					  	var details = "";
					  	var upload = false;
					  	switch(response['scan_results'].scan_all_result_i){
					  		case 0:
					  			details = "File [" + rName + "] is clean and is being uploaded";
					  			container.css("background-color", "#59F859");
					  			upload = true;
					  			break;
					  		case 1:
					  			details = "This file [" + rName + "] contains a threat and it has been rejected, you can try again by editing your submission";
					  			break;
					  		case 2:
					  			details = "This file ["+ rName +"] is suspicious and has been rejected, you can try again by editing your submission";
					  			break;
					  		case 3:
					  			details = "Failed to scan file [" + rName +"], please try again in about an hour by editing your submission";
					  			break;
					  		case 7:
					  			details = "Scan is skipped because this file [" + rName + "] is on the white-list";
					  			break;
					  		case 8:
					  			details = "Scan is skipped because this file ["+ rName + "] is on the black-list and has been rejected, , you can try again by editing your submission";
					  			break;
					  		case 10:
					  			details = "This file [" + rName + "] wasn't scanned because the AV engine is currently being updated or maintainted";
					  			break;
					  		case 11:
					  			details = "All scans  were aborted";
					  			break;
					  	}
					  	console.log(response['scan_results']['in_queue']);
					  	
					  	if(upload){
					  		$.ajax({
					  			url: "<?php echo THESITE; ?>/<?php echo $eventDetails['directory_name']; ?>/uploadFile",
					  			data: {tmpName: tmpName, name: rName, uid: uid, qCode: qCode, eid: <?php echo $eventDetails['event_id']; ?>},
					  			type: "POST",
					  			success: function(result){
					  				console.log("Uploaded!");
					  				console.log(result);
					  				details = "File [" + rName + "] is clean and is uploaded: <a href='" + result + "' target='_blank'> View it here </a>";
					  				$("#details_"+id).html(details);
					  			}
					  		});
					  		
					  	}else{
					  		$.ajax({
					  			url: "<?php echo THESITE; ?>/<?php echo $eventDetails['directory_name']; ?>/removeFile",
					  			data: {name: rName},
					  			type: "POST",
					  			success: function(result){
					  				console.log("Removed!");
					  				console.log(result);
					  			}
					  		});
					  	}
					  	$("#details_"+id).html(details);
					  	clearInterval(timer);
					  }
					}
					xhr.send();
					
					}, 1500);
				});
				
			});
			
			
		</script>
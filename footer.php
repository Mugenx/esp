<?php
// FileName:     footer-template.txt
// Author:       EventSystemPro
// Copyright:    © EVENTSYSTEMPRO 2016. ALL RIGHTS RESERVED.
// Web Version:  3.0000
// Date:         11/7/2016
?>

<div  style="margin-top:50px; background-color: transparent">
	<p align="center" style="margin: 50px 0; color: #003366;">&copy; <?php echo date("Y"); ?> EventSystemPro. All Rights Reserved. <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
	
	
<!-- customize js -->
    <script type="text/javascript" src="js/ani.js"></script>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<?php
	if(isset($googleAnalytics)){
		echo $googleAnalytics;
	} //end of if
?>
</body>
</html>
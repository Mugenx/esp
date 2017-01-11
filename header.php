<?php
// FileName:     header.php
// Author:       EventSystemPro
// Copyright:    © EVENTSYSTEMPRO 2016. ALL RIGHTS RESERVED.
// Web Version:  3.0000
// Date:         12/5/2016
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<base href="<?php echo THESITE; ?>" />
	<title><?php echo ucwords($title); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap core CSS -->
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<!-- Custom styles for this template -->
	<link href="css/customResponsiveStyle.css" rel="stylesheet">
	<link href="css/esp_site.css" rel="stylesheet">
	<link href="css/verneyHome.css" rel="stylesheet">  
	<!-- Respond.js proxy on external server -->
	<!-- <link href="http://externalcdn.com/respond-proxy.html" id="respond-proxy" rel="respond-proxy" /> -->
	<link rel="stylesheet" href="css/datepicker.css">
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="https://code.jquery.com/jquery-2.2.0.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="js/ie10-viewport-bug-workaround.js"></script>
	<script src="js/jquery.validate.js"></script>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<?php
	echo TextSelector("	<script src='https://www.google.com/recaptcha/api.js?hl=en'></script>","	<script src='https://www.google.com/recaptcha/api.js?hl=fr'></script>");
	?>
	<meta name="revision" content="3.0000" />
	<meta name="date" content="11/07/2016" />
	<meta name="expires" content="Mon, 1 Jan 1996 01:00:00 GMT" />
	<meta name="copyright" content="© EventSystemPro <?php echo date('Y'); ?>. All Rights Reserved." />
	<meta name="keywords" content="" />
	<meta name="description" content="<?php if (isset($description)) { echo ucwords($description); } ?>" />
	<meta name="author" content="EventSystemPro" />

	<style type="text/css">
		.navbar {
			border: 0;
			background-color: #003366;
		}

		.navbar .navbar-nav {
			display: inline-block;
			float: none;
			vertical-align: top;
		}

		.navbar .navbar-collapse {
			text-align: center;
			background-color: #003366;
		}
		.nav > li > a {
			color: white;
			font-size: 15px;
			text-decoration-line: none;
		}
	</style>
</head>
<?php 
$lang = isset($_GET['lang']) ? $_GET['lang'] : "en";
function TextSelector($txt_en, $txt_fr) {
	global $lang; 
	if ($lang == "fr") {
		return $txt_fr;
	}
	return $txt_en;
}
?>
<?php
if(strstr($_SERVER['HTTP_USER_AGENT'],'iPad')) { 
	echo "<body id=\"bodyEl iPad\">\n";
} else { 
	echo "<body id=\"bodyEl\">\n";
}
?>
<!-- header img-->
<div class="container-fluid" style="background-color:#f3f8fc;color:#fff; padding:0;
margin-bottom: -10px" >
<div style="background: linear-gradient(to right, rgba(0,51,102,0.5),rgba(250,250,250,1),rgba(250,250,250,1),rgba(250,250,250,1),rgba(0,51,102,0.5)" align="center" >
	<a href="index.php"><img src="img/ESP-Logo.png" style="width: 55vmin; padding:25px 0 0"></a>
	<p style="color: #003366; padding: 0 0 15px; font-size: 3vmin; font-family:times new roman; font-style: italic;">
		National Strategic Partner of the Canadian Society of Professional Event
		Planners
	</p>
</div>
</div><!-- end of header img-->



<!-- Static navbar -->
<div class="navbar" data-spy="affix" data-offset-top="500" align="center" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="sr-only">Menu</span></button>
		</div>
		<div class="navbar-collapse collapse">
			<?php 
			$curLink = $_GET['url'];
			$nLang = "en";
			$nLangStr = "English";
			if($lang == "en") {
				$nLang = "fr";
				$nLangStr = "Français";
			}
			?>
			<?php if(!isset($navPages) || empty($navPages)): ?>
				<ul class="nav navbar-nav navbar-right">
					<li <?php if($_SERVER['REQUEST_URI'] == "/esphome/index"){ echo "class=\"active\""; } ?>><a href="esphome/index/&lang=<?php echo $lang; ?>" title="Home">Home</a></li>
					<li <?php if($_SERVER['REQUEST_URI'] == "/esphome/reginfo"){ echo "class=\"active\""; } ?>><a href="esphome/registration/&lang=<?php echo $lang; ?>" title="Registration">Registration</a></li>
					<li <?php if($_SERVER['REQUEST_URI'] == "/esphome/contact"){ echo "class=\"active\""; } ?>><a href="esphome/contact/&lang=<?php echo $lang; ?>" title="Contact">Contact Us</a></li>
					<li <?php if($_SERVER['REQUEST_URI'] == "/esphome/agenda"){ echo "class=\"active\""; } ?>><a href="esphome/_agenda/&lang=<?php echo $lang; ?>" title="Agenda">Agenda</a></li>
					<li <?php if($_SERVER['REQUEST_URI'] == "/esphome/_schedule"){ echo "class=\"active\""; } ?>><a href="esphome/_schedule/&lang=<?php echo $lang; ?>" title="Schedule">My Schedule</a></li>
					<li><a href="<?php echo $curLink; ?>&lang=<?php echo $nLang; ?>"><?php echo $nLangStr; ?></a></li>
				</ul>
			<?php else: ?>
				<?php
				echo "				<ul class='nav navbar-nav' style='margin-top:10px;'>\n";
				foreach($navPages as $page) {
					$active = "";
					$phpless = str_replace(".php", "", $page['webpage_filename']);
					$ur = "/esphome/".$phpless."/&lang=".$lang;
					if ($_SERVER['REQUEST_URI'] == $ur) {
						$active = " class=\"active\"";
		} //end of if
		echo "					<li".$active."><a href=\"$ur\">".TextSelector($page['name'], $page['name_fr'])."</a></li>\n";
	} //end of foreach
	// echo "				</ul>\n";
	// echo "				<ul class=\"nav navbar-nav navbar-right\">\n";
	// echo "					<li><a href=\"$curLink&lang=$nLang\">".$nLangStr."</a></li>\n";
	// echo "				</ul>\n";
	?>
<?php endif; ?>
</div><!--/nav-collapse -->
</div><!--/container-fluid -->
</div><!--/navbar navbar-responsive -->

	<!-- <div class="mainBlock">
	<div class="container mainContainer"> -->

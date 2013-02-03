<!DOCTYPE html>
<html>
<head>
	<title>ROBLOX Forum</title>
	<?php include("../../../includes/defaultMobile.php"); ?>
	<script type="text/javascript" src = "includes/ga_tracking.js"></script>
</head>
<body>
<div data-role="page">
	<!--Header-->
	<?php
	$title = "ROBLOX Forums";
	include("includes/header.php");
	?>
	<!--/Header-->
	<!--Body-->
	<div data-role="content">
		<!--Forum list-->
		<ul data-role="listview">
			<!--Intro-->
			<li>
				<h1>Welcome</h1>
				<p>Welcome to the mobile version of the ROBLOX forums! This website was developed
				by the ROBLOX users <a href = "http://m.roblox.com/users/3576139" target = '_blank'>Techboy6601</a>,
				<a href = "http://m.roblox.com/users/921458" target = '_blank'>NXTBoy</a>, and
				<a href = "http://m.roblox.com/users/25614845" target = '_blank'>Garnished</a>. Please note
				that it is still in development and not everything works. Enjoy!</p>
			</li>
			<!--/Intro-->
			<?php include("forums.html"); ?>
		</ul>
		<!--/Forum list-->
		<br><br>
		&copy; 2013 Deplex Studios &bull; <a href = "thread88375831">Changelog</a>
	</div>
	<!--/Body -->
</div>
</body>
</html>

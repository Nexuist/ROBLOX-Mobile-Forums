<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = (int) $_GET['id'];

	$forum = simplexml_load_file('forums.xml')->xpath("//forum[@id='$id']");
	if ($forum) {
		$name = $forum[0]->name;
		$desc = $forum[0]->desc;
	}

	if (isset($_GET['page']) && is_numeric($_GET['page'])) {
		$pageNum = $_GET['page'];
	}
	else {
		$pageNum = 1;
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $name; ?></title>
	<?php include("../../../includes/defaultMobile.php"); ?>
	<script type="text/javascript" src = "includes/ga_tracking.js"></script>
</head>
<body>
<div data-role="page">
	<!--Header-->
	<?php
	$title = $name;
	include("includes/header.php");
	?>
	<!--/Header-->
	<!--Body-->
	<div data-role="content">
		<?php if ($name != "") {?>
		<!--Threads-->
		<ul data-role="listview">
			<!--Intro -->
			<li><h3><?php echo $name; ?></h3><p><?php echo $desc; ?></p></li>
			<!--/Intro-->
			<li data-role = "list-divider">Threads</li>
			<?php include("parsers/threadListParser.php"); ?>
		</ul>
		<?php include('includes/paginationFooter.php'); ?>
		<!--/Threads-->
		<?php
		}
		else
		{
			echo "<h3>Error</h3><p>The requested forum was not found.";
		}
		?>
	</div>
	<!--/Body -->
</div>
</body>
</html>
<?php } ?>

<?php
require_once 'parsers/threadParser.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	$id = $_GET['id'];
	if (isset($_GET['page']) && is_numeric($_GET['page'])) {
		$pageNum = $_GET['page'];
	}
	else {$pageNum = 1;}

	$thread = new Thread();
	$thread->id = $id;
	$thread->pageNum = $pageNum;

?>
<!DOCTYPE html>
<html>
<head>
	<title>ROBLOX Forums</title>
	<?php include("../../../includes/defaultMobile.php"); ?>
	<script type="text/javascript" src = "includes/ga_tracking.js"></script>
</head>
<body>
<div data-role="page" data-add-back-btn="true">
	<!--Header-->
	<?php
	$title = "ROBLOX Forums";
	include("includes/header.php");
	?>
	<!--/Header-->
	<!--Body-->
	<div data-role="content">
		<a href='<?= htmlspecialchars($thread->url) ?>' target='_blank' data-role='button'>
			Show Original
		</a>
		<br>
		<ul data-role="listview">
		<?php 
		// Loop through the posts
		foreach($thread->posts as $post):
			include 'templates/post.php';
		endforeach ?>
		</ul>
	</div>
	<?php include("includes/paginationFooter.php"); ?>
	<!--/Body -->
</div>
</body>
</html>
<?php
}
?>

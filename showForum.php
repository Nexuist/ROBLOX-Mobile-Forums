<?php
require_once "templates/page.php";
require_once 'parsers/threadParser.php';


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
}
if($name) {
	templatePage('$name | ROBLOX Forums', function() {
		global $name, $desc, $id, $pageNum, $page;
?>
		<!--Threads-->
		<ul data-role="listview">
			<!--Intro -->
			<li><h3><?php echo $name; ?></h3><p><?php echo $desc; ?></p></li>
			<!--/Intro-->
			<li data-role = "list-divider">Threads</li>
			<?php include("parsers/threadListParser.php"); ?>
		</ul>
		<!--/Threads-->
<?php
	}, function() {
		global $name, $desc, $id, $pageNum, $page;
		include('includes/paginationFooter.php');
	});
}
else {
	templatePage('Error | ROBLOX Forums', function() {
?>
		<h3>Error</h3><p>The requested forum was not found.
<?php
	});
}
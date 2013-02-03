<?php
require_once "templates/page.php";
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

	templatePage("$name | ROBLOX Forums", function() {
		global $thread;
		global $name, $desc, $id, $pageNum, $page;
	?>
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
<?php
	}, function() {
		global $name, $desc, $id, $pageNum, $page;
		include('includes/paginationFooter.php');
	});
}
?>

<?php
require_once "templates/page.php";
require_once 'parsers/threadParser.php';
require_once "parsers/threadListParser.php";

try {
	if (isset($_GET['id']) && is_numeric($_GET['id'])) {
		$id = (int) $_GET['id'];

		$forum = Forum::byId($id);

		if (isset($_GET['page']) && is_numeric($_GET['page'])) {
			$forum->pageNum = $_GET['page'];
		}
	}
	else throw new NoSuchForumException();

	templatePage($forum->name.' | ROBLOX Forums', function() use ($forum) { ?>
		<!--Threads-->
		<ul data-role="listview">
			<!--Intro -->
			<li><h3><?php echo $forum->name; ?></h3><p><?php echo $forum->desc; ?></p></li>
			<!--/Intro-->
			<li data-role = "list-divider">Threads</li>
			<?php foreach($forum->threads as $thread): ?>
				<?php if($thread->pinned): ?><li data-icon='star'><?php else: ?><li><?php endif ?>
				<a href="thread<?= $thread->id ?>">
					<h3 style='white-space: normal'><?= $thread->title ?></h3>
					<p>
						<font color='#2489CE'><?= $thread->author->name ?></font>
						<b><?= $thread->replies ?></b> Replies
						<b><?= $thread->views ?></b> Views
						<b><?= $thread->lastPoster ?></b>
				<?php if($thread->totalPages != 1): ?>
						<div class='ui-li-count'><?= $thread->totalPages ?></div>
				<?php endif ?>
					</p>
				</a>
			</li>
			<?php endforeach ?>
		</ul>
		<!--/Threads-->
	<?php });
}
catch(NoSuchForumException $e) {
	templatePage("404 | ROBLOX Forums", function() use ($e, $id) { ?>
		<p><strong>Error:</strong> Forum #<?= $id ?> not found</p>
	<?php });
}
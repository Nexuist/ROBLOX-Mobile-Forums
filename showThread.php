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

	try {

		templatePage($thread->posts[0]->title." | ROBLOX Forums", function() use ($thread) { ?>
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
		<?php }, $thread->totalPages > 1 ? function() use ($thread) { ?>
			<div style = "text-align: center;" data-role="controlgroup" data-type="horizontal">
			<?php if ($thread->pageNum != 1): ?>
				<a href='?page=<?= $thread->pageNum - 1 ?>'
				   data-theme='e' data-role='button' data-icon='arrow-l' data-iconpos='notext'>Previous</a>
			<?php endif ?>
				<a href='#' data-role='button' data-theme='c'><?= $thread->pageNum ?> of <?= $thread->totalPages?></a>
			<?php if ($thread->pageNum != $thread->totalPages): ?>
				<a href='?page=<?= $thread->pageNum + 1 ?>'
				   data-theme='e' data-role='button' data-icon='arrow-r' data-iconpos='notext'>Next</a>
			<?php endif ?>
			</div>
		<?php } : NULL, function() use ($thread) {
			foreach($thread->authors as $a) { ?>
			<div data-role="panel" id="author-<?= $a->name ?>">
				<p>
					<img src='<?= htmlentities($a->img) ?>' alt='<?= $a->name ?>' /><br>
					Joined <b><?= $a->joinDate ?></b><br>
					Total Posts <b><?= $a->postCount ?></b><br>
		<?php if($a->groupInfo): ?>
					Primary Group <a href="<?= htmlentities($a->groupInfo->group->url) ?>" target='_blank'><?= $a->groupInfo->group->name ?></a><br>
		<?php endif ?>
					<a href='<?= htmlentities($a->url) ?>' target='_blank'>View Profile &#187;</a>
				</p>
			</div><!-- /panel -->
			<?php }
		});
	}
	catch(RobloxForumError $e) {
		templatePage("404 | ROBLOX Forums", function() use ($e) { ?>
			<h3><?= $e->title ?></h3>
			<p><?= $e->description ?></p>
		<?php });
	}
	catch(NoSuchThreadException $e) {
		templatePage("404 | ROBLOX Forums", function() use ($e) { ?>
			<p><strong>Error:</strong> Thread not found</p>
		<?php });
	}
	catch(ThreadParseException $e) {
		templatePage("404 | ROBLOX Forums", function() use ($e) { ?>
			<p><strong>Error:</strong> Could not parse the requested thread - perhaps the site has updated?</p>
		<?php });
	}
}
?>

<?php if($pinned): ?><li data-icon='star'><?php else: ?><li><?php endif ?>
	<a href="thread-<?= $threadId ?>">
		<h3 style='white-space: normal'><?= $title ?></h3>
		<p>
			<font color='#2489CE'><?= $author ?></font>
			<b><?= $replies ?></b> Replies
			<b><?= $views ?></b> Views
			<b><?= $lastPoster ?></b>
<?php if($pages != 1): ?>
			<div class='ui-li-count'><?= $pages ?></div>
<?php endif ?>
		</p>
	</a>
</li>
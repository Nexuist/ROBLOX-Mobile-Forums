<!--Author panel-->
<div data-role = "panel" id = "author-<?=$a->name?>">
	<p>
		<img src = "<?=htmlentities($a->img)?>" alt = "<?=$a->name?>"/><br>
		<ul data-role = "listview" data-inset = "true" data-theme = "d">
			<li><a href = "<?= htmlentities($a->getUrl()) ?>" target = "_blank"><?=$a->name?></a></li>
	<?php if($a->isMod): ?>
			<li><img src = "includes/mod.gif" class = "ui-li-icon" alt = "Moderator" />Moderator</li>
	<?php endif ?>
			<li>Joined <?= $a->prettifyJoinDate() ?></li>
			<li><?=$a->postCount?> Posts</li>
		</ul>
	<?php if($a->groupInfo): ?>
		<ul data-role = "listview" data-inset = "true" data-theme = "d">
			<li><a href="<?= htmlentities($a->groupInfo->group->url) ?>" target='_blank'><?= $a->groupInfo->group->name ?></a></li>
			<li><?=$a->groupInfo->role->name?></li>
		</ul>
	<?php endif ?>	
	</p>
</div>
<!--/Author panel-->
<!--Author panel-->
<div data-role = "panel" id = "author-<?=$a->name?>">
	<p>
		<img src = "<?=htmlentities($a->img)?>" alt = "<?=$a->name?>"/><br>
		<ul data-role = "listview" data-inset = "true" data-theme = "d">
			<li><a href = "<?= htmlentities($a->getUrl()) ?>" target = "_blank"><?=$a->name?></a></li>
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

<!--
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
			</div>
-->
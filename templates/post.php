			<li data-role='list-divider'><?= $post->title ?> <p class="ui-li-aside"><?= $post->date ?></li>
			<li data-theme='d'>
				<div data-content-theme="d" data-role='collapsible' data-iconpos='right' data-mini='true'>
					<h5>
			<?php if($post->author->isMod): ?>
						<img src='includes/mod.gif' alt='MOD' />
			<?php endif ?>
						<font color='<?php if($post->author->online): ?>green<?php else: ?>red<?php endif ?>'>
							<?= $post->author->name ?>

						</font>
					</h5>
					<p>
						<img src='<?= htmlentities($post->author->img) ?>' alt='<?= $post->author->name ?>' /><br>
						Joined <b><?= $post->author->joinDate ?></b><br>
						Total Posts <b><?= $post->author->postCount ?></b><br>
			<?php if($post->author->groupInfo): ?>
						Primary Group <a href="<?= htmlentities($post->author->groupInfo->group->url) ?>" target='_blank'><?= $post->author->groupInfo->group->name ?></a><br>
			<?php endif ?>
						<a href='<?= htmlentities($post->author->url) ?>' target='_blank'>View Profile &#187;</a>
					</p>
				</div>
				<br>
				<p style='word-break: break-all;'>
					<?= $post->content ?>
				</p>
			</li>
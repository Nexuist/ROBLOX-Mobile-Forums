			<? if($post->titleIsOriginal): ?>
			<li data-role='list-divider'><?= $post->title ?></li>
			<? endif ?>
			<li data-theme='d' class="post" data-role="none">
				<div>
					<!--<div data-content-theme="b" data-theme="c" data-role='collapsible' data-iconpos='right' data-mini='true'>
						<h5>
				<?php if($post->author->isMod): ?>
							<img src='includes/mod.gif' alt='MOD' />
				<?php endif ?>
							<img src='includes/<?php if($post->author->online): ?>online<?php else: ?>offline<?php endif ?>.png'>
							<?= $post->author->name ?>
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
					<br>-->
					<div class="post-info">
						<a data-role="none" class="author-avatar"  href="#author-<?= $post->author->name ?>">
							<img
								data-role="none" width="48" height="48"
								src='<?= htmlentities($post->author->smallImg) ?>'
								alt='<?= $post->author->name ?>' />
						</a>
						<a href="#author-<?= $post->author->name ?>"><?= $post->author->name ?></a>
						<?php if($post->author->online): ?>
						&bull; <span class="author-status">online</span>
						<?php endif ?>
						<span class="post-date"><?= implode('<br />', $post->wrappedDate) ?></span>
					</div>
					<div class="post-content">
						<?= $post->content ?>
					</div>
				</div>
			</li>
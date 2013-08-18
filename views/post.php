			<? if($post->titleIsOriginal): ?>
			<li data-role='list-divider'><?= $post->title ?></li>
			<? endif ?>
			<li data-theme='d' class="post" data-role="none">
				<div class="post-wrapper"><!-- needed to stop this getting mobilified -->
					<div class="post-info">
						<a data-role="none" class="author-avatar"  href="#author-<?= $post->author->name ?>">
							<img
								data-role="none" width="48" height="48"
								src='<?= htmlentities($post->author->smallImg) ?>'
								alt='<?= $post->author->name ?>' />
						</a>
					<?php if($post->author->isMod): ?>
						<img src='includes/mod.gif' alt='MOD' class="mod-icon" />
					<?php endif ?>
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
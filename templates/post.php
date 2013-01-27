<li data-role='list-divider'><?= $postTopic ?></li>
<li data-theme='d'>
    <div data-role='collapsible' data-icon='delete' data-mini='true'>
        <h5>
<?php if($isMod): ?>
            <img src='includes/mod.gif' alt='MOD' />
<?php endif ?>
<?php if($isOnline): ?>
            <font color='green'><?= $authorName ?></font>
<?php else: ?>
            <font color='red'><?= $authorName ?></font>
<?php endif ?>
        </h5>
        <p>
            <img src='<?= $authorImg ?>' alt='<?= $authorName ?>' /><br>
            Joined <b><?= $authorDate ?></b><br>
            Total Posts <b><?= $authorPosts ?></b><br>
            <a href='<?= $authorURL ?>' target='_blank'>View Profile &#187;</a>
        </p>
    </div>
    <p style='word-break: break-all;'>
        <?= $postContents ?><br><br>
        <b>Posted</b> <?= $postDate ?>
    </p>
</li>

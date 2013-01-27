<?php
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

?>
<!DOCTYPE html>
<html>
<head>
    <title>ROBLOX Forums</title>
    <?php include("../../../includes/defaultMobile.php"); ?>
    <script type="text/javascript" src = "includes/ga_tracking.js"></script>
</head>
<body>
<div data-role="page">
    <!--Header-->
    <?php
    $title = "ROBLOX Forums";
    include("includes/header.php");
    ?>
    <!--/Header-->
    <!--Body-->
	<div data-role="content">
        <a href='<?= htmlspecialchars($thread->url) ?>' target='_blank' data-role='button'>
            Show Original
        </a>
        <br>
		<ul data-role="listview">
		<?php $thread->forEachPost(function($post) { ?>
            <li data-role='list-divider'><?= $post->title ?></li>
            <li data-theme='d'>
                <div data-role='collapsible' data-icon='delete' data-mini='true'>
                    <h5>
			<?php if($post->author->isMod): ?>
                        <img src='includes/mod.gif' alt='MOD' />
			<?php endif ?>
                        <font color='<?php if($post->author->online): ?>green<?php else: ?>red<?php endif ?>'>
                            <?= $post->author->name ?>

                        </font>
                    </h5>
                    <p>
                        <img src='<?= $post->author->img ?>' alt='<?= $post->author->name ?>' /><br>
                        Joined <b><?= $post->author->joinDate ?></b><br>
                        Total Posts <b><?= $post->author->postCount ?></b><br>
                        <a href='<?= $post->author->url ?>' target='_blank'>View Profile &#187;</a>
                    </p>
                </div>
				<br>
                <p style='word-break: break-all;'>
                    <?= $post->content ?><br><br>
                    <b>Posted</b> <?= $post->date ?>

                </p>
            </li>
<?php }) ?>
        </ul>
	</div>
    <?php include("includes/paginationFooter.php"); ?>
    <!--/Body -->
</div>
</body>
</html>
<?php
}
?>
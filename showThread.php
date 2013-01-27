<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
$id = $_GET['id']; 
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $pageNum = $_GET['page'];
}
else {$pageNum = 1;}
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
        <a href='http://www.roblox.com/Forum/ShowPost.aspx?PostID=<?= $id ?>&amp;PageIndex=<?= $pageNum ?>' target='_blank' data-role='button'>
            Show Original
        </a>
        <br>
		<ul data-role="listview">
        <?php include('parsers/threadParser.php'); ?>
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
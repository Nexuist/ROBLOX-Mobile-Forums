<?php
if ($errored != true) {
    // This is here so code works with both thread list and thread view
    // Because element that holds 'page x in y' text is named differently on both pages
    if ($page->getElementById("ctl00_cphRoblox_PostView1_ctl00_Pager") == NULL) {
        $rawPages =  $page->getElementById("ctl00_cphRoblox_ThreadView1_ctl00_Pager")->childNodes->item(0)->nodeValue;
    }
    else {
        $rawPages = $page->getElementById("ctl00_cphRoblox_PostView1_ctl00_Pager")->childNodes->item(0)->nodeValue;
    }

$totalPages = substr($rawPages, strpos($rawPages, "of") + 2, strpos($rawPages,"Goto") - 9); // Find out how many pages total - why 9? I have no clue, but it works for everything
$totalPages = str_replace(",","",$totalPages);
if ($totalPages > 1) {
?>
<div data-role = "footer" data-theme = "b" class = "ui-bar">
            
            <div style = "text-align: center;" data-role="controlgroup" data-type="horizontal">
            
            <?php
                    $pageName = $_SERVER['PHP_SELF'];
                    // Back button
                    if ($pageNum != 1) {
                        $prevPage = $pageNum -1;
                        echo "<a href='$pageName?id=$id&page=$prevPage' data-theme = 'e' data-role='button' data-icon = 'arrow-l' data-iconpos = 'notext'></a>";
                        }
                    echo "<a href = '#' data-role = 'button' data-theme = 'c'>$pageNum of $totalPages</a>";
                    // Forward button
                    if ($pageNum != $totalPages) {
                        $nxtPage = $pageNum +1;
                        echo "<a href='$pageName?id=$id&page=$nxtPage' data-theme = 'e' data-role='button' data-icon = 'arrow-r' data-iconpos = 'notext'></a>";
                        }
            ?>
            
            </div>
            
</div>
<?php }} ?>


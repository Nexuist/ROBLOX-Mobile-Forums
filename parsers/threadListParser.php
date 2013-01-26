<?php
//Setup
$html = @file_get_contents("http://www.roblox.com/Forum/ShowForum.aspx?ForumID=$id&PageIndex=$pageNum");
//Error handling
if ($html === false) {
    echo "<li><h1>Error</h1><p>The page couldn't be found.</p></li>";
    $errored = true; // Needed for paginationFooter to not error
}
else 
{
    libxml_use_internal_errors(true);
    $page = new DOMDocument();
    $page -> preserveWhiteSpace = false;
    $page -> loadHTML($html);
    if ($page->getElementById('ctl00_cphRoblox_ThreadView1_ctl00_ThreadList') != NULL) {
        $holder = $page->getElementById('ctl00_cphRoblox_ThreadView1_ctl00_ThreadList')->childNodes;
        foreach($holder as $thread) {
            if ($thread->getElementsByTagName('td')->length > 1) {
                // Resetting vars
                $pinned = "";
                $pages = 1;
                $title = $thread->childNodes->item(1)->getElementsByTagName('a')->item(0)->nodeValue;
                if ($thread->childNodes->item(1)->childNodes->length > 1) {
                    //Dealing with multiple pages
                    // HAXXXXXXXXXXXXXXXX
                    $titleWithPages = $thread->childNodes->item(1)->nodeValue;
                    $pagesArray = explode(",",$titleWithPages);
                    $pages = substr($pagesArray[count($pagesArray)-1],0,-1);
                }
                $href = substr($thread->childNodes->item(1)->getElementsByTagName('a')->item(0)->getAttribute('href'),28);
                $author = $thread->childNodes->item(2)->nodeValue;
                $replies = $thread->childNodes->item(3)->nodeValue;
                $views = $thread->childNodes->item(4)->nodeValue;
                
                //Doing magic on the last column
                $lastPostedSect = $thread->childNodes->item(5)->nodeValue;
                if (substr($lastPostedSect,0,11) == "Pinned Post") {
                    $pinned = "data-icon = 'star'";
                }
                else {
                    // This is needed to display last poster info correctly on threads from before today
                    if (substr($lastPostedSect,0,5) == "Today") {
                        $lastPoster = substr($lastPostedSect,19);
                    }
                    else {
                        $lastPoster = substr($lastPostedSect,23);
                    }
                }
                //Turn hyphens into 0s (helps clarity)
                $replies = str_replace("-","0",$replies);
                $views = str_replace("-","0",$views);
                echo "<li $pinned><a href = 'showThread.php?id=$href'>"; // URL
                echo "<h3 style = 'white-space: normal'>$title</h3>"; // Title
                echo "<p><font color = '#2489CE'>$author</font> "; // Author
                echo "<b>$replies</b> Replies <b>$views</b> Views <b>$lastPoster</b>"; // Replies, views, last poster
                if ($pages != 1) {
                    echo "<div class = 'ui-li-count'>$pages</div>"; // Pages
                }
                echo "</p></a></li>"; // Close
            }
        }
    }
    else {
        echo "<li><h1>Error</h1><p>You can no longer see these posts anymore.</p></li>";
        $errored = true; // Needed for paginationFooter to not error
    }
}
?>
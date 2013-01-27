<?php
// nodeValue strips out newlines, this function keeps HTML intact
function innerXML($node) { 
    $doc  = $node->ownerDocument; 
    $frag = $doc->createDocumentFragment(); 
    foreach ($node->childNodes as $child) { 
        $frag->appendChild($child->cloneNode(TRUE)); 
    } 
    return $doc->saveXML($frag); 
}  

// Setup
$html = @file_get_contents("http://www.roblox.com/Forum/ShowPost.aspx?PostID=$id&PageIndex=$pageNum");
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

    $holder = $page->getElementById('ctl00_cphRoblox_PostView1_ctl00_PostList');
    // Error if thread doesn't exist
    if (!$holder) {
        echo "<li><h3>Error</h3><p>An error occured while parsing this thread.</p></li>";
    }
    else {
        $holder = $holder->childNodes;
        foreach($holder as $post) {
            if (($post->childNodes->length == 3) && ($post->getElementsByTagName('td')->length != 0)) {
                $authorSect = $post->childNodes->item(0)->childNodes->item(0);
                $postSect =  $post->childNodes->item(1)->childNodes->item(0);
                //Really weird hax stoof
                $authorName = trim(substr($authorSect->childNodes->item(0)->nodeValue,2));
                $authorURL = "http://roblox.com/User.aspx?username=" . $authorName;
                $authorImg = "http://www.roblox.com/Thumbs/Avatar.ashx?x=100&y=100&Format=Png&username=" . $authorName;
                $authorIcon = $authorSect->getElementsByTagName('img')->item(0)->getAttribute('src');
                //Figure out if online or offline

                $isOnline = $authorIcon == "/Forum/skins/default/images/user_IsOnline.gif";
                $authorDate = trim(substr($authorSect->childNodes->item(2)->nodeValue,8));
                // Hax to fix problem with displaying info if they have an img under name
                if ($authorDate == "") {
                    // Figure out if mod
                    $modIndic = $authorSect->getElementsByTagName('img')->item(3)->getAttribute('src');
                    if (substr($modIndic,1,36) == "Forum/skins/default/images/users_top" && $authorSect->getElementsByTagName('img')->length == 5) {
                        // They're a mod and a top poster
                        $isMod = true;
                        $authorDate = substr($authorSect->childNodes->item(4)->nodeValue,8);
                        $authorPosts = substr($authorSect->childNodes->item(5)->nodeValue,13);
                    }
                    if ($modIndic == "/Forum/skins/default/images/users_moderator.gif") {
                        // If they're just a mod
                        $isMod = true;
                        $authorDate = substr($authorSect->childNodes->item(3)->nodeValue,8);
                        $authorPosts = substr($authorSect->childNodes->item(4)->nodeValue,13);
                    }
                }
                else {
                    $authorPosts = trim(substr($authorSect->childNodes->item(3)->nodeValue,13));
                }
                // line below doesn't work
                //$authorGroup = $authorSect->childNodes->item(4)->getElementsByTagName('a')->item(0)->getAttribute('src');
                // echo $authorGroup;
                $postTitle = $postSect->childNodes->item(0)->childNodes->item(0);
                $postTopic = $postTitle->childNodes->item(0)->nodeValue;
                $postDate = $postTitle->childNodes->item(3)->nodeValue;
                $postContents = innerXML($postSect->childNodes->item(1));

                // include our template to separate parsing from presentation
                include "templates/post.php";

                $isMod = false; // Reset mod status so everyone doesn't get the icon
            }
        }
    }
}
?>
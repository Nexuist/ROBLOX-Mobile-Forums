<?php
//NOTE: str_replace is used to replace & because they are not valid XML and will cause an error when parsed
//Setup
$html = @file_get_contents("http://www.roblox.com/Forum/Default.aspx");
//Error handling
if ($html === false) {
    echo "<li><h1>Error</h1><p>The website couldn't be reached.</p></li>";
}
else
{
    libxml_use_internal_errors(true);
    //Prepare file and DOM
    $file = fopen('../forums.html','w');
    $layout = fopen('../forums.xml','w');
    fwrite($layout, "<?xml version='1.0' encoding='UTF-8'?><forums>");
    $dataToWrite = "";
    $xml = "";
    $page = new DOMDocument();
    $page -> preserveWhiteSpace = false;
    $page -> loadHTML($html);
    //Getting titles
    $anchor = $page -> getElementsByTagName('a');

    foreach($anchor as $title) {
        $href = $title->getAttribute('href');
        // Forum link
        if (strlen($href) >= 16 and substr($href,0,16) == "/Forum/ShowForum") {
            // Forum
            if (strlen($href) >= 31 and substr($href,16,5) == ".aspx") {
                $url = "forum-" . substr($href,30);
                $desc = $title->parentNode->getElementsByTagName('span')->item(0)->nodeValue;

                $xml .= "\n\t<forum id=\"" . substr($href,30) . "\">"
                      . "\n\t\t<name>" . str_replace("&","&amp;",$title->nodeValue) . "</name>"
                      . "\n\t\t<desc>" . str_replace("&","&amp;",$desc) . "</desc>"
                      . "\n\t</forum>";
                $dataToWrite .= "<li>" . "<a href = '" . $url . "'><h3>" . $title->nodeValue . "</h3>"
                              . "<p>" . $desc . "</p></a></li>\n";
            }
            // Group
            if (strlen($href) >= 41 and substr($href,16,5) == "Group") {
                $xml = $xml . "\n<forum>\n<name>" . str_replace("&","&amp;",$title->nodeValue) . "</name>\n<group>true</group>\n</forum>";
                $dataToWrite = $dataToWrite . "<li data-role = 'list-divider'>" .  $title->nodeValue . "</li>\n";
            }
        }
    }
    //Write contents to file
    fwrite($file,$dataToWrite);
    fwrite($layout,$xml . "\n</forums>");
    fclose($file);
    fclose($layout);
}
?>
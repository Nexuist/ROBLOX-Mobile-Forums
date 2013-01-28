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
	$dataToWrite = "";
	$page = new DOMDocument();
	$page -> preserveWhiteSpace = false;
	$page -> loadHTML($html);
	//Getting titles
	$anchor = $page -> getElementsByTagName('a');


	$xml = new SimpleXMLElement('<forums/>');
	$group = $xml;

	foreach($anchor as $title) {
		$href = $title->getAttribute('href');
		// Forum link
		if (strlen($href) >= 16 and substr($href,0,16) == "/Forum/ShowForum") {
			// Forum
			if (strlen($href) >= 31 and substr($href,16,5) == ".aspx") {

				$url = "forum-" . substr($href,30);
				$desc = trim($title->parentNode->getElementsByTagName('span')->item(0)->nodeValue);

				$xml_forum = $group->addChild('forum');
				$xml_forum->addAttribute('id', substr($href,30));
				$xml_forum->addChild('name', $title->nodeValue);
				$xml_forum->addChild('desc', $desc);

				$dataToWrite .= "<li>" . "<a href = '" . $url . "'><h3>" . $title->nodeValue . "</h3>"
							  . "<p>" . $desc . "</p></a></li>\n";
			}
			// Group
			if (strlen($href) >= 41 and substr($href,16,5) == "Group") {
				$xml_group = $xml->addChild('group');
				$xml_group->addChild('name', $title->nodeValue);
				$group = $xml_group;

				$dataToWrite = $dataToWrite . "<li data-role = 'list-divider'>" .  $title->nodeValue . "</li>\n";
			}
		}
	}
	// http://stackoverflow.com/a/1191188/102441
	$dom = dom_import_simplexml($xml)->ownerDocument;
	$dom->formatOutput = true;
	$dom->save('../forums.xml');

	//Write contents to file
	fwrite($file,$dataToWrite);
	fclose($file);
}
?>

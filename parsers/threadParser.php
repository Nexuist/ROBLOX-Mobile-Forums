<?php

require_once "includes/classes.php";

// nodeValue strips out newlines, this function keeps HTML intact
function innerXML($node) {
	$doc  = $node->ownerDocument;
	$frag = $doc->createDocumentFragment();
	foreach ($node->childNodes as $child) {
		$frag->appendChild($child->cloneNode(TRUE));
	}
	return $doc->saveXML($frag);
}

class Thread extends EnhancedObject {
	public $id;
	public $pageNum;

	public function loadPage() {
		$html = @file_get_contents($this->url);
		if(!$html) return NULL;

		libxml_use_internal_errors(true);
		$page = new DOMDocument();
		$page -> preserveWhiteSpace = false;
		$page -> loadHTML($html);
		return $page;
	}

	public function getUrl() {
		return "http://www.roblox.com/Forum/ShowPost.aspx?PostID={$this->id}&PageIndex={$this->pageNum}";
	}

	public function loadPosts() {
		global $errored, $page;
		# Temporary bodge for pagination
		$page = $this->page;

		$posts = array();

		if(!$page) {
			echo "<li><h1>Error</h1><p>The page couldn't be found.</p></li>";
			$errored = true; // Needed for paginationFooter to not error
			return $posts;
		}

		$holder = $page->getElementById('ctl00_cphRoblox_PostView1_ctl00_PostList');

		// Error if thread doesn't exist
		if (!$holder) {
			echo "<li><h3>Error</h3><p>An error occured while parsing this thread.</p></li>";
			$errored = true; // Needed for paginationFooter to not error
			return $posts;
		}

		$holder = $holder->childNodes;
		foreach($holder as $post) {
			if (($post->childNodes->length == 3) && ($post->getElementsByTagName('td')->length != 0)) {
				$postSect =  $post->childNodes->item(1)->childNodes->item(0);

				$authorSect = $post->childNodes->item(0)->childNodes->item(0);

				$post = new Post();

				$post->author = User::fromPostAuthorInfo($authorSect);

				$postTitleSect = $postSect->childNodes->item(0)->childNodes->item(0);
				$post->title = trim($postTitleSect->childNodes->item(0)->nodeValue);
				$post->date = trim($postTitleSect->childNodes->item(3)->nodeValue);
				$post->content = innerXML($postSect->childNodes->item(1)->childNodes->item(0)->childNodes->item(0));
				// $post->content = current($postSect->childNodes->item(1)->xpath("//span[@class='normalTextSmall']"))->nodeValue;

				$posts[] = $post;
			}
		}

		User::populateGroupInfo();

		return $posts;
	}
}
?>

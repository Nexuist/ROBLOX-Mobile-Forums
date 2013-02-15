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

class RobloxForumError extends Exception {
	public $description;
	public $title;
	public function __construct($title, $description) {
		$this->title = $title;
		$this->description = $description;
		parent::__construct($title);
	}
}

class NoSuchThreadException extends Exception {}
class ThreadParseException extends Exception {}

class Thread extends EnhancedObject {
	public $id;
	public $pageNum;

	public $pinned;
	public $author;
	public $lastPoster;
	public $replies;
	public $views;

	public function loadPage() {
		$html = @file_get_contents($this->url);
		if(!$html) throw new NoSuchThreadException();

		libxml_use_internal_errors(true);
		$page = new DOMDocument();
		$page -> preserveWhiteSpace = false;
		$page -> loadHTML($html);

		// Handle the errors in blue boxes the forum sometimes gives
		$errorBox = $page->getElementById("ctl00_cphRoblox_Message1_ctl00_MessageTitle");
		if($errorBox) {
			$errMsg = $page->getElementById("ctl00_cphRoblox_Message1_ctl00_MessageBody");
			throw new RobloxForumError($errorBox->nodeValue, $errMsg->nodeValue);
		}

		return $page;
	}

	public function getUrl() {
		return "http://www.roblox.com/Forum/ShowPost.aspx?PostID={$this->id}&PageIndex={$this->pageNum}";
	}

	public function loadTotalPages() {
		// Error if thread doesn't exist
		$holder = $this->page->getElementById("ctl00_cphRoblox_PostView1_ctl00_Pager");
		if (!$holder) throw new ThreadParseException();

		// Get the total number of pages
		$pagination = $holder->childNodes->item(0)->nodeValue;
		$matches = array();
		if(preg_match('/page\s+[\d,]+\s+of\s+([\d,]+)/i', $pagination, $matches)) {
			return (int) str_replace(",", "", $matches[1]);
		}
	}

	public function loadTitle() {
		return $this->posts[0]->title;
	}

	public function loadAuthors() {
		$authors = array();
		foreach($this->posts as $p) {
			$authors[$p->author->name] = $p->author;
		}
		return array_values($authors);
	}

	public function loadPosts() {
		global $errored, $page;
		# Temporary bodge for pagination
		$page = $this->page;

		$posts = array();

		$holder = $page->getElementById('ctl00_cphRoblox_PostView1_ctl00_PostList');

		// Error if thread doesn't exist
		if (!$holder) {
			throw new ThreadParseException();
		}

		$holder = $holder->childNodes;
		$lastPost = null;
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

				$post->content = '<p>'.preg_replace('@<br />\s*<br />@', '</p><p>', $post->content).'</p>';

				// $post->content = current($postSect->childNodes->item(1)->xpath("//span[@class='normalTextSmall']"))->nodeValue;

				$post->titleIsOriginal = $post->title != $lastPost->title && $post->title != "Re: ".$lastPost->title;

				$posts[] = $post;
				$lastPost = $post;

			}
		}

		User::populateGroupInfo();

		return $posts;
	}
}
?>

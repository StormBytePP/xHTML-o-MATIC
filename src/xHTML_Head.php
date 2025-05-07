<?php

require_once __DIR__.'/xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <title> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Title extends xHTML_Text {

	/**
	 * Default constructor
	 */
	public function __construct($title) {
		parent::__construct();
		$this->tagname = "title";
		$this->bbenabled = FALSE;
		$this->AddContent($title);
	}
	
	/**
	 * Renders it
	 */
	public function Render() {
		echo $this->ToString();
	}
	
	/**
	 * Gets contents string
	 * @return string
	 */
	public function ToString() {
		$output="<title>";
		$output.=parent::ToString();
		$output.="</title>";
		return $output;
	}

}

/**
 * Support for xHTML 1.1 <meta> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Meta extends xHTML_Item {

	/**
	 * Default constructor
	 * @param string $property Property
	 * @param string $value Value
	 */
	public function __construct() {
		parent::__construct();
		$this->tagname = "meta";
		$this->properties->SetGeneralAttributes();
		$this->properties->SetAcceptedNames("content", "http-equiv", "name", "scheme");
		$this->properties->SetAcceptedValues("http-equiv", "content-type", "content-style-type", "expires", "set-cookie", "refresh");
		$this->properties->SetAcceptedValues("name", "author", "description", "keywords", "generator", "revised");
		$this->autoclosed = true;
		$this->bbenabled = FALSE;
	}

	/**
	 * Adds a meta keywords
	 * @param string $name Name of meta
	 * @param string $content Content
	 */
	public function AddMeta($name, $content) {
		$this->SetProperty("name", $name);
		$this->SetProperty("content", $content);
	}

	/**
	 * Creates a redirection Meta
	 * @param int $time Time in seconds
	 * @param string $URI URI to be redirected
	 */
	public function SetRedirection($time, $URI) {
		$this->SetProperty("http-equiv", "refresh");
		$this->SetProperty("content", $time . "; url=" . $URI);
	}

}

/**
 * Support for xHTML 1.1 <head> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Head extends xHTML_Item {

	/**
	 * Default constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->properties->SetGeneralAttributes();
		$this->properties->SetAcceptedNames("profile");
		$this->tagname = "head";
		$this->bbenabled = FALSE;
	}

	/**
	 * Sets page's title
	 * @param string $title Page's title 
	 */
	public function SetTitle($title) {
		$existingTitle=NULL;
		if (!is_null($this->contents)) {
			foreach ($this->contents as $content) {
				if (is_a($content, "xHTML_Title")) {
					$existingTitle=$content;
				}
			}
		}
		if (!is_null($existingTitle)) {
			$existingTitle->ReplaceContent($title);
		}
		else {
			$tag = new xHTML_Title($title);
			$this->AddContent($tag);
		}
	}

	/**
	 * Adds content
	 * @param string $content 
	 */
	public function AddContent($content) {

		if (is_array($content)) {
			foreach ($content as $value) {
				$this->AddContent($value);
			}
		} else {
			if (is_object($content)) {
				parent::AddContent($content);
			} else {
				throw new TextNotAllowedHere;
			}
		}
	}

	/**
	 * Sets encoding
	 * @param string $encoding Encoding
	 */
	public function SetEncoding($encoding) {
		$meta = new xHTML_Meta();
		$meta->SetProperty("http-equiv", "Content-Type");
		$meta->SetProperty("content", "text/html; charset=" . $encoding);
		$this->AddContent($meta);
	}

	public function SetRedirection($time, $URI) {
		$meta = new xHTML_Meta();
		$this->SetProperty("http-equiv", "refresh");
		$this->SetProperty("content", $time . ";url=" . $URI);
		$this->AddContent($meta);
	}

}

?>
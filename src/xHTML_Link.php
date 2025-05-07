<?php

require_once __DIR__.'/xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <link> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Link extends xHTML_Item {
	/**
	 * Constructor
	 * @param NULL $content It is not used in this case
	 */
	public function __construct($content = NULL) {
		parent::__construct(NULL); //This does not accept any content
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("charset", "href", "hreflang", "media", "rel", "rev", "target", "type");
		$this->properties->SetAcceptedValues("rel", "alternate", "archives", "author", "bookmark", "external", "first", "help", "icon",
								"last", "license", "next", "nofollow", "noreferrer", "pingback", "prefetch",
								"prev", "search", "shortcut icon", "sidebar", "stylesheet", "tag", "up" );
		$this->bbenabled=FALSE;
		$this->autoclosed=TRUE;
		$this->tagname="link";
	}
	
	/**
	 * Sets HREF
	 * @param string $href HREF
	 */
	public function SetHREF($href) {
		$this->properties->SetProperty("href", $href);
	}
	
	/**
	 * Sets type
	 * @param string $type Type
	 */
	public function SetType($type) {
		$this->properties->SetProperty("type", $type);
	}
	
	/**
	 * Sets Rel
	 * @param string $rel
	 */
	public function SetRel($rel) {
		$this->properties->SetProperty("rel", $rel);
	}
}

?>
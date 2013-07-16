<?php

require_once __DIR__.'/xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <a> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_A extends xHTML_Item {

	/**
	 * Default constructor
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname = "a";
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("charset", "coords", "href", "hreflang", "name", "rel", "rev", "shape", "target");
		$this->properties->SetAcceptedValues("shape", "default", "rect", "circle", "poly");
		$this->properties->SetAcceptedValues("target", "_blank", "_parent", "_self", "_top");
		$this->properties->SetProperty("id", $this->uniqid);
	}

	/**
	 * Sets link for anchor
	 * @param string $link 
	 */
	public function SetLink($link) {
		$this->SetProperty("href", $link);
	}

	/**
	 * Sets if this anchor has to be loaded on another page
	 */
	public function LoadInNewPage() {
		$this->SetProperty("target", "_blank");
	}

	/**
	 * Sets a property
	 * @param string $name Property name
	 * @param string $value Property value
	 */
	public function SetProperty($name, $value) {
		parent::SetProperty($name, $value);
	}

	/**
	 * Clears a property
	 * @param string $name Property name
	 */
	public function ClearProperty($name) {
		parent::ClearProperty($name);
	}

	/**
	 * Replaces content
	 * @param string|xHTML_Item|array $content Content to replace
	 */
	public function ReplaceContent($content) {
		parent::ReplaceContent($content);
	}
	
	/**
	 * Adds content
	 * @param string|HTML_Item $content Content to add
	 */
	public function AddContent($content) {
		parent::AddContent($content);
	}
	
	/**
	 * Adds content before this one
	 * @param string|xHTML_Item|array $newContent
	 */
	public function AddContentBefore($newContent) {
		parent::AddContentBefore($newContent);
	}
	
	/**
	 * Adds content after this one
	 * @param string|xHTML_Item|array $newContent
	 */
	public function AddContentAfter($newContent) {
		parent::AddContentAfter($newContent);
	}

	/**
	 * Adds a CSS class to this object
	 * @param string $classname CSS class name
	 */
	public function AddCSSClass($classname) {
		parent::AddCSSClass($classname);
	}

}

?>
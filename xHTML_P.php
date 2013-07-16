<?php

require_once __DIR__.'/xHTML_Generic.php';
require_once __DIR__.'/xHTML_BR.php';

/**
 * Support for xHTML 1.1 <p> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_P extends xHTML_Item {

	/**
	 * Default constructor
	 * @param string|xHTML_Item $content Content to add
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname = "p";
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("align");
		$this->properties->SetAcceptedValues("align", "left", "right", "center", "justify");
		$this->SetProperty("id", $this->uniqid);
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
	 * @param string|xHTML_Item|array $content
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
	 * Sets a property
	 * @param string $name Name
	 * @param string $value Value
	 */
	public function SetProperty($name, $value) {
		parent::SetProperty($name, $value);
	}

	/**
	 * Clears a property
	 * @param string $name Name
	 */
	public function ClearProperty($name) {
		parent::ClearProperty($name);
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
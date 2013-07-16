<?php

require_once __DIR__.'/xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <div> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Div extends xHTML_Item {

	/**
	 * Public constructor
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("align");
		$this->properties->SetAcceptedValues("align", "left", "right", "center", "justify");
		$this->tagname = "div";
		$this->SetProperty("id", $this->uniqid);
	}

	/**
	 * Sets a property
	 * @param string $name Property name
	 * @param string $value Value
	 */
	public function SetProperty($name, $value) {
		parent::SetProperty($name, $value);
	}

	/**
	 * Clears a property
	 * @param string $name Propert name
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
	 * @param string|xHTML_Item $content 
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
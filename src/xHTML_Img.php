<?php

require_once __DIR__.'/xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <img> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Img extends xHTML_Item {

	/**
	 * Default constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->tagname = "img";
		$this->autoclosed = TRUE;
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("align", "alt", "border", "height", "hspace", "ismap", "longdesc", "src", "usemap", "vspace", "width");
		$this->properties->SetAcceptedValues("align", "top", "bottom", "middle", "left", "right");
		//Mandatory alternative name!
		$this->SetAlternativeName("No alt text");
		$this->SetProperty("id", $this->uniqid);
	}

	/**
	 * Sets destination of the image
	 * @param string $src Destination file or url
	 */
	public function SetImage($src) {
		$this->SetProperty("src", $src);
	}

	/**
	 * Sets alternative name of that image
	 * @param string $text Text
	 */
	public function SetAlternativeName($text) {
		$this->SetProperty("alt", $text);
	}

	/**
	 * Sets a property
	 * @param string $name Property name
	 * @param string $value Property name
	 */
	public function SetProperty($name, $value) {
		parent::SetProperty($name, $value);
		if (strtolower($name) == "alt" && empty($value)) {
			$this->SetAlternativeName("No alt name");
		}
	}

	/**
	 * Clear property
	 * @param string $name Property name
	 */
	public function ClearProperty($name) {
		parent::ClearProperty($name);
		if (strtolower($name) == "alt") {
			$this->SetAlternativeName("No alt name");
		}
	}

	/**
	 * Adds a CSS class to this object
	 * @param string $classname CSS class name
	 */
	public function AddCSSClass($classname) {
		parent::AddCSSClass($classname);
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

}

?>
<?php

require_once __DIR__.'//xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <span> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Span extends xHTML_Item {
	/**
	 * Constructor
	 * @param string|xHTML_Item $content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->bbenabled=false;
		$this->tagname="span";
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
	}
	
	/**
	 * Adds CSS class
	 * @param string $classname CSS Class name
	 */
	public function AddCSSClass($classname) {
		parent::AddCSSClass($classname);
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
	 * @param string|xHTML_Item|array $content Content to add
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
}
?>

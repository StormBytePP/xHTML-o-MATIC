<?php

require_once __DIR__.'/xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <base> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Base extends xHTML_Item {

	/**
	 * Default constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->tagname = "base";
		$this->autoclosed = TRUE;
		$this->properties->SetGeneralAttributes();
		$this->properties->SetAcceptedNames("href", "target");
		$this->properties->SetAcceptedValues("target", "_blank", "_parent", "_self", "_top");
		$this->bbenabled = FALSE;
	}

	/**
	 * Sets document's base
	 * @param string $base Base href 
	 */
	public function SetBase($base) {
		$this->SetProperty("href", $base);
	}

	/**
	 * Sets target property
	 * @param string $targettype
	 */
	public function SetTarget($targettype) {
		$target = strtolower($targettype);
		$this->properties->SetProperty("target", $target);
	}

}

?>
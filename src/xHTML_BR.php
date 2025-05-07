<?php

require_once __DIR__.'/xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <br /> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_BR extends xHTML_Item {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->tagname = "br";
		$this->autoclosed = true;
	}

}

?>
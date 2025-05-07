<?php

require_once __DIR__.'/xHTML_Generic.php';
require_once __DIR__.'/xHTML_A.php';
require_once __DIR__.'/xHTML_Img.php';
require_once __DIR__.'/xHTML_P.php';

/**
 * W3C validated button
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class W3COKButton extends xHTML_Item {

	/**
	 * Default constructor
	 */
	public function __construct() {
		parent::__construct();
		$p = new xHTML_P();
		$link = new xHTML_A();
		$img = new xHTML_Img();

		global $http_root, $https_root;
		$basedir = "";
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
			$basedir = $https_root . "/IMG/";
		} else {
			$basedir = $http_root . "/IMG/";
		}

		/** IMAGE * */
		$img->SetAlternativeName("Valid XHTML 1.0 Transitional");
		$img->SetProperty("height", "31");
		$img->SetProperty("width", "88");
		$img->SetImage($basedir . "valid-xhtml10.png");

		/** SETUP LINK * */
		$link->SetLink("http://validator.w3.org/check?uri=referer");
		$link->LoadInNewPage();

		/** ADD IMAGE TO LINK * */
		$link->AddContent($img);

		/** ADD LINK TO P ITEM * */
		$p->AddContent($link);

		/** ADD ALL TO CONTAINER * */
		$this->AddContent($p);
	}

}

?>
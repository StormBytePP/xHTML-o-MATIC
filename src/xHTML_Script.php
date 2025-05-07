<?php

require_once __DIR__.'/xHTML_Generic.php';
require_once __DIR__.'/xHTML_UnparsedCode.php';

/**
 * Support for xHTML 1.1 <script> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Script extends xHTML_Item {

	/**
	 * Script
	 * @var string 
	 */
	private $script;

	/**
	 * Default constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->tagname = "script";
		$this->properties->SetGeneralAttributes();
		$this->properties->SetAcceptedNames("charset", "defer", "src", "type");
		$this->SetProperty("type", "text/javascript");
		$this->bbenabled = FALSE;
		$this->script = "";
	}

	/**
	 * Adds a content
	 * @param string $content Content TEXT to add
	 */
	public function AddContent($content) {
		$this->script.=$content;
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
	 * Renders xHTML
	 */
	public function Render() {
		echo $this->ToString();
	}
	
	/**
	 * Gets contents' string
	 * @return string
	 */
	public function ToString() {
		$cdata = new xHTML_CDATA_Javascript($this->script);
		$this->ClearContent();
		parent::AddContent($cdata);
		return parent::ToString();
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
	 * @param string $name Property name
	 */
	public function ClearProperty($name) {
		parent::ClearProperty($name);
	}

	/**
	 * Clears content
	 */
	public function ClearContent() {
		$this->script = "";
		parent::ClearContent();
	}

	/**
	 * Sets javascript src
	 * @param string $src 
	 */
	public function SetSrc($src) {
		$this->SetProperty("src", $src);
	}

}

final class xHTML_CDATA_Javascript extends xHTML_CDATA {

	/**
	 * Constructor
	 * @param string $text 
	 */
	public function __construct($text = "") {
		parent::__construct($text);
	}

	/**
	 * Custom renderer for this class
	 */
	public function Render() {
		echo $this->ToString();
	}
	
	/**
	 * Gets contents' string
	 * @return string
	 */
	public function ToString() {
		$output="/*<![CDATA[*/";
		$output.=preg_replace(array("/\t+/", "/ +/"), array(" ", " "), str_replace("\n", " ", parent::GetRawContent()));
		$output.="/*]]>*/";
		return $output;
	}

	/**
	 * Gets content without render
	 * @return string
	 */
	public function GetContent() {
		$content = "/*<![CDATA[*/";
		$content.=parent::GetRawContent();
		$content.="/*]]>*/";
		return $content;
	}

}

?>
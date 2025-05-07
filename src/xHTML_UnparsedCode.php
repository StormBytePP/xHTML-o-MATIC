<?php

require_once __DIR__.'//xHTML_Generic.php';

/**
 * Support for unparsed code (eithr HTML, javascript...)
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_UnparsedCode extends xHTML_Item {

	/**
	 * Var containing HTML (or javascript code)
	 * @var string
	 */
	private $html;

	/**
	 * Constructor
	 */
	public function __construct($htmlcode = "") {
		parent::__construct();
		$this->html = (string) $htmlcode;
	}

	/**
	 * Overrides parent's render to prevent parsing
	 */
	public function Render() {
		echo $this->ToString();
	}
	
	/**
	 * Gets contents' string
	 * @return string
	 */
	public function ToString() {
		return $this->html;
	}

	/**
	 * Replaces content
	 * @param string $content Content to replace
	 */
	public function ReplaceContent($content) {
		$this->html=(string)$content;
	}
	
	/**
	 * Adds unparsed content
	 * @param string $content 
	 */
	public function AddContent($content) {
		$this->html.=(string) $content;
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
	 * Sets unparsed content and erases previous content
	 * @param string $content 
	 */
	public function SetContent($content) {
		$this->html = (string) $content;
	}

	/**
	 * Clears its content
	 */
	public function ClearContent() {
		$this->html = "";
	}

	/**
	 * Gets content without rendering it
	 * @return string
	 */
	public function GetContent() {
		return $this->html;
	}

	/**
	 * Checks if is empty
	 * @return bool
	 */
	public function IsEmpty() {
		return empty($this->html);
	}

}

/**
 * Support for xHTML 1.1 CDATA sections
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_CDATA extends xHTML_UnparsedCode {

	/**
	 * Default constructor
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
	 * Gets content's string
	 * @return string
	 */
	public function ToString() {
		$output="<![CDATA[";
		$output.=parent::ToString();
		$output.="]]>";
		return $output;
	}

	/**
	 * Gets content without render
	 */
	public function GetContent() {
		$content = (string) "<![CDATA[";
		$content.=parent::GetContent();
		$content.=(string) "]]>";
	}

	/*	 * *
	 * Gets raw data
	 */

	protected function GetRawContent() {
		return parent::GetContent();
	}

}

?>
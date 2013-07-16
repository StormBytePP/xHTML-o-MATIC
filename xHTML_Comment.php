<?php

require_once __DIR__.'/xHTML_Generic.php';
require_once __DIR__.'/xHTML_Text.php';

/**
 * Support for xHTML 1.1 comments
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Comment extends xHTML_Item {

	/**
	 * Text for the comment
	 * @var HTMLText
	 */
	private $text;

	/**
	 * Constructor
	 * @param string $text Comment text 
	 */
	public function __construct($text = "") {
		parent::__construct();
		$this->text = new xHTML_FilteredText($text);
	}

	/**
	 * Renders comment
	 */
	public function Render() {
		echo $this->ToString();
	}
	
	/**
	 * Gets contents' string
	 * @return string
	 */
	public function ToString() {
		$output="<!-- ";
		$output.=$this->text->ToString();
		$output.=" -->";
		return $output;
	}

	/**
	 * Replaces content
	 * @param string|xHTML_Item|array $content Content to replace
	 */
	public function ReplaceContent($content) {
		$this->text=$content;
	}
	
	/**
	 * Adds content to comment
	 * @param string $content Content
	 */
	public function AddContent($content) {
		$this->text.=$content;
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
	 * Clears contents
	 */
	public function ClearContent() {
		$this->text->ClearContent();
	}

}

?>
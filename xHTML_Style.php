<?php

require_once __DIR__.'//xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <style> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Style extends xHTML_Item {
	/**
	 * Constructor
	 * @param string|xHTML_Item $content
	 */
	public function __construct($content = NULL) {
		$procContent=$content;
		if (is_string($procContent)) {
			$procContent=$this->CompactText($content);
		}
		parent::__construct($procContent);
		$this->bbenabled=false;
		$this->tagname="style";
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("media", "type");
		$this->properties->SetAcceptedValues("type", "text/css");
		$this->properties->SetProperty("type", "text/css");
	}
	
	/**
	 * Replaces content
	 * @param string $content Content to replace
	 */
	public function ReplaceContent($content) {
		parent::ReplaceContent(new xHTML_UnfilteredText($content));
	}
	
	/**
	 * Adds content
	 * @param string $content Content to add
	 */
	public function AddContent($content) {
		parent::AddContent(new xHTML_UnfilteredText($content));
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
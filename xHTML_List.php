<?php

require_once __DIR__.'/xHTML_Generic.php';

class xHTML_LI extends xHTML_Item {
	/**
	 * Constructor
	 * @param string|array|xHTML_Item $content Content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname="li";
		$this->bbenabled=false;
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("type", "value");
		$this->properties->SetAcceptedValues("type", "1", "A", "a", "I", "i", "disc", "square", "circle");
	}
	
	/**
	 * Adds CSS Class
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
	 * @param string|xHTML_Item|array $content Adds content
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

/**
 * Generic list implementation
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
abstract class xHTML_GenericList extends xHTML_Item {
	/**
	 * Constructor ($content is ignored)
	 * @param NULL $content Due to list automatic handling, content is ignored
	 */
	public function __construct($content = NULL) {
		parent::__construct(NULL);
		$this->bbenabled=false;
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("compact", "type");
		$this->properties->SetAcceptedValues("compact", "compact");
		$this->properties->SetAcceptedValues("type", "disc", "square", "circle");
		if (!is_null($content)) {
			$this->AddContent($content);
		}
	}
	
	/**
	 * Adds content to list
	 * @param string|array|xHTML_Item $content
	 */
	public function AddContent($content) {
		if (is_array($content)) {
			foreach ($content as $c) {
				$this->AddContent($c);
			}
		}
		else {
			if (is_a($content, "xHTML_LI")) {
				parent::AddContent($content);
			}
			else {
				parent::AddContent(new xHTML_LI($content));
			}
		}
	}
	
	/**
	 * Adds CSS Class
	 * @param string $classname CSS Class name
	 */
	public function AddCSSClass($classname) {
		parent::AddCSSClass($classname);
	}
}

/**
 * Support for xHTML 1.1 <ul> tag with automatic handling of elements
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_UL extends xHTML_GenericList {
	/**
	 * Constructor ($content is ignored)
	 * @param NULL $content Due to list automatic handling, content is ignored
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname="ul";
	}
}

/**
 * Support for xHTML 1.1 <ol> tag with automatic handling of elements
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_OL extends xHTML_GenericList {
	/**
	 * Constructor
	 * @param string|xHTML_Item $content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname="ol";
		$this->properties->SetAcceptedNames("start");
	}
}

?>

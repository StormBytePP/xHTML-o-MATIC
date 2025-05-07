<?php

require_once __DIR__.'/xHTML_Generic.php';

/**
 * Support for xHTML 1.1 Hx tags with automatic handling of elements
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
abstract class xHTML_HGeneric extends xHTML_Item {
	/**
	 * Generic constructor
	 * @param type $content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("align");
		$this->properties->SetAcceptedValues("align", "left", "center", "right", "justify");
		$this->bbenabled=false;
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
	 * @param string|array|xHTML_Item $content Content to add
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
 * Support for xHTML 1.1 <h1> tags with automatic handling of elements
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_H1 extends xHTML_HGeneric {
	/**
	 * Constructor
	 * @param string|array|xHTML_Item $content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname="h1";
	}
}

/**
 * Support for xHTML 1.1 <h1> tags with automatic handling of elements
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_H2 extends xHTML_HGeneric {
	/**
	 * Constructor
	 * @param string|array|xHTML_Item $content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname="h2";
	}
}

/**
 * Support for xHTML 1.1 <h1> tags with automatic handling of elements
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_H3 extends xHTML_HGeneric {
	/**
	 * Constructor
	 * @param string|array|xHTML_Item $content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname="h3";
	}
}

/**
 * Support for xHTML 1.1 <h1> tags with automatic handling of elements
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_H4 extends xHTML_HGeneric {
	/**
	 * Constructor
	 * @param string|array|xHTML_Item $content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname="h4";
	}
}

/**
 * Support for xHTML 1.1 <h1> tags with automatic handling of elements
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_H5 extends xHTML_HGeneric {
	/**
	 * Constructor
	 * @param string|array|xHTML_Item $content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname="h5";
	}
}

/**
 * Support for xHTML 1.1 <h1> tags with automatic handling of elements
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_H6 extends xHTML_HGeneric {
	/**
	 * Constructor
	 * @param string|array|xHTML_Item $content
	 */
	public function __construct($content = NULL) {
		parent::__construct($content);
		$this->tagname="h6";
	}
}

?>

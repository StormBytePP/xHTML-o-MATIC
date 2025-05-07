<?php

/**
 * Property not valid exception
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class PropertyNotValidException extends Exception {

	public function __construct($propertyname, $acceptednames) {
		$text = "Property name <b>" . $propertyname . "</b> is not valid for this object.<br />Accepted names are: ";
		$text.=implode(", ", $acceptednames) . "<br />";
		parent::__construct($text);
	}

}

/**
 * Property value not valid exception
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class PropertyValueNotValidException extends Exception {

	public function __construct($property, $value, $acceptedvalues) {
		$text = "Value <b>" . $value . "</b> for property <b>" . $property . "</b> is not a valid value.<br />Accepted values are: ";
		$text.=implode(", ", $acceptedvalues) . "<br />";
		parent::__construct($text);
	}

}

/**
 * Text not allowed here exception
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class TextNotAllowedHere extends Exception {

	public function __construct() {
		parent::__construct("Raw Text is not allowed here.<br />");
	}

}

/**
 * A parent was needed and not presented
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class NoParentGiven extends Exception {

	public function __construct() {
		parent::__construct("No parent Form (or invalid one) has been given to this object and it is needed.<br />");
	}

}

/**
 * Wrong argument type
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class WrongArgumentType extends Exception {

	public function __construct() {
		parent::__construct("Wrong argument type passed to function.<br />");
	}

}

/**
 * Null parent detected when calling insert before or insert after functions
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class NullParent extends Exception {
	public function __construct() {
		parent::__construct("NULL parent when insert bofore or insert after called!<br />");
	}
}

?>
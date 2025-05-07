 <?php

require_once __DIR__.'/xHTML_Exceptions.php';
require_once __DIR__.'/xHTML_Text.php';

/**
 * Support for xHTML 1.1 tag properties
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
final class xHTML_Properties {

	/**
	 * Internal variable for handling properties
	 * @var string
	 */
	private $propertymap;

	/**
	 * Variable for handling accepted names
	 * @var string[int]
	 */
	private $accepted_names;

	/**
	 * Variable for handling accepted values
	 * @var string[string][int]
	 */
	private $accepted_values;

	/**
	 * CSS class(es) pertaining
	 * @var array
	 */
	protected $cssclasses;
	
	/**
	 * Show ID attribute?
	 * @var bool
	 */
	protected $showID;

	/**
	 * Default constructor
	 */
	public function __construct() {
		$this->propertymap = array();
		$this->accepted_names = array();
		$this->accepted_values = array();
		$this->showID=false;
	}

	/**
	 * Renders all properties in an xHTML form
	 */
	public function Render() {
		echo $this->ToString();
	}

	/**
	 * Properties to string
	 * @return string Properties as a string
	 */
	public function ToString() {
		$output='';
		$counter = 0;
		$hasproperties = (empty($this->propertymap)) ? FALSE : TRUE;
		foreach ($this->propertymap as $property => $value) {
			$counter++;
			if ($property == "id" && !$this->showID) continue;
			$output.=$property . "='" . $value . "'";
			if ($counter < count($this->propertymap)) {
				$output.=" ";
			}
		}
		if (!empty($this->cssclasses)) {
			if ($hasproperties) {
				$output.=" ";
			}
			$output.="class='";
			$counter = 0;
			foreach ($this->cssclasses as $class) {
				$counter++;
				$output.=$class;
				if ($counter < count($this->cssclasses)) {
					$output.=" ";
				}
			}
			$output.="'";
		}
		return $output;
	}
	
	/**
	 * Configure (x)HTML global properties common all elements
	 */
	public function SetGeneralAttributes() {
		$this->SetAcceptedNames("accesskey", "class", "dir", "id", "lang", "style", "tabindex", "title");
		$this->SetAcceptedValues("dir", "ltr", "trl", "auto");
	}
	
	/**
	 * Configure (x)HTML global events
	 */
	public function SetGeneralEventAttributes() {
		$this->SetAcceptedNames(
				//Window Events
				"onload", "onunload",
				//Form Events
				"onblur", "onchange", "onreset", "onselect", "onsubmit",
				//Keyboard Events
				"onkeydown", "onkeypress", "onkeyup",
				//Mouse Events
				"onclick", "ondblclick", "onmousedown", "onmousemove", "onmouseout", "onmouseover", "onmouseup",
				//Media Events
				"onabort"
			);
	}
	
	/**
	 * Set accepted names for this list (variable parameter list!)
	 * By default, parameters given here will accept any string as a value
	 */
	public function SetAcceptedNames() {
		for ($i = 0; $i < func_num_args(); $i++) {
			$propname = (string) strtolower(func_get_arg($i));
			if ($propname != 'class') {
				array_push($this->accepted_names, $propname);
				$this->accepted_values[$propname] = (bool) TRUE;
			}
		}
	}

	/**
	 * Set accepted values for a property name (variable parameter list)
	 * @param string $property Property name
	 */
	public function SetAcceptedValues($property) {
		if ($this->IsValidProperty($property)) {
			$propname = (string) strtolower($property);
			if ($property != 'class') {
				unset($this->accepted_values[$propname]);
				$this->accepted_values[$propname] = array();
				for ($i = 1; $i < func_num_args(); $i++) {
					$value = (string) func_get_arg($i);
					array_push($this->accepted_values[$propname], (string) $value);
				}
			}
		}
	}

	/**
	 * Sets a property to accept string names
	 * @param string $property Property name
	 */
	public function SetAcceptStrings($property) {
		if ($this->IsValidProperty($property)) {
			$propname = (string) strtolower($property);
			$this->accepted_values[$propname] = (bool) TRUE;
		}
	}

	/**
	 * Checks if a given property name is valid
	 * @param string $property Property
	 * @return bool
	 */
	private function IsValidProperty($property) {
		return (array_search(strtolower($property), $this->accepted_names) !== FALSE);
	}

	/**
	 * Checks if this is a valid value for given property
	 * @param string $property Property name
	 * @param string $value Property value
	 * @return bool
	 */
	private function IsValidValue($property, $value) {
		if ($this->IsValidProperty($property)) {
			$p = (string) strtolower($property);
			$v = (string) strtolower($value);
			if (is_bool($this->accepted_values[$p])) {
				return $this->accepted_values[$p];
			} else {
				return (bool) (array_search($v, $this->accepted_values[$p]) !== FALSE);
			}
		} else {
			return FALSE;
		}
	}

	/**
	 * Sets a property
	 * @param string $property Property's name
	 * @param string $value Property's value
	 */
	public function SetProperty($property, $value) {
		$p = (string) strtolower($property);
		$v = ($p == 'alt' || $p == 'src' || $p == 'value') ? $value : $value;
		if ($this->IsValidValue($property, $value)) {
			$this->propertymap[$p] = $v;
		} else {
			if (!$this->IsValidProperty($property)) {
				throw new PropertyNotValidException($p, $this->accepted_names);
			} else {
				throw new PropertyValueNotValidException($p, $v, $this->accepted_values[$p]);
			}
		}
	}

	/**
	 * Clears a property
	 * @param string $property Property name
	 */
	public function ClearProperty($property) {
		$p = (string) strtolower($property);
		unset($this->propertymap[$p]);
	}

	/**
	 * Clear all properties
	 */
	public function ClearAll() {
		unset($this->propertymap);
		$this->propertymap = array();
	}

	/**
	 * Checks if no properties are set
	 * @return bool 
	 */
	public function IsEmpty() {
		return empty($this->propertymap);
	}

	/**
	 * Gets property value
	 * @param string $property Property name
	 * @return string|null
	 */
	public function GetValue($property) {
		$result = NULL;
		if (isset($this->propertymap[(string) $property])) {
			$result = $this->propertymap[(string) $property];
		}
		return $result;
	}

	/**
	 * Adds CSS Class to this object
	 * @param string $classname CSS class name
	 */
	public function AddCSSClass($classname) {
		if (!isset($this->propertymap['class'])) {
			$this->propertymap['class']=$classname;
		}
		else {
			$this->propertymap['class'].=" $classname";
		}
	}
	
	/**
	 * Shows ID?
	 * @param bool $show Bool param to set show or hide ID
	 */
	public function ShowID($show) {
		$this->showID=(bool)$show;
	}
}

/**
 * Represents an xHTML generic item
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
abstract class xHTML_Item {

	/**
	 * UniqueID for this element (must be set in other constructor if accepted!!)
	 * @var string
	 */
	protected $uniqid;

	/**
	 * Contains the tag name without < and >
	 * @var string
	 */
	protected $tagname;

	/**
	 * Contains content of tag either an string or another tag
	 * @var (HTMLText|HTMLItem)[int]
	 */
	protected $contents;

	/**
	 * Contains properties and events of this tag (id, class, etc...)
	 * @var xHTML_Properties
	 */
	protected $properties;

	/**
	 * Should tad be autoclosed?
	 * @var bool
	 */
	protected $autoclosed;

	/**
	 * Enables or disables BBCode for this element
	 * @var bool
	 */
	protected $bbenabled;
	
	/**
	 * Parent
	 * @var xHTML_Item 
	 */
	protected $parent;

	/**
	 * Default constructor
	 * @param string|xHTML_Item $content Content to add
	 */
	public function __construct($content = NULL) {
		$this->autoclosed = false;
		$this->tagname = null;
		$this->contents = null;
		$this->properties = new xHTML_Properties;
		$this->bbenabled = TRUE;
		$this->uniqid = "id" . uniqid();
		$this->parent=NULL;
		if (!is_null($content)) {
			$this->AddContent($content);
		}
	}

	/**
	 * Gets ID for this container
	 */
	public function GetID() {
		return $this->uniqid;
	}
	
	/**
	 * Sets content ID manually (careful, as it has to be unique)
	 * @param string $id Content ID
	 */
	public function SetID($id) {
		$this->uniqid=$id;
		$this->properties->SetProperty("id", $id);
		$this->properties->ShowID(TRUE); //When manually changing ID, implicitly means it will be shown
	}

	/**
	 * Renders and outputs xHTML code
	 */
	public function Render() {
		echo $this->ToString();
	}
	
	/**
	 * Outputs contents as string
	 * @return string
	 */
	public function ToString() {
		$output="";
		if (!empty($this->tagname)) {
			$output.="<" . $this->tagname;
			$propStr=$this->properties->ToString();
			if (!empty($propStr)) {
				$output.=" $propStr";
			}
			if ($this->autoclosed) {
				$output.=" />";
			} else {
				$output.=">";
				for ($i = 0; !empty($this->contents) && $i < count($this->contents); $i++) {
					$output.=$this->contents[$i]->ToString();
				}
				$output.="</" . $this->tagname . ">";
			}
		} else {
			for ($i = 0; !empty($this->contents) && $i < count($this->contents); $i++) {
				$output.=$this->contents[$i]->ToString();
			}
		}
		return $output;
	}

	/**
	 * Sets property
	 * @param string $name Property name
	 * @param string $value Property value
	 */
	protected function SetProperty($name, $value) {
		$this->properties->SetProperty($name, $value);
	}

	/**
	 * Clears a given property
	 * @param string $name Property name
	 */
	protected function ClearProperty($name) {
		$this->properties->ClearProperty($name);
	}

	/**
	 * Replaces content
	 * @param string|xHTML_Item|array $content
	 */
	protected function ReplaceContent($content) {
		if (is_array($content)) {
			$this->contents=$content;
		}
		else {
			$this->contents=array();
			$this->AddContent($content);
		}
	}
	
	/**
	 * Adds contents to tag
	 * @param string|HTMLItem|array $content 
	 */
	protected function AddContent($content) {
		if (is_array($content)) {
			foreach ($content as $key => $addcontent) {
				$this->AddContent($addcontent);
			}
		} else {
			if (is_null($this->contents)) {
				$this->contents = array();
			}
			if (!is_object($content)) {
				if ($this->bbenabled) {
					$addContent=new xHTML_BBCodeText($content);
					array_push($this->contents, $addContent);
					$addContent->parent=$this;
				} else {
					$addContent=new xHTML_FilteredText($content);
					array_push($this->contents, $addContent);
					$addContent->parent=$this;
				}
			} else {
				array_push($this->contents, $content);
				$content->parent=$this;
			}
		}
	}
	
	public function GetParent() {
		return $this->parent;
	}

	/**
	 * Clear content
	 */
	public function ClearContent() {
		$this->contents = null;
	}

	/**
	 * Adds CSS Class to this object
	 * @param string $classname CSS class name
	 */
	protected function AddCSSClass($classname) {
		$this->properties->AddCSSClass($classname);
	}

	/**
	 * Compact text
	 * @param string $text Text
	 */
	protected function CompactText($text) {
		return preg_replace("!(\s|\t|\n)+!", " ", $text);
	}
	
	/**
	 * Sets ID Visibility
	 * @param bool $visible
	 */
	public function SetIDVisibility($visible) {
		$this->properties->ShowID($visible);
	}
	
	/**
	 * Adds content before this one
	 * @param string|xHTML_Item|array $newContent
	 * @throws NullParent
	 */
	protected function AddContentBefore($newContent) {
		if (!is_null($this->parent)) {
			$this->parent->_InsertAtPosition($newContent, array_search($this, $this->parent->contents));
		}
		else {
			throw new NullParent();
		}
	}
	
	/**
	 * Insert element at position
	 * @param string|xHTML_Item|array $newContent new Content to insert
	 * @param int $pos Position to insert element
	 */
	private function _InsertAtPosition($newContent, $pos) {
		$restOfElements=array_splice($this->contents, $pos);
		$this->contents=array_splice($this->contents, 0, $pos);
		//Now we add the content
		$this->AddContent($newContent);
		$this->contents=  array_merge($this->contents, $restOfElements);
	}
	
	/**
	 * Add content before this once
	 * @param string|xHTML_Item|array $newContent New content to add
	 */
	protected function AddContentAfter($newContent) {
		if (!is_null($this->parent)) {
			$this->parent->_InsertAtPosition($newContent, array_search($this, $this->parent->contents)+1);
		}
	}
}

?>

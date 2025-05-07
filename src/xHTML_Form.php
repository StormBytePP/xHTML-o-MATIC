<?php

require_once __DIR__.'/xHTML_Generic.php';
require_once __DIR__.'/xHTML_Script.php';
require_once __DIR__.'/xHTML_Exceptions.php';
require_once __DIR__.'/xHTML_Img.php';

/**
 * Support for xHTML 1.1 <form> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Form extends xHTML_Item {

	/**
	 * Var containing scripts used by this form
	 * @var xHTML_Script[int]
	 */
	private $scripts;

	/**
	 * Contains information about full validation function names
	 * @var string[int]
	 */
	private $fullnames;

	/**
	 * Variable containing an array with form IDs to force to be equal
	 * @var string[int]
	 */
	private $equality;

	/**
	 * Default constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->tagname = "form";
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("accept", "accept-charset", "action", "enctype", "method", "name", "target");
		$this->properties->SetAcceptedValues("enctype", "application/x-www-form-urlencoded", "multipart/form-data", "text/plain");
		$this->properties->SetAcceptedValues("method", "get", "post");
		$this->properties->SetAcceptedValues("target", "_blank", "_self", "_parent", "_top");
		$this->fullnames = array();
		$this->scripts = array();
		$this->SetProperty("id", $this->uniqid);
		$this->equality = array();
	}

	/**
	 * Links scripts from a provided form ***INTERNAL USE ONLY***
	 * @param array $internal_array ['scriptdata']=xHTMLJavaScript, ['mainfunctionname']=string
	 */
	public function LinkScriptFromForm($internal_array) {
		array_push($this->scripts, $internal_array['scriptdata']);
		array_push($this->fullnames, $internal_array['mainfunctionname']);
	}

	/**
	 * Gets all scripts and CREATE the whole parser one
	 * @return xHTMLJavaScript[int]
	 */
	public function GetAllScripts() {
		//Now, we create a main parser function to check ALL fields
		$script = new xHTML_Script;
		$data = "function validateall" . $this->uniqid . "(){ ";
		if (!empty($this->equality)) {
			foreach ($this->equality as $key => $inputs) {
				$data.="if (document.getElementById('" . $inputs[0] . "').value==document.getElementById('" . $inputs[1] . "').value) { markOK" . $inputs[0] . "();markOK" . $inputs[1] . "();}else{markError" . $inputs[0] . "();markError" . $inputs[1] . "();return false;}";
			}
		}
		$data.="var ok=true;var partialOK=true;";
		for ($i = 0; $i < count($this->fullnames); $i++) {
			$data.="partialOK=partialOK && ";
			$data.=$this->fullnames[$i] . "();";
			$data.="ok = ok && partialOK;";
			$data.="partialOK=true;";
		}
		$data.="if (ok) { return true; } else { alert('Ha habido errores, revise los campos en rojo.');return false; } }";
		$script->AddContent($data);
		$this->SetProperty("onsubmit", "return validateall" . $this->uniqid . "();");
		array_push($this->scripts, $script);
		return $this->scripts;
	}

	/**
	 * Set an equality restriction on several inputs (Should be called with param list)
	 */
	public function SetEqualityRestriction($input1, $input2) {
		$current_equality = count($this->equality);
		$this->equality[$current_equality] = array();
		array_push($this->equality[$current_equality], $input1->GetID());
		array_push($this->equality[$current_equality], $input2->GetID());
	}

	/**
	 * Replaces content
	 * @param string|xHTML_Item|array $content Content to replace
	 */
	public function ReplaceContent($content) {
		parent::ReplaceContent($content);
	}
	
	/**
	 * Adds content to form
	 * @param mixed $content 
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

	/**
	 * Sets property
	 * @param string $name
	 * @param string $value 
	 */
	public function SetProperty($name, $value) {
		parent::SetProperty($name, $value);
	}

	/**
	 * Adds a CSS class to this object
	 * @param string $classname CSS class name
	 */
	public function AddCSSClass($classname) {
		parent::AddCSSClass($classname);
	}

	/**
	 * Sets action URI
	 * @param string $URI 
	 */
	public function SetActionURI($URI) {
		$this->SetProperty("action", $URI);
	}

	/**
	 * Sets method (get, post)
	 * @param string $method 
	 */
	public function SetMethod($method) {
		$this->SetProperty("method", $method);
	}

}

/**
 * Support for xHTML 1.1 <input> tag
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Input extends xHTML_Item {

	/**
	 * Contains info about parent form
	 * @var xHTML_Form
	 */
	protected $parentForm;

	/**
	 * Default constructor
	 */
	public function __construct($parent) {
		if (!isset($parent) || empty($parent) || !is_object($parent) || get_class($parent) != 'xHTML_Form') {
			throw new NoParentGiven();
		}
		parent::__construct();
		$this->mycontent = array();
		$this->tagname = "input";
		$this->autoclosed = TRUE;
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("align", "disabled", "maxlength", "name", "readonly", "size", "type", "value");
		$this->properties->SetAcceptedValues("align", "left", "right", "top", "middle", "bottom");
		$this->properties->SetAcceptedValues("disabled", "disabled");
		$this->properties->SetAcceptedValues("readonly", "readonly");
		$this->properties->SetAcceptedValues("type", "button", "checkbox", "file", "hidden", "image", "password", "radio", "reset", "submit", "text");
		$this->SetProperty("id", $this->uniqid);
		$this->parentForm = &$parent;
	}

	/**
	 * Sets value for input
	 * @param string $text Text
	 */
	public function SetValue($text) {
		$t = new xHTML_FilteredText($text);
		$this->SetProperty("value", $t->GetContent());
	}

	/**
	 * Sets property
	 * @param string $name
	 * @param string $value 
	 */
	public function SetProperty($name, $value) {
		parent::SetProperty($name, $value);
	}

	/**
	 * Adds a CSS class to this object
	 * @param string $classname CSS class name
	 */
	public function AddCSSClass($classname) {
		parent::AddCSSClass($classname);
	}

}

/**
 * Specialization for xHTML 1.1 <input> tag for text type
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_InputText extends xHTML_Input {

	/**
	 * Verification Image
	 * @var xHTML_Img
	 */
	protected $img;

	/**
	 * Defines if it has a function filter
	 * @var bool
	 */
	protected $hasfilter;

	/**
	 * Function name for filtering
	 * @var string
	 */
	protected $javascript_function_name;

	/**
	 * Var containing element
	 * @var xHTML_Script
	 */
	protected $javascriptElement;

	/**
	 * Default constructor
	 */
	public function __construct($parent) {
		parent::__construct($parent);
		$this->SetProperty("type", "text");
		$this->javascript_function_name = "";
		$this->hasfilter = FALSE;
	}

	/**
	 * Creates a new filter to only accept provided characters
	 * @param string $acceptedchars String containint accepted chars
	 */
	public function CreateCharValidatorHandler($acceptedchars, $allowempty = FALSE, $isemail = FALSE, $setmaxchars = 0, $isdate = FALSE, $ajaxtestscript = NULL) {
		$this->hasfilter = TRUE;
		global $http_root, $https_root;
		$basedir = "";
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
			$basedir = $https_root . "/IMG/";
		} else {
			$basedir = $http_root . "/IMG/";
		}
		$this->javascript_function_name = "validate" . $this->uniqid;
		$this->javascriptElement = new xHTML_Script();
		$markokscript = "function markOK" . $this->uniqid . "() { obj=document.getElementById('" . $this->uniqid . "');img=document.getElementById('" . $this->uniqid . "_image');img.style.visibility = 'visible';img.src='" . $basedir . "ok.png';img.alt='OK';obj.style.backgroundColor = '#79FB6D';}";
		$markerrorscript = "function markError" . $this->uniqid . "() { obj=document.getElementById('" . $this->uniqid . "');img=document.getElementById('" . $this->uniqid . "_image');img.style.visibility = 'visible';img.src='" . $basedir . "error.png';img.alt='ERROR';obj.style.backgroundColor = '#FF2A2A';}";
		$script = "function " . $this->GetValidatorFunctionName() . "() {var accept='" . $acceptedchars . "';var obj=document.getElementById('" . $this->uniqid . "');var img=document.getElementById('" . $this->uniqid . "_image');";
		if (!$allowempty) {
			$script.="if (obj.value.length==0) { markError" . $this->uniqid . "();return false; }";
		}
		if ($isdate) {
			$script.="var d1 = /^\d{1,2}\/\d{1,2}\/\d{4}$/;";
			$script.="if (!d1.test(obj.value)) { markError" . $this->uniqid . "();return false;} else {markOK" . $this->uniqid . "();return true;}";
		}
		if ($setmaxchars > 0) {
			$script.="if (obj.value.length>" . $setmaxchars . "){markError" . $this->uniqid . "();return false;}";
		}
		if ($isemail) {
			$script.="var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/; if(!filter.test(obj.value)){ markError" . $this->uniqid . "(); return false;}";
		}
		$script.="var ok=true;var ok2=false;var i=0;var j=0;for (i=0; i<obj.value.length && ok; i++) {ok2=false;for (j=0; j<accept.length && !ok2; j++) {ok2=(obj.value.charAt(i) == accept.charAt(j))}ok=ok2;}";
		$script.="if (ok) {markOK" . $this->uniqid . "();return true;}else {markError" . $this->uniqid . "();return false;}}";
		$fullscript = $markokscript . $markerrorscript . $script;
		if (!empty($ajaxcheckscript)) {
			$fullscript.=$ajaxcheckscript;
		}
		$this->javascriptElement->AddContent($fullscript);
		$this->SetProperty("onkeyup", "return " . $this->GetValidatorFunctionName() . "();");
		$this->SetProperty("onchange", "return " . $this->GetValidatorFunctionName() . "();");
		$this->img = new xHTML_Img();
		$this->img->SetAlternativeName("OK");
		$this->img->SetProperty("style", "visibility: hidden");
		$this->img->SetProperty("id", $this->uniqid . "_image");
		$this->img->SetImage($basedir . "ok.png");
		$data['scriptdata'] = $this->javascriptElement;
		$data['mainfunctionname'] = $this->GetValidatorFunctionName();
		$this->parentForm->LinkScriptFromForm($data);
	}

	/**
	 * Creates a handler
	 * @param xHTML_Input[int] $forms 
	 */
	public function CreateEqualValidatorHandler($forms) {
		if (is_array($forms)) {
			foreach ($forms as $key => $form) {
				$this->CreateEqualValidatorHandler($form);
			}
		}
	}

	/**
	 * Renders this element
	 */
	public function Render() {
		parent::Render();
		if ($this->hasfilter) {
			$this->img->Render();
		}
	}

	/**
	 * Get javascript function name FOR COMPLETE PARSING
	 * @return type 
	 */
	private function GetValidatorFunctionName() {
		return $this->javascript_function_name;
	}

	/**
	 * Gets all script data to be handled by a form
	 * @return array ['functiondata']=HTMLJavascriptItem, ['fullfunctionname']=string with the full validator name
	 */
	public function GetAllScriptDataForForm() {
		$result = NULL;
		if ($this->hasfilter) {
			$data = array();
			$data['functiondata'] = $this->javascriptElement;
			$data['fullfunctionname'] = $this->GetFullValidatorFunctionName();
			$result = $data;
		}
		return $result;
	}

}

/**
 * Specialization for xHTML 1.1 <input> tag for password type
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_InputPassword extends xHTML_InputText {

	public function __construct($parent) {
		parent::__construct($parent);
		$this->SetProperty("type", "password");
	}

}

/**
 * Specialization for xHTML 1.1 <input> tag for submit type
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_InputSendButton extends xHTML_Input {

	/**
	 * Constructs a new send button
	 * @param HTMLFormItem $parent Parent Form
	 */
	public function __construct($parent) {
		parent::__construct($parent);
		$this->SetProperty("type", "submit");
	}

}

?>
<?php

require_once __DIR__.'/xHTML_All.php';

/**
 * Support for xHTML 1.0 transitional page
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Page {

	/**
	 * Head
	 * @var xHTML_Head 
	 */
	protected $head;

	/**
	 * Body
	 * @var xHTML_Body 
	 */
	protected $body;

	/**
	 * Page's encoding
	 * @var string
	 */
	protected $encoding;
	
	/**
	 * Sets script text direction
	 * @var string
	 */
	protected $dir;
	
	/**
	 * Language script
	 * @var string
	 */
	protected $lang;
	
	/**
	 * onload function content
	 * @var string
	 */
	protected $onloadFunctionContent;

	/**
	 * Default constructor
	 */
	public function __construct($title="Default Title") {
		$this->onloadFunctionContent="";
		$this->head = new xHTML_Head;
		$this->body = new xHTML_Body;
		$this->head->SetTitle($title);
		$this->encoding = "UTF-8";
		$this->dir="ltr";
		$this->lang="es-Latn";
	}

	/**
	 * Send headers based on what browser reports it accept
	 */
	private function SendHeaders() {
		global $debugmode;
		ob_clean(); //This is really REALLY NEEDED, to avoid PHP puts anything BEFORE document declaration
		$headerSTR="";
		if (!isset($_SERVER['HTTP_ACCEPT']) || strpos($_SERVER['HTTP_ACCEPT'], "application/xhtml+xml")===FALSE) {
			$headerSTR="Content-type: text/html"; //charset=utf-8");
		}
		else {
			$headerSTR="Content-type: application/xhtml+xml"; //charset=utf-8");
		}
		if (!$debugmode) {
			$headerSTR.=" charset=utf-8";
		}
		header($headerSTR);
	}
	
	/**
	 * Displays page in HTML
	 */
	public function Render() {
		if (!empty($this->onloadFunctionContent)) {
			$js=new xHTML_Script();
			$js->AddContent("function initLoad() {".$this->onloadFunctionContent."}");
			$this->head->AddContent($js);
			$this->body->SetProperty("onload", "initLoad();");
		}
		$this->SendHeaders();
		echo $this->ToString();
	}
	
	/**
	 * Gets contents' string
	 * @return string
	 */
	public function ToString() {
		$output='<?xml version="1.0"';
		if (!empty($this->encoding)) {
			$this->head->SetEncoding($this->encoding);
			$output.=' encoding="UTF-8"';
		}
		$output.='?>';
		$output.='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html dir="'.$this->dir.'" xml:lang="'.$this->lang.'" lang="'.$this->lang.'" xmlns="http://www.w3.org/1999/xhtml">';
		/*$copyright = new xHTML_Comment("Created with xHTML-o-MATIC by StormByte ( http://www.stormbyte.org )");
		$copyright->Render();*/
		$output.=$this->head->ToString();
		$output.=$this->body->ToString();
		$output.='</html>';
		return $output;
	}
	
	/**
	 * Adds onload function content
	 * @param string $content Content to add
	 */
	public function AddOnloadFunctionContent($content) {
		$this->onloadFunctionContent.=$content;
	}

	/**
	 * Replaces content
	 * @param string|xHTML_Item|array $content Content to replace
	 */
	public function ReplaceContent($content) {
		$this->body->ReplaceContent($content);
	}
	
	/**
	 * Adds content
	 * @param string $content Content
	 */
	public function AddContent($content) {
		$this->body->AddContent($content);
	}

	/**
	 * Set encoding
	 * @param string $enc Encoding type
	 */
	public function SetEncoding($enc) {
		$this->encoding = $enc;
	}

	/**
	 * Sets meta info
	 * @param xHTML_Meta $meta Meta tag
	 */
	public function AddMetaInfo($meta) {
		if (is_object($meta)) {
			$this->head->AddContent($meta);
		} else {
			throw new WrongArgumentType();
		}
	}

	/**
	 * Sets page title
	 * @param string $title Title
	 */
	public function SetTitle($title) {
		$this->head->SetTitle($title);
	}

	/**
	 * Adds script
	 * @param string|xHTML_JavaScript $script Script to add
	 */
	public function AddScript($script) {
		if (is_string($script)) {
			$jscript=new xHTML_Script();
			$jscript->AddContent($script);
			$this->head->AddContent($jscript);
		}
		else {
			$this->head->AddContent($script);
		}
	}

	/**
	 * Adds a CSS class to this object (the body of the page is the only place where this makes sense)
	 * @param string $classname CSS class name
	 */
	public function AddCSSClass($classname) {
		$this->body->AddCSSClass($classname);
	}

	/**
	 * Sets page icon
	 * @param string $icon_href Icon HREF
	 */
	public function SetIcon($icon_href) {
		$linkOBJ=new xHTML_Link();
		$linkOBJ->SetRel("icon");
		$linkOBJ->SetHREF($icon_href);
		$this->head->AddContent($linkOBJ);
	}
	
	public function SetShortcutIcon($icon_href) {
		$linkOBJ=new xHTML_Link();
		$linkOBJ->SetRel("shortcut icon");
		$linkOBJ->SetHREF($icon_href);
		$this->head->AddContent($linkOBJ);
	}
	
	/**
	 * Adds a JS File
	 * @param string $href File source
	 */
	public function AddJSFile($href) {
		$scriptOBJ=new xHTML_Script();
		$scriptOBJ->SetSrc($href);
		$this->head->AddContent($scriptOBJ);
	}
	
	/**
	 * Adds a CSS file
	 * @param string $href File
	 */
	public function AddCSSFile($href) {
		$linkOBJ=new xHTML_Link();
		$linkOBJ->SetHREF($href);
		$linkOBJ->SetRel("stylesheet");
		$linkOBJ->SetType("text/css");
		$this->head->AddContent($linkOBJ);
	}
	
	/**
	 * Adds an style
	 * @param string|xHTML_Style $style Style
	 */
	public function AddStyle($style) {
		$obj=(is_a($style, "xHTML_Style")) ? $style : new xHTML_Style($style);
		$this->head->AddContent($obj);
	}
	
	/**
	 * Adds style to body
	 * @param string $style CSS style string
	 */
	public function AddStyleToBody($style) {
		$this->body->SetProperty("style", $style);
	}
	
	/**
	 * Sets text direction
	 * @param string $dir Text direction (ltr, rtl)
	 */
	public function SetTextDirection($dir) {
		$this->dir=$dir;
	}
	
	/**
	 * Sets HTML Language tag
	 * @param string $lang Language (according to xml:lang attribute!)
	 */
	public function SetHTMLLanguage($lang) {
		$this->lang=$lang;
	}
}

?>
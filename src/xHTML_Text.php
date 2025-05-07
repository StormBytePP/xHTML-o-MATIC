<?php

require_once __DIR__.'//xHTML_Generic.php';

/**
 * Support for plain text
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
abstract class xHTML_Text extends xHTML_Item {

	/**
	 * Unfiltered text
	 * @var string
	 */
	protected $text;

	/**
	 * Default constructor
	 */
	public function __construct($text = "") {
		$this->text = $text;
	}

	/**
	 * Replaces content
	 * @param string $content
	 */
	public function ReplaceContent($content) {
		$this->text=$content;
	}
	
	/**
	 * Adds text to current one
	 * @param string $text Text
	 */
	public function AddContent($text) {
		$this->text.=$text;
	}

	/**
	 * Sets content erasing previous content
	 * @param string $text 
	 */
	public function SetContent($text) {
		$this->text = $text;
	}

	/**
	 * Clears content
	 */
	public function ClearContent() {
		$this->text = "";
	}

	/**
	 * Gets content
	 * @return string
	 */
	public function GetContent() {
		return $this->text;
	}

	/**
	 * Renders text
	 */
	public function Render() {
		echo $this->ToString();
	}
	
	/**
	 * Gets contents' string
	 * @return string
	 */
	public function ToString() {
		return $this->text;
	}

}

/**
 * Support for HTML safe filtered text
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_FilteredText extends xHTML_Text {

	/**
	 * Default constructor
	 */
	public function __construct($text = "") {
		parent::__construct($text);
	}

	/**
	 * Filters and renders text in an HTML form
	 */
	public function Render() {
		echo $this->ToString();
	}
	
	/**
	 * Gets contents' string
	 * @return string
	 */
	public function ToString() {
		$output=$this->Filter();
		return nl2br($output);
	}

	/**
	 * Filters text to comply with HTML special chars
	 * @return string
	 */
	protected function Filter() {
		return htmlentities($this->text, ENT_QUOTES | ENT_IGNORE);
	}

	/**
	 * Gets filtered text
	 * @return string
	 */
	public function GetText() {
		return $this->Filter();
	}

}

/**
 * Support for BBCode text
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_BBCodeText extends xHTML_FilteredText {

	/**
	 * Constructor
	 * @param string $text Text to initialize with 
	 */
	public function __construct($text = "") {
		parent::__construct($text);
	}

	/**
	 * Renders BBCode text as xHTML
	 */
	public function Render() {
		echo $this->Render();
	}
	
	/**
	 * Gets contents' string
	 * @return string
	 */
	public function ToString() {
		$filtered = $this->Filter();
		$fixedBBCode = $this->FixBBCode($filtered);
		return $this->ParseBBCode($fixedBBCode);
	}

	/**
	 * Parses BBCode to HTML
	 * @param string $BBCode BBCode to parse to HTML
	 * @return string
	 */
	private function ParseBBCode($BBCode) {
		$bbcode = array(
		    "[list]", "[li]", "[/list]", "[/li]", "[br]",
		    "[ul]", "[ol]", "[/ul]", "[/ol]",
		    "[img]", "[/img]",
		    "[b]", "[/b]",
		    "[u]", "[/u]",
		    "[i]", "[/i]",
		    '[color="', "[/color]", "[color='",
		    '[size="', "[/size]", "[size='",
		    '[url="', "[/url]", "[url='",
		    "[mail=\"", "[/mail]", "[mail=\"",
		    "[code]", "[/code]",
		    "[quote]", "[/quote]",
		    '"]', "']");
		$htmlcode = array(
		    "<ul>", "<li>", "</ul>", "</li>", "<br />",
		    "<ul>", "<ol>", "</ul>", "</ol>",
		    "<img src=\"", "\">",
		    "<b>", "</b>",
		    "<u>", "</u>",
		    "<i>", "</i>",
		    "<span style=\"color:", "</span>", "<span style=\"color:",
		    "<span style=\"font-size:", "</span>", "<span style=\"font-size:",
		    '<a target="_blank" href="', "</a>", '<a target="_blank" href="',
		    "<a href=\"mailto:", "</a>", "<a href=\"mailto:",
		    "<code>", "</code>",
		    "<table width=100% bgcolor=lightgray><tr><td bgcolor=white>", "</td></tr></table>",
		    '">', '">');
		return nl2br(str_replace($bbcode, $htmlcode, $BBCode));
	}

	/**
	 * Autocloses (if neccesary) unclosed BBCode tags
	 * @param string $text Text to fix
	 * @return string 
	 */
	private function FixBBCode($text) {
		/**
		 * We parse ALL BBCode and if there are unclosed tags, we autoclose it
		 */
		$stack_depth = -1;
		$stack_tag = array();
		$fixed_text = "";
		$position = 0;
		while ($position < strlen($text)) {
			if ($text[$position] != '[') {
				$fixed_text.=$text[$position];
				$position++;
			} else {
				//Maybe we are in front of a tag!
				$isclosing;
				$tag = $this->GetTagName($text, $position, $isclosing);
				if ($this->IsBBTagValid($tag)) {
					if (!$isclosing) {
						$stack_tag[++$stack_depth] = $tag;
						$fixed_text.="[" . $tag . "]";
					} else {
						//This is a closing tag, but is it valid in this context?
						if ($stack_tag[$stack_depth] == $tag) {
							$stack_depth--; //This is a valid closing tag, so we reduce stack
							$fixed_text.="[/" . $tag . "]";
						}
					}
				} else {
					//Since this is NOT a valid tag, we render it as plain text
					$fixed_text.="[";
					if ($isclosing) {
						$fixed_text.="/";
					}
					$fixed_text.=$tag . "]";
				}
			}
		}
		//If stack is NOT valid, then we autoclose tags
		for ($i = $stack_depth; $i >= 0; $i--) {
			$fixed_text.="[/" . $stack_tag[$i] . "]";
		}
		return $fixed_text;
	}

	/**
	 * Gets tag name (MUST be called while we are at [ pos)
	 * @param string $text
	 * @param int $pos
	 * @param bool $isclosing
	 * @return string
	 */
	private function GetTagName($text, &$pos, &$isclosing) {
		$tagname = "";
		$ignoremode = false;
		$pos++;
		if ($text[$pos] == '/') {
			$pos++;
			$isclosing = true;
		} else {
			$isclosing = false;
		}
		while ($pos < strlen($text) && $text[$pos] != ']') {
			if ($text[$pos] == '"' || $text[$pos] == "'") {
				$ignoremode = !$ignoremode;
			}
			if (!$ignoremode && $text[$pos] != "=") {
				$tagname.=$text[$pos];
			}
			$pos++;
		}

		$pos++;
		return $tagname;
	}

	/**
	 * Checks if this BB code is valid
	 * @param string $tag Tag name to check
	 * @return bool
	 */
	private function IsBBTagValid($tag) {
		$result = false;
		if ($tag == "list" || $tag == "li" || $tag == "ul"
			|| $tag == "ol" || $tag == "img" || $tag == "b" || $tag == "u" || $tag == "i"
			|| $tag == 'color' || $tag == "size" || $tag == 'url' || $tag == "mail" || $tag == "code" || $tag == "quote") {
			$result = true;
		}
		return $result;
	}

}

/**
 * Support for unfiltered text
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_UnfilteredText extends xHTML_Text {

	/**
	 * Constructor
	 * @param string $text 
	 */
	public function __construct($text = "") {
		parent::__construct($text);
	}

}

?>
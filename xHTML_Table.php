<?php

require_once __DIR__.'//xHTML_Generic.php';

/**
 * Support for xHTML 1.1 <table> tag with advanced handling
 *
 * @author	David Carlos Manuelda <stormbyte@gmail.com>
 * @package	xHTML-o-MATIC
 * @version	1.0.0
 */
class xHTML_Table extends xHTML_Item {

	/**
	 * This will be an array
	 * @var xHTML_Item[int][int]
	 */
	private $tablecontents;

	/**
	 * Properties for a row
	 * @var xHTML_Properties[int]
	 */
	private $rowproperties;

	/**
	 *
	 * @var xHTML_Properties[int][int]
	 */
	private $cellproperties;

	/**
	 * Default constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->tagname = "table"; //not used since I will have my own Render
		$this->properties->SetGeneralAttributes();
		$this->properties->SetGeneralEventAttributes();
		$this->properties->SetAcceptedNames("align", "bgcolor", "border", "cellpadding", "cellspacing", "frame", "rules", "summary", "width");
		$this->properties->SetAcceptedValues("align", "left", "right", "center", "justify");
		$this->properties->SetAcceptedValues("frame", "void", "above", "below", "hsides", "lhs", "rhs", "vsides", "box", "border");
		$this->properties->SetAcceptedValues("rules", "none", "groups", "rows", "cols", "all");
		$this->rowproperties = array();
		$this->cellproperties = array();
		$this->bbenabled = TRUE;
		$this->SetProperty("id", $this->uniqid);
	}

	/**
	 * Configure row properties
	 * @param int $row Row number 
	 */
	private function ConfigureRowProperties($row) {
		/** Row properties config * */
		if (!isset($this->rowproperties[(int) $row])) {
			$this->rowproperties[(int) $row] = new xHTML_Properties;
			$this->rowproperties[(int) $row]->SetGeneralAttibutes();
			$this->rowproperties[(int) $row]->SetGeneralEventAttributes();
			$this->rowproperties[(int) $row]->SetAcceptedNames("align", "bgcolor", "char", "charoff", "valign");
			$this->rowproperties[(int) $row]->SetAcceptedValues("align", "right", "left", "center", "justify", "char");
			$this->rowproperties[(int) $row]->SetAcceptedValues("valign", "top", "middle", "bottom", "baseline");
			$this->rowproperties[(int) $row]->SetAcceptedValues("dir", "rtl", "ltr");
		}
	}

	/**
	 * Configure cell properties
	 * @param int $i Row number
	 * @param int $j Cell number
	 */
	private function ConfigureCellProperties($i, $j) {
		/** Cell properties config * */
		if (!isset($this->cellproperties[(int) $i][(int) $j])) {
			if (!isset($this->cellproperties[(int) $i])) {
				$this->cellproperties[(int) $i] = array();
			}
			$this->cellproperties[(int) $i][(int) $j] = new xHTML_Properties();
			$this->cellproperties[(int) $i][(int) $j]->SetGeneralAttributes();
			$this->cellproperties[(int) $i][(int) $j]->SetGeneralEventAttributes();
			$this->cellproperties[(int) $i][(int) $j]->SetAcceptedNames("abbr", "align", "axis", "bgcolor", "char", "charoff", "colspan", "headers", "height", "nowrap", "rowspan", "scope", "valign", "width");
			$this->cellproperties[(int) $i][(int) $j]->SetAcceptedValues("align", "left", "right", "center", "justify", "char");
			$this->cellproperties[(int) $i][(int) $j]->SetAcceptedValues("scope", "col", "colgroup", "row", "rowgroup");
			$this->cellproperties[(int) $i][(int) $j]->SetAcceptedValues("valign", "top", "middle", "bottom", "baseline");
		}
	}

	/**
	 * Adds content to matrix
	 * @param row $i
	 * @param column $j
	 * @param xHTML_Item|string $content Content to add
	 */
	public function AddContentMatrix($i, $j, $content) {
		if (!is_object($content)) {
			$this->tablecontents[$i][$j]['content'] = new xHTML_BBCodeText($content);
		} else {
			$this->tablecontents[$i][$j]['content'] = $content;
		}
	}

	/**
	 * Set property for a row
	 * @param int $row Row number
	 * @param string $property Property name
	 * @param string $value Property value
	 */
	public function SetRowProperty($row, $property, $value) {
		$this->ConfigureRowProperties($row);
		$this->rowproperties[(int) $row]->SetProperty($property, $value);
	}

	/**
	 * Add a property to a cell
	 * @param int $row Row number
	 * @param int $column Column
	 * @param string $property Property name
	 * @param string $value Property value
	 */
	public function SetCellProperty($row, $column, $property, $value) {
		$this->ConfigureCellProperties($row, $column);
		$this->cellproperties[(int) $row][(int) $column]->SetProperty($property, $value);
	}

	/**
	 * Renders the table
	 */
	public function Render() {
		echo $this->ToString();
	}
	
	/**
	 * Gets contents' string
	 * @return string
	 */
	public function ToString() {
		$maxcolumns = 0;
		$output="";
		foreach ($this->tablecontents as $rownumber => $rowcontent) {
			foreach ($rowcontent as $columnnumber => $columnvalue) {
				$maxcolumns = max($maxcolumns, $columnnumber);
			}
		}
		$output.="<table";
		if (!$this->properties->IsEmpty()) {
			$output.=" ";
			$output.=$this->properties->ToString();
		}
		$output.=">";
		$ignoretds = 0;
		foreach ($this->tablecontents as $rownumber => $rowcontent) {
			$output.="<tr";
			if (isset($this->rowproperties[(int) $rownumber]) && !$this->rowproperties[(int) $rownumber]->IsEmpty()) {
				$output.=" ";
				$output.=$this->rowproperties[(int) $rownumber]->ToString();
			}
			$output.=">";
			for ($i = 0; $i <= $maxcolumns; $i++) {
				if ($ignoretds <= 0) {
					$output.="<td";
					if (isset($rowcontent[$i])) {
						if (isset($this->cellproperties[(int) $rownumber][(int) $i]) && !$this->cellproperties[(int) $rownumber][(int) $i]->IsEmpty()) {
							$output.=" ";
							$output.=$this->cellproperties[(int) $rownumber][(int) $i]->ToString();
							$rowspan = $this->cellproperties[(int) $rownumber][(int) $i]->GetValue("rowspan");
							$colspan = $this->cellproperties[(int) $rownumber][(int) $i]->GetValue("colspan");
							if (!is_null($colspan)) {
								$ignoretds = (int) $colspan;
							}
						}
					}
					$output.=">";
					if (isset($rowcontent[$i])) {
						$output.=$rowcontent[$i]['content']->ToString();
					}
					$output.="</td>";
				}
				$ignoretds--;
			}
			$output.="</tr>";
			$ignoretds = 0;
		}
		$output.="</table>";
		return $output;
	}

	/**
	 * Clears content
	 */
	public function ClearContent() {
		parent::ClearContent();
		$this->tablecontents = array();
	}

	/**
	 * Sets a property
	 * @param string $name Property name
	 * @param string $value Property value
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
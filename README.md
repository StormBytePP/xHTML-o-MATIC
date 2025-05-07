xHTML-o-MATIC
=============

This xHTML-o-MATIC is aimed to provide an OO way to handle, simplify and split the logic process for creating and maintaining a PHP web frontend.

By using this mini framework, you can easily split HTML logic and structure in your code, making your whole project more readable with less HTML embedded to its PHP part while having a powerfull DOM-Like tree for handling the nodes you 
want.

To see more, look at usage_example.php file, which contains useful example with comments on some of key features.

Usage Example
=============
```php
<?php

/*******************************************************************/
/** As it can be seen here, it is very easy to split basic        **/
/** structure (that can be placed in your class constructor)      **/
/** from page's content, that can be dynamically placed in your   **/
/** member functions or similar.                                  **/
/** Of course, its output is 100% xHTML 1.0 Transitional Valid    **/
/*******************************************************************/

require_once '/xHTML_All.php';

/** Creating basic object structure and properties **/
$webPage=new xHTML_Page("My testing page");
$webPage->AddCSSFile("some-css-file.css");
$header=new xHTML_Div();
$header->SetID("header");
$footer=new xHTML_Div();
$footer->SetID("footer");
$contentMainDiv=new xHTML_Div();
$contentMainDiv->SetID("content");

/** Adding and "linking" structure items altogether **/
$webPage->AddContent($header);
$webPage->AddContent($footer);
$footer->AddContentBefore($contentMainDiv); //Demonstration of inserting before an already existing element

$contentMainDiv->AddContent(new xHTML_P("Welcome to the xHTML-o-MATIC test page!")); //Demonstration of dynamic content adition when structure have already been stablished
$contentMainDiv->AddContent(new xHTML_UnparsedCode("<p>And also, it allows to add unparsed code by hand like this <a href='http://www.google.es'>google link</a> inside a p element</p>"));

/** Demonstration of "automatic" table handling, to prevent those annoying <tr> and <td> **/
$table=new xHTML_Table();
$table->SetProperty("align", "center"); //Property set demonstration
$table->SetProperty("border", "1");
$table->SetProperty("width", "60%");
$table->AddContentMatrix(0, 0, new xHTML_P("This is cell 0,0"));
$table->AddContentMatrix(0, 1, new xHTML_P("This is cell 0,1"));
$table->AddContentMatrix(1, 1, "This is cell 1,1"); //No p item, just text, and item 1,0 left empty with no problems
$table->SetCellProperty(1, 1, "align", "right"); //Demonstration for an easy cell property set inside its matrix
$webPage->AddContent($table);

$webPage->Render(); //Renders (outputs) the whole configured page

?>
```
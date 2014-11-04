<?php

/*
 * --------------------------------------------------------------------
 * Used for outputing 
 * --------------------------------------------------------------------
 *This function displays structured information about one or more expressions that includes its type and value. Arrays and objects are explored recursively with values indented to show structure
 */
if( ! function_exists('tt')){
	function tt($array, $noexit=FALSE, $name='')
	{
		echo "<pre class='alert alert-info'>  {$name} ";
		var_dump($array);
		echo "</pre>";
			if($noexit === FALSE){ exit;}
	}
}

/*
 * --------------------------------------------------------------------
 * Used for outputing 
 * --------------------------------------------------------------------
 *This function displays structured information about one or more expressions that includes its type and value. Arrays and objects are explored recursively with values indented to show structure
 */
if( ! function_exists('copyright_time')){
	function copyright_time()
	{
		return date('Y');
	}
}

/*
*-----------------------------------------------------------------------
* Used for defining New Assets Path
*-----------------------------------------------------------------------
*/
if( ! function_exists('asset_vendors')){
	function asset_vendors($pathToFile)
	{
		return url() . '/asset_vendors/'. $pathToFile;
	}
}

/*
*------------------------------------------------------------------------
* Shorthand for Larasset inlinescript
*------------------------------------------------------------------------
*/

if( ! function_exists('setinlinescript') ){
	function setinlinescript($code)
	{
		Larasset::start()->set_inlinescript($code);
	}
}
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

/*
* Generate the current Date in sql formatted Datetime function
*/ 
if(! function_exists('sqldate') ){
	function sqldate($time='', $format=null){
		if( $format == null ){
			$format = 'Y-m-d H:i:s';
		}

		if($time == ''){
			$time = 'now';
		}

		return date( $format, strtotime($time) );
	}
}

if(! function_exists('format_date2')){
	function format_date2($date, $format='jS M, Y'){
		return date($format, strtotime($date));
	}
}

if(! function_exists('format_date3')){
	function format_date3($date){
		return date('M jS, Y', strtotime($date));
	}
}

//This function groups DB result..
//Argument 1: The DB result [object or Array]
//Argument 2: GroupBy [string]
if(! function_exists('groupThem')){
	function groupThem($data, $name){

		$arrayResultx = array();

		//$data = ($orderAsc === False) ? $data : array_reverse($data);
		foreach( $data as $n ){

			//we check if $n is array or object
			$rx = is_array($n) ? $n[$name] : $n->$name;

			$arrayResultx[$name][$rx][] = $n;
		}
		
		//tt($arrayResultx);
		return $arrayResultx;
	}
}

//This function groups DB result..
//Argument 1: The DB result [object or Array]
if(! function_exists('groupByCategory')){
	function groupByCategory($data){

		$arrayResultx = array();
		
			foreach( $data as $n ){
				//tt($n['question']['questionnairesubcategory']['questionnairecategory']);
				//we check if $n is array or object
				$rx = is_array($n) ? $n['question']['questionnairesubcategory']['questionnairecategory']['name'] : $n->question->questionnairesubcategory->questionnairecategory->name;

				$arrayResultx[$rx][] = $n;
			}

		return $arrayResultx;
	}
}


/*
* Accepts string
* @ returns array
*/
if( ! function_exists('sqlDateRange') ){
	function sqlDateRange($range){
		$dateArr = explode('-', $range);

		$from = Carbon::parse($dateArr[0])->toDateTimeString();
		$to = Carbon::parse($dateArr[1])->addDay(1)->toDateTimeString();

		return ['from'=> $from, 'to'=> $to];
	}
}
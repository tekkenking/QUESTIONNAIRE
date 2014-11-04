<?php

class TestapiController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$branches = [ 
				[
					"id" 	=> 1,
					"name" 	=> "Ojodu Berger"
				],

				[
					"id" 	=> 2,
					"name" 	=> "Ebute-Metta"
				],

				[
					"id" 	=> 3,
					"name" 	=> "Victoria Island"
				],

				[
					"id"	=> 4,
					"name"	=> "Ejioku"
				]

		 ];



		//
		$qns = [
			[
				"id"			=> 1,
				"question"		=> "Structure appeal from a distance?",
				"subquestion"	=> false,
				"answer"		=> [
										"type" 			=> "radio",
										"answers"		=> [ "poor", "fair", "good", "excellent" ],
										"answered"		=> 2
									]
			],
			
			[
				"id"			=> 2,
				"question"		=> "List of other banks within close proximity?",
				"subquestion"	=> false,
				"answer"		=> [
										"type"			=> "textareas",
										"answers"		=> ['a','b','c','d'],
										"answered"		=> [
																0 => "Sterling Bank",
																1 => false,
																2 => "Diamond Bank",
																3 => "Fidelity Bank"
															]
									]
			],
		
			[
				"id"			=> 3,
				"question"		=> "Directional signs(way-finding hanging, door, desk, etc)?",
				"subquestion"	=> [
									[ 
										"question"	=> "Properly positioned",
										"label"		=> "a",
										"answer" 	=> [
														"type" 		=> "radio",
														"answers" 	=> [ "yes", "no" ],
														"answered"	=> 1
														]
									],
									
									[ 	
										"question"	=> "Provide good direction", 
										"label"		=> "b",
										"answer" 	=> [
														"type" 		=> "radio",
														"answers" 	=> [ "yes", "no" ],
														"answered"	=> 0
														]
									],
									
									[ 
										"question"	=> "Adequacy", 
										"label"		=> "c",
										"answer" 	=> [
														"type" 		=> "radio",
														"answers" 	=> [ "poor", "fair", "good", "excellent" ],
														"answered"		=> false
														]
									],
									
									[ 
										"question"	=> "Visibility", 
										"label"		=> "d",
										"answer" 	=> [
														"type" 		=> "radio",
														"answers" 	=> [ "poor", "fair", "good", "excellent" ],
														"answered"		=> false
														]
									],
									
									[ 
										"question"	=> "Easy to understand", 
										"label"		=> "e",
										"answer" 	=> [
														"type" 		=> "radio",
														"answers" 	=> [ "poor", "fair", "good", "excellent" ],
														"answered"		=> 2
														]
									]
									
								  ],
				"answer"		=> false
									
			],
		
			[
				"id"			=> 4,
				"question"		=> "Is the corporate flag hosited(outside Lagos locations only)?",
				"subquestion"	=> false,
				"answer"		=> [
										"type" 			=> "radio",
										"answers"		=> [ "no", "yes" ],
										"answered"		=> 0
									]
			],
			
			[
				"id"			=> 5,
				"question"		=> "Select First Bank locations in the options below?",
				"subquestion"	=> false,
				"answer"		=> [
										"type" 			=> "checkbox",
										"answers"		=> [ "no", "yes" ],
										"answered"		=> [
																0 => true,
																1 => false
															]
									]
			]
		];

		$data['x'] = [
			'branches' 	=> $branches,
			'qns'		=> $qns
		];

		//dd($data);

		return Response::json($data)->setCallback(Input::get('callback'));
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}

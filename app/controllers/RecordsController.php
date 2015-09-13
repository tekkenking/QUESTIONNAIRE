<?php

use libs\Repo\Record\Record_Eloquent as Record;
use libs\Repo\Record\Form\Record_form as Form;

use libs\Repo\Branch\Branch_Eloquent as Branch;
use libs\Repo\Staff\Staff_Eloquent as Staff;

class RecordsController extends \SecureBaseController {

	public function __construct( Record $record, Form $form, Branch $branch, Staff $staff )
	{
		parent::__construct();

		$this->record = $record;
		$this->form = $form;
		$this->branch = $branch;
		$this->staff = $staff;
	}

	/**
	 * Display a listing of records
	 *
	 * @return Response
	 */
	public function index()
	{
		$js = [
				
				'select2,3.5.2'		=>	[
					'select2'				=>	'select2.min.js'
				],

				'bootstrap-daterangepicker'	=> [
					'bootstrap-daterangepicker'	=> 'daterangepicker.js'
				],

				'print-this'	=>	[
					'print-this'				=>	'print-this.js'
				],

				/*'rasterizeHTML,src'	=>	[
					'rasterizeHTML'				=>	'rasterize.allinone.js',
				],

				'jsPDF-master,dist'	=>	[
					'jspdf'						=>	'jspdf.debug.js',
					'html2canvas'				=>	'html2canvas.js'
				],*/

				'smart,JS,plugin,x-editable' => [
					'xeditable'					=>	'x-editable.min.js'
				]

		];

		$css = [
				
			   'bootstrap-daterangepicker'	=>	[
			   		'bootstrap-daterangepicker'	=> 'daterangepicker-bs3.css'
			   ]
		];

		Larasset::start('footer')->storeJs($js)->js('bootstrap-daterangepicker', 'select2', 'print-this', 'xeditable');
		Larasset::start('header')->storeCss($css)->css('bootstrap-daterangepicker');

		$this->layout->title = 'Questionnaire - Records';
		$this->layout->content = View::make('records.index');
	}

	public function searchForDate()
	{

		//tt(Input::all());
		$type = Input::get('type');
		$typeid = Input::get('typeid');
		$daterange = Input::get('daterange');
		$page = Input::get('page', 1);
		$take = 10;

		if( $daterange != null ){
			$daterange = $this->form->prepareRange($daterange);
		}

		$data = $this->record->getByDate($type, $typeid, $daterange, $page, $take);
		$results['fordates'] = Paginator::make( $data->items, $data->totalItems, $take );
		$results['pagination_position'] = 'pagination-left';

		$type = 'all';
		return View::make('records.includes.' . $type, $results );
	}

	public function searchByDate()
	{
		$date = Input::get('date');

		$type = Input::get('type');
		$typeid = Input::get('typeid');
		$daterange = [$date, $date];
		$page = Input::get('page', 1);
		$take = 10;

		$data = $this->record->getByBranch($type, $typeid, $daterange, $page, $take);
		$results['bdates'] = Paginator::make( $data->items, $data->totalItems, $take );
		$results['pagination_position'] = 'pagination-right';

		$type = 'all';
		return View::make('records.includes.' . $type, $results );
	}

	public function filterBy($option)
	{

		$result = ( $option === 'branch' ) 
			? $this->branch->listAllForSearchRecord()
			: $this->staff->listAllForSearchRecord();

		$data = Ajaxalert::success($result)->get();

		return Response::json($data);
	}

	public function popover()
	{
		$date = Input::get('date');
		$staffID = Input::get('staff_id');
		$branchID = Input::get('branch_id');

		$dx = $this->record->fetchRecords($date, $staffID, $branchID);

		$data['records'] = groupByCategory($dx);
		$data['branch'] = $this->branch->name($branchID);
		$data['branch_id'] = $branchID;
		$data['staff'] = $this->staff->name($staffID);
		$data['date'] = $date;

		return View::make('records.includes.popover', $data);
	}

	/**
	 * Show the form for creating a new record
	 *
	 * @return Response
	 */
	public function create()
	{
		
	}

	/**
	 * Store a newly created record in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

	}

	/**
	 * Display the specified record.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

	}

	/**
	 * Show the form for editing the specified record.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

	}

	/**
	 * Update the specified record in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

	}

	/**
	 * Remove the specified record from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}

	public function toggleIssue()
	{
		$id =  Input::get('id');
		$model = $this->form->update( $id, Input::all() );
		$data = Ajaxalert::info('Operation done!')->get();
		return Response::json($data);
	}

}

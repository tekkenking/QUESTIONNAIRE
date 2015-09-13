<?php namespace libs\Repo\Record;

use Record as Model;
use \StdClass as StdClass;

class Record_Eloquent implements Record_Interface
{
	public function newModel()
	{
		return new Model;
	}

	public function saveModel(Array $data)
	{
		$model = Model::create($data);
		return $model;
	}

	public function findById($id)
	{
		return Model::find($id);
	}

	public function paginate($model, $page, $take, $totalItems=0)
	{
		  $results = new StdClass;
		  $results->page = $page;
		  $results->limit = $take;
		  $results->totalItems = 0;
		  $results->items = [];

		  $results->totalItems = ($totalItems == 0) ? $model->count() : $totalItems;
		 
		  $records = $model->skip($take * ($page - 1))->take($take)->get();

		  $results->items = $records->all();

		  //tt($results->totalItems, true);
		  //tt($results, true);

		  return $results;
	}

	public function getByDate($type, $typeid, $daterange, $page, $take)
	{
		$m = Model::select('id', 'date');

		if( $typeid != null ){
			$m = $m->where($type, $typeid);
		}

		if( $daterange != null ){
			$m = $m->whereBetween('date', $daterange);
		}

		$m = $m->groupBy('date')->orderBy('date', 'desc');

		return $this->paginate($m, $page, $take, count($m->get()->toArray()));
	}

	public function getByBranch($type, $typeid, $daterange, $page, $take)
	{

		$groupByArr = ['staff_id' => 'branch_id', 'branch_id' => 'staff_id', 'all' => ['staff_id', 'branch_id'] ];

		$m = Model::with([
				'Branch'	=>	function($q){
					$q->select('id', 'name');
				},

				'Staff'		=> function($x){
					$x->select('id', 'name');
				}
			])->select('id', 'branch_id', 'staff_id', 'date');


		if( $typeid != null ){
			$m = $m->where($type, $typeid);
		}

		if( $daterange != null ){
			$m = $m->whereBetween('date', $daterange);
		}

		//tt($m->get()->toArray());

		$m = $m->groupBy($groupByArr[$type]);

		return $this->paginate($m, $page, $take, count($m->get()->toArray()));
	}

	/*
	* Accepts sqlDate Array $date = [2014-11-22 00:00:00, 2014-11-23 00:00:00];
	*/
	public function fetchRecords($date, $staffID, $branchID)
	{
		$model = Model::with([
			'Branch'	=>	function($q){
				$q->select('id', 'name');
			},

			'Staff'		=> function($x){
				$x->select('id', 'name', 'token');
			},

			'Question'	=> function ($qs){
				$qs->with([
						'questionnairesubcategory' => function($qc){
							$qc->with([
								'questionnairecategory' => function($qsc){
									$qsc->select('id', 'name');
								}
							])->select('id', 'questionnairecategories_id', 'name');
						}
					])->select('id', 'questionnairesubcategories_id', 'label', 'question');
			}/*,

			'Issue'		=> function ($is){
				$is->select('id', 'record_id', 'resolved');
			}*/
		]);

		$model = $model->where('date', $date)
						->where('staff_id', $staffID)
						->where('branch_id', $branchID);

		$model = $model->get()->toArray();

		//tt($model);

		return $model;
	}

	public function all()
	{
		return Model::with([
				'Branch' => function($qr){
					$qr->select('id', 'name');
				}
			])
		->get();
	}

	public function byStaff($id)
	{
		return Model::with([
			'Branch'	=>	function($q){
				$q->select('id', 'name');
			},

			'Staff'		=> function($x){
				$x->select('id', 'name', 'token');
			},

			'Question'	=> function ($qs){
				$qs->with([
						'questionnairesubcategory' => function($qc){
							$qc->with([
								'questionnairecategory' => function($qsc){
									$qsc->select('id', 'name');
								}
							])->select('id', 'questionnairecategories_id', 'name');
						}
					])->select('id', 'questionnairesubcategories_id', 'label', 'question');
			}
		])	->where('staff_id', $id)
			->take(10)
			->get();
	}

	public function destroyIssue($id)
	{
		$model = $this->findById($id);
		$model->restore();
		return $model;
	}
}
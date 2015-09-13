{{Form::open( array('route'=>array('questionnairecategories.update', $qcat->id), 'id'=>'update-questionnairecategories', 'method'=>'put') )}}
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">EDIT QUESTION CATEGORY</h4>
</div>

<div class="modal-body">
	<div class="error-msg"></div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<input type="text" class="form-control" name="questioncategory" value="{{$qcat->name}}" placeholder="Edit {{$qcat->name}}" validate="required"/>
			</div>
		</div>
	</div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		Cancel
	</button>
	<button type="button" class="btn btn-primary" id="modal_update_question">
		Update
	</button>
</div>

<input type="hidden" name="id" value="{{{$qcat->id}}}">
{{Form::close()}}

<script type="text/javascript">
	$(function(){
		 $("#modal_update_question").on("click", function (e){
			e.preventDefault();

			$('form#update-questionnairecategories').ajaxrequest({
				msgPlace: '.error-msg',
				redirectDelay: 500,
				validate : { vtype : {
									questioncategory : {
										required : '#Field can not be empty'
											}
								}
							},
				ajaxType: 'PUT'
			});
		});

		 //TO DISABLE ENTER KEY FROM SUBMITTING THE FORM
		$('[name="questioncategory"]').keydown(function(e){ 
			//_debug('keydown');
			if( e.which == 13 ){ 
				e.preventDefault(); 
				//_debug('tueyd');
			}
		});
	})
</script>

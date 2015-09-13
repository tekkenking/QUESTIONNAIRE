{{Form::open( array('route'=>['options.update', $option->id], 'id'=>'update-options', 'role'=>'form') )}}
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">UPDATE RATING SCALE</h4>
</div>

<div class="modal-body">
	<div class="error-msg"></div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<input type="text" class="form-control" name="name" value="{{{$option->name}}}" placeholder="Enter rating" validate="required"/>
			</div>
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<input type="text" class="form-control" name="alias" value="{{{$option->alias}}}" placeholder="Scale" validate="required"/>
			</div>
		</div>

		<!--<div class="col-md-4">
			<div class="form-group">
				<label class="text-bold">
					<input type="checkbox" name="create_issue" value=1  @if( $option->create_issue !== NULL ) checked = "checked"  @endif/>
					Issue auto logger
				</label>
			</div>
		</div>-->
	</div>	

	<div class="alert alert-warning">
		<div class="row">
			<div class="col-md-6">
				Example: <em> Yes </em>
			</div>
			<div class="col-md-2">
				Example: <em> 5 </em>
			</div>

			<!--<div class="col-md-4">
	      		Would log issue ... <a href="#" class="tooltipx" data-original-title="Would log issue on the associated question and branch">more</a>
			</div>-->
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		Cancel
	</button>
	<button type="button" class="btn btn-primary" id="update-option">
		Update
	</button>
</div>

{{Form::close()}}

<script type="text/javascript">
	$(function(){
		 $("#update-option").on("click", function (e){
			e.preventDefault();

			$('form#update-options').ajaxrequest({
				msgPlace: '.error-msg',
				redirectDelay: 500,
				/*validate : { vtype : {
									name : {
										required : '#Question option can not be empty',
										letter	: '#Question option must contain only letters'
											},
									alias : {
										required : '#Option alias can not be empty',
										integer : '#Option alias must contain only digits'
									}
								}
							},*/
				ajaxType: 'PUT',
				ajaxRefresh: '#widget-grid',
				closeButton: true
			});
		});

		$('.tooltipx').tooltip({
			placement : 'bottom'
		});
	})
</script>
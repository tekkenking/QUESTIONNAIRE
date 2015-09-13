
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">Update Staff Info</h4>
</div>
<div class="modal-body">
	{{Form::open( array('route'=>array('staffs.update', $staff->id), 'id'=>'update-staffs', 'method'=>'put') )}}
		<div class="error-msg"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" class="form-control" name="name" placeholder="Staff name" required value="{{$staff->name}}" />
				</div>
			</div>
		</div>
		<!--<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="category"> Status</label>
					<select class="form-control" id="category" name="active">
						<option value="1">Active</option>
						<option value="0">Not Active</option>
					</select>
				</div>
			</div>
		</div>-->
	{{Form::close()}}
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		Cancel
	</button>
	<button type="submit" class="btn btn-primary" id="modal_add_staff">
		<i class="fa fa-plus"></i> Update
	</button>
</div>


<script type="text/javascript">
	$(function(){
		$("#modal_add_staff").on("click", function(e){
			e.preventDefault();
			$('form#update-staffs').ajaxrequest({
				msgPlace: '.error-msg',
				redirectDelay: 500,
				ajaxType: 'PUT'
			});
		});
	});
</script>
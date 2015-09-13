
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">Create Staff</h4>
</div>
<div class="modal-body">
	{{Form::open( array('route'=>'staffs.store', 'id'=>'store-staffs') )}}
		<div class="error-msg"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" class="form-control tm-input tm-input-success tm-input-large" name="name" placeholder="Staff name" required />
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
		<i class="fa fa-plus"></i> Create
	</button>
</div>


<script type="text/javascript">
	$(function(){
		$("#modal_add_staff").on("click", function(e){
			e.preventDefault();
			$('form#store-staffs').ajaxrequest({
				msgPlace: '.error-msg',
				redirectDelay: 500
			});
		});

		$(".tm-input").tagsManager({
			tagCloseIcon : '<i class="fa fa-times"></i>',
			hiddenTagListName: 'name'
		});
	});
</script>
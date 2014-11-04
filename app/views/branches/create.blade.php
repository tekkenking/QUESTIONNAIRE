
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">Create Branch</h4>
</div>
<div class="modal-body">
	{{Form::open( array('route'=>'branches.store', 'id'=>'store-branches') )}}
		<div class="error-msg"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" class="form-control" name="name" placeholder="Branch name" required />
				</div>
				<div class="form-group">
					<textarea class="form-control" name="note" placeholder="Note" rows="5" required></textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="category"> Status</label>
					<select class="form-control" id="category" name="active">
						<option value="1">Active</option>
						<option value="0">Not Active</option>
					</select>
				</div>
			</div>
		</div>
	{{Form::close()}}
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		Cancel
	</button>
	<button type="submit" class="btn btn-primary" id="modal_add_branch">
		<i class="fa fa-plus"></i> Add
	</button>
</div>


	<script type="text/javascript">
		$(function(){
			$(document).on("click", "#modal_add_branch", function(e){
				e.preventDefault();
				$('form#store-branches').ajaxrequest({
					msgPlace: '.error-msg',
					redirectDelay: 500
				});
			});
		});
	</script>
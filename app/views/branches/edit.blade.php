
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">Update Branch</h4>
</div>
<div class="modal-body">
	{{Form::open( array('route'=>array('branches.update', $branch->id), 'id'=>'update-branches', 'method'=>'put') )}}
		<input type="hidden" name="id" value={{{$branch->id}}}>
		<div class="error-msg"></div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<input type="text" class="form-control" name="name" value="{{{$branch->name}}}" placeholder="Branch name" />
				</div>
				<div class="form-group">
					<textarea class="form-control" name="note" placeholder="Note" rows="2">{{{$branch->note}}}</textarea>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="category"> Status</label>
					<select class="form-control" id="category" name="active">
						<option value="1"  @if( $branch->active === 1 ) selected="selected" @endif >Active</option>
						<option value="0" @if( $branch->active === 0 ) selected="selected" @endif>Not Active</option>
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
	<button type="submit" class="btn btn-primary" id="modal_update_branch">
		 Update Changes
	</button>
</div>


	<script type="text/javascript">
		$(function(){
			$(document).on("click", "#modal_update_branch", function(e){
				e.preventDefault();
				$('form#update-branches').ajaxrequest({
					msgPlace: '.error-msg',
					redirectDelay: 500,
					ajaxType: 'PUT'
				});
			});
		});
	</script>
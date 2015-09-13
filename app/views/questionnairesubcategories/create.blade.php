
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">Create questions sub-category</h4>
</div>
<div class="modal-body">
	{{Form::open( array('route'=>'questionnairesubcategories.store', 'id'=>'qsubcat') )}}
		<div class="error-msg"></div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				<p class="form-control-static">{{{$qcat_name}}}</p>
					<input type="hidden" name="questioncategory" value="{{$qcat_id}}">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
				  <!-- <label for="questionsubcategory"> Question Sub-category</label>-->
					<input type="text" class="form-control tm-input tm-input-success tm-input-large" name="questionsubcategory" placeholder='Enter [ {{{$qcat_name}}} ] sub-category(s)' required value="" />
				</div>
			</div>
		</div>

	{{Form::close()}}
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">
		Cancel
	</button>
	<button type="submit" class="btn btn-primary" id="modal_add_staff">
		<i class="fa fa-plus"></i> Add
	</button>
</div>


<script type="text/javascript">
	$(function(){
		$("#modal_add_staff").on("click", function(e){
			e.preventDefault();
			$('form#qsubcat').ajaxrequest({
				msgPlace: '.error-msg',
				redirectDelay: 500
			});
		});

		$(".tm-input").tagsManager({
			tagCloseIcon : '<i class="fa fa-times"></i>',
			hiddenTagListName: 'questionsubcategory'
		});

	});
</script>
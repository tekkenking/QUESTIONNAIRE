
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">Create questions category</h4>
</div>
<div class="modal-body">
	{{Form::open( array('route'=>'questionnairecategories.store', 'id'=>'qcat') )}}
		<div class="error-msg"></div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<!--<label for="questioncategory"> Question Category</label>-->
					<input type="text" class="form-control tm-input tm-input-success tm-input-large" name="questioncategory" placeholder="Enter question category" required />
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
		<i class="fa fa-plus"></i> Create
	</button>
</div>


<script type="text/javascript">
	$(function(){
		$("#modal_add_staff").on("click", function(e){
			e.preventDefault();
			$('form#qcat').ajaxrequest({
				msgPlace: '.error-msg',
				redirectDelay: 500,
				closeButton: true,
				close: true,
				ajaxRefresh: 'div.tab-pane'
			});
		});

		$(".tm-input").tagsManager({
			tagCloseIcon : '<i class="fa fa-times"></i>',
			hiddenTagListName: 'questioncategory'
		});
	});
</script>
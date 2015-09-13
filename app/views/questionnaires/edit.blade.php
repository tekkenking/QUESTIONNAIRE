
{{Form::open( array('route' => array('questionnaires.update', $id), 'method' => 'put', 'id'=>'update-questionnaires', 'role'=>'form') )}}
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title" id="myModalLabel">EDIT QUESTION</h4>
</div>

<div class="modal-body">
<div class="error-msg"></div>
	
	@include('questionnaires.includes.category_subcategories')

	{{$editquestion}}

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-labeled btn-warning text-regular pull-left hide scrolltotopbutton">
		<span class="btn-label">
			<i class="fa fa-arrow-up fa-lg"></i>
		</span> Scroll to top
	</button>

	<button type="button" class="btn btn-default" data-dismiss="modal">
		Cancel
	</button>
	<button type="button" class="btn btn-primary" id="modal_update_question">
		Update Question
	</button>
</div>
{{Form::close()}}

<script type="text/javascript">
	$(function(){

		//We give the modal box width:70%
		$('.modal-dialog').css({width:'70%'});

		$('.scrolltotopbutton').click(function(e){
			e.preventDefault();
			$('#remoteModal').scrollTo(0);
		});
	})
</script>

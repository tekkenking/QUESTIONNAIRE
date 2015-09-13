<section class="" id="widget-grid">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
			<div id="wid-id-2" role="widget" class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable">

				<header style="display:block;">
					<a href="{{{ URL::route('questionnairecategories.create') }}}" class="btn btn-success btn-xs font-md text-bold" data-toggle="modal" data-target="#remoteModal" data-backdrop="static" style="margin-right:10px">
						<i class="fa fa-plus"></i>
					 	Add Category(s) 
					</a>
				</header>

				<!-- widget div-->
				<div>

					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<table id="datatable_col_reorder" class="table table-striped table-hover" width="100%">

							<thead>
								<tr>
									<th width="3%"></th>
									<th width="5%">#</th>
									<th width="5%">Edit</th>
									<th>Questioncategories</th>
									
									<th width="5%">Delete</th>
								</tr>
							</thead>

							<tbody>
								@if( $qcategories !== null )
									<?php $counter = 0; ?>
									@foreach($qcategories as $qcategory)
									<tr id="qcategory_{{{$qcategory->id}}}">
										<td>
											<input type="checkbox" value="{{{$qcategory->id}}}"  name="checkbox"/>
										</td>


										<td class="font-lg san-regular qns-numbering">
											{{{++$counter}}}
										</td>

										<td class="edit" data-id="{{{$qcategory->id}}}">
											<a href="{{{ URL::route('questionnairecategories.edit', array('questionnairecategories'=>$qcategory->id )) }}}" class="editquestion san-regular" data-toggle="modal" data-target="#remoteModal" data-backdrop="static" style="display:inline-block">
												<i class="fa fa-edit txt-color-pink fa-2x" title="Edit Questionnairecategory"></i>
											</a>
										</td>
										<td class="questioncategoryname">



						<div class="panel-group smart-accordion-default" id="accordion-{{$qcategory->id}}">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">

										<a class="" data-toggle="collapse" data-parent="#accordion-{{$qcategory->id}}" href="#collapse_{{$qcategory->id}}"> 
										<i class="fa fa-fw fa-plus-circle txt-color-green"></i>	
										<i class="fa fa-fw fa-minus-circle txt-color-red"></i>
											{{{$qcategory->name}}}
											
										</a>

									</h4>
								</div>
								<div id="collapse_{{$qcategory->id}}" class="panel-collapse collapse in">
									<div class="panel-body">

										<div class="alert alert-info">
											<a href="{{{ URL::route('questionnairesubcategories.create.forcategory', ['id'=>$qcategory->id]) }}}" class="btn btn-default" data-toggle="modal" data-target="#remoteModal" data-backdrop="static"> 
											<i class="fa fa-plus"></i>
												Add Sub Category 
											</a>
										</div>

											@if( $qcategory->questionnairesubcategories !== null )


												<ul class="list-group">
													@foreach($qcategory->questionnairesubcategories as $subq)
				@if( $subq->name !== 'No sub-category' )									
													<li class="list-group-item">
														<div>
	<a class="" href="{{{URL::route('questionnairesubcategories.edit', ['id'=>$subq->id])}}}" data-toggle="modal" data-target="#remoteModal" data-backdrop="static">
	<i class="fa fa-edit fa-lg"></i> 
</a>
&nbsp; &nbsp;
															<!--<span class="sub-question-label label label-warning">
																-
															</span>-->
															<span class="font-xs san-bold subq-name">			{{{$subq->name}}}
															</span>

<span class="badge bg-color-red qns-count">{{count($subq->questions)}}</span>

															<button class="btn btn-default btn-xs delete-this pull-right" data-deleteurl="{{{URL::route('questionnairesubcategories.destroy', ['id'=>$subq->id])}}}">
															<i class="fa fa-trash-o"></i> 
															</button>

														</div>
													</li>
			@endif
													@endforeach

												</ul>
											@else
											<div> NO QUESTION SUB-CATEGORY </div>
											@endif


									</div>
								</div>
							</div>
						</div>

										</td>


										<td>
											<button class="btn btn-danger btn-xs removeqcat" data-deleteurl="{{{URL::route('questionnairecategories.destroy', ['id'=>$qcategory->id])}}}">
												<i class="fa fa-trash-o"></i> 
											</button>
										</td>
									</tr>
									@endforeach
								@endif
							</tbody>

						</table>
			
					</div>

				</div>


			</div>
		</article>
	</div>
</section>

<script type="text/javascript">
	$(function() {

		$('.delete-this').click(function (e){
			e.preventDefault();

			var $clst = $(this).closest('li.list-group-item');
			var subqCount = $clst.find('.qns-count').text();

			if( subqCount > 0 ){
				$.smallBox({
					title : "<i class='fa fa-warning fa-2x'></i> <span class='text-bold font-md display-inline-block'> Stop !!!</span>",
					content : '<span class="text-bold">This can not be deleted, because it has question(s). To delete, go back and delete the question(s) under this sub-category</span>',
					color : "#db8b47",
					timeout : 8000
				});

				return false;
			}

			$(this).deleteThis({
				targetParent : '.list-group-item',
				targetName : '.subq-name'
			});
		});

		//Data table
		$("#datatable_col_reorder").dataTable({
			"aoColumns": [
							{ "bSortable": false },
					      	null,
					       	{ "bSortable": false },
					       	null,
					      	{ "bSortable": false }
					    ]
		});
 
		//Remove question
		$(".removeqcat").click(function (e){
			e.preventDefault();
			e.stopImmediatePropagation();
			//First check if there's are subcategory(s)
			var subcats = $(this).closest('tr').find('.panel-body .list-group .list-group-item').get();
			
			if( subcats.length > 0 ){
				$.smallBox({
					title : "<i class='fa fa-warning fa-2x'></i> <span class='text-bold font-md display-inline-block'> Stop !!!</span>",
					content : '<span class="text-bold">This can not be deleted, because it has sub-category(s)</span>',
					color : "#C46A69",
					timeout : 5000
				});

				return false;
			}

			$(this).deleteThis({
				targetParent : 'tr',
				targetName : '.panel-title a'
			});

		});

		//Counts total number of questions and writes at the Tab as alert
		$('.total-qns-numbering').text(function(index, old){
			return $('.qns-numbering:last').text();
		});

		$('.question-state').click(function(e){
			e.preventDefault();

			var url = $(this).attr('href');

			//_debug(url);

			$.post(url, {state: $(this).data('state')}, function(data){ 
				var response = data.message;

				$('tr#question_'+ response.id +' td.question-state-td a.question-state')
				.data('state', response.stateint)
				.text(response.message)
				.addClass(function(index, current){
					if($(this).hasClass('label-default')){
						$(this).removeClass('label-default');
						return 'label-success';
					}else if($(this).hasClass('label-success')){
						$(this).removeClass('label-success');
						return 'label-default';
					}
				});

			}, 'json');
		});

	});
</script>
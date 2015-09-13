<section class="" id="widget-grid">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
			@if( !empty($categories) )
				@foreach($categories as $cat)
			<div id="wid-id-{{$cat->id}}" role="widget" class="jarviswidget jarviswidget-color-purple">

				<header style="display:block;">
					<span class="text-bold font-sm label questioncategory-label">
						{{$cat->name}}
					</span>
				

					<a href="{{{ URL::route('questionnaires.createbycategory', ['id' => $cat->id]) }}}" class="btn btn-default text-bold pull-right" data-toggle="modal" data-target="#remoteModal" data-backdrop="static" style="margin-right:10px">
						<i class="fa fa-plus"></i>
					 	Add Question(s)
					</a>
				</header>

				<!-- widget div-->
				<div>

					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<table id="" class="datatable_col_reorder table table-striped table-hover" width="100%">

							<thead>
								<tr>
									<!--<th width="3%"></th>-->
									<th width="5%">#</th>
									<th width="5%">Edit</th>
									<th>Questions</th>
									
									<th width="7%">State</th>
									<th width="5%">Delete</th>
								</tr>
							</thead>

		<tbody>
			@if( $cat->questionnairesubcategories !== null )
				@foreach( $cat->questionnairesubcategories as $subcat )
					
					@foreach($subcat->questions as $question)
				<tr id="question_{{{$question->id}}}">
					<!--<td>
						<input type="checkbox" value="{{{--$question->id--}}}"  name="checkbox"/>
					</td>-->


					<td class="font-lg san-regular qns-numbering">
						{{{$question->label}}}
					</td>

					<td class="edit" data-id="{{{$question->id}}}">
					<span>  </span>
						<a href="{{{ URL::route('questionnaires.edit', array('questionnaires'=>$question->id )) }}}" class="editquestion san-regular" data-toggle="modal" data-target="#remoteModal" data-backdrop="static" style="display:inline-block">
							<i class="fa fa-edit txt-color-pink fa-2x" title="Edit Question"></i>
						</a>
					</td>
					<td class="questionname">


							<div class="font-mini align-right text-bold"> {{{$subcat->name}}} </div>
	<div class="panel-group smart-accordion-default" id="accordion-{{$question->id}}">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">

					<a class="collapsed" data-toggle="collapse" data-parent="#accordion-{{$question->id}}" href="#collapse_{{$question->id}}"> 
					<i class="fa fa-fw fa-plus-circle txt-color-green"></i>	
					<i class="fa fa-fw fa-minus-circle txt-color-red"></i>

						{{{$question->question}}}
					</a>

				</h4>
			</div>
			<div id="collapse_{{$question->id}}" class="panel-collapse collapse">
				<div class="panel-body">
					

				@if( $question->has_sub_question == 1 )

					<ul class="list-group">

						@foreach($question->subquestions as $subq)
						<li class="list-group-item">
							<div>
								@if( $subq->answers[0]->answer_type === 'doubleopentext' )
									<?php
										$optFull = explode(':::', $subq->sub_question);
										$optLeft = isset($optFull[0]) ? $optFull[0] : '';
										$optRight = isset($optFull[1]) ? $optFull[1] : '';
									?>
									<div class="row">
										<div class="col-md-1">
											<span class="sub-question-label label label-warning">
												{{{$subq->label}}}
											</span>
										</div>
										<div class="col-md-3">
											<span class="font-xs san-bold">			
												{{{$optLeft}}}
											</span>
										</div>
										<div class="col-md-3">
											<span class="font-xs san-bold">			
												{{{$optRight}}}
											</span>
										</div>
									</div>
								@else
									<span class="sub-question-label label label-warning">
										{{{$subq->label}}}
									</span>
									<span class="font-xs san-bold">			
										{{{$subq->sub_question}}}
									</span>
								@endif
							</div>
								<ol>
								@foreach($subq->answers as $subqAns)

									<li class="list-group-item-text">
										<label>

										@if( $subqAns->answer_type === 'doubleopentext' )

										<div class="row">
											<div class="col-md-6">
												<input type="{{{$subqAns->answer_type}}}" name="sub_question_answer_{{{$subqAns->sub_question_id}}}">
											</div>

											<div class="col-md-6">
												<input type="{{{$subqAns->answer_type}}}" name="sub_question_answer_{{{$subqAns->sub_question_id}}}">
											</div>
											
										</div>

										@else
											<input type="{{{$subqAns->answer_type}}}" name="sub_question_answer_{{{$subqAns->sub_question_id}}}"> {{{$subqAns->options['name']}}}
										@endif

										</label>
									</li>

								@endforeach
								</ol>
						</li>
						@endforeach

					</ul>
				@else
							<ol class="unstyled-list">
							<?php $ansCounter = 0; ?>
							@foreach( $question->answers as $answer )
								<li><?php $ansCounter++; ?> 
									<label>{{{$ansCounter}}}. 

									@if( $answer->answer_type === 'opentext' )
										<input type="text" class="form-control" />
									@else
										<input type="{{{$answer->answer_type}}}" name="question_answer_{{{$question->id}}}"> {{{$answer->options->name}}}
									@endif
									</label>
								</li>
							@endforeach

							</ol>
						@endif


				</div>
			</div>
		</div>
	</div>

					</td>

					<td class="question-state-td">
							<?php
								if($question->active == 1){
									$state = 'Active';
									$label_type = 'label-success';
								}else{
									$state = 'Inactive';
									$label_type = 'label-default';
								}
							?>

							<a href="{{URL::route('questionnaires.togglestate', ['id'=>$question->id])}}" class="label {{{$label_type}}} question-state" data-state="{{{$question->active}}}">{{{$state}}}</a>
					</td>

					<td>
						<button class="btn btn-danger btn-xs single_delete" data-id="{{$question->id}}">
							<i class="fa fa-trash-o"></i> 
						</button>
					</td>
				</tr>
					@endforeach
				@endforeach
			@endif
		</tbody>

						</table>
			
					</div>

				</div>


			</div>
			<hr class="simple">
				@endforeach
			@endif	
		</article>
	</div>
</section>

<script type="text/javascript">
	$(function() {
		//Data table
		$(".datatable_col_reorder").dataTable({
			"aoColumns": [
					      	null,
					       	{ "bSortable": false },
					       	null,
					      	null,
					      	{ "bSortable": false }
					    ]
		});


		//Remove question
		$(".single_delete, .multiple_delete").deleteItemx({
			roleNameClass: "questionname",
			url: "{{URL::route('questionnaires.delete')}}",
			ajaxRefresh: '#widget-grid'
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
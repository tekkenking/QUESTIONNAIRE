<section class="" id="widget-grid">
	<div class="row">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
			<div id="wid-id-2" role="widget" class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable">

				<header style="display:block;">
					<a href="{{{ URL::route('options.create') }}}" class="btn btn-success btn-xs font-md text-bold" data-toggle="modal" data-target="#remoteModal" data-backdrop="static" style="margin-right:10px">
						<i class="fa fa-plus"></i>
					 	Add Rating scale(s) 
					</a>
				</header>

				<!-- widget div-->
				<div>

					<!-- widget content -->
					<div class="widget-body no-padding">
						
						<table id="datatable_col_reorder" class="table table-bordered table-hover" width="100%">

							<thead>
								<tr>
									<th width="5%">#</th>
									<th width="10%">Edit</th>
									<th width="40%">Name</th>
									<th width="20%">Alias</th>
									<!--<th width="20%">Mark as issue</th>-->
									<th width="5%">Delete</th>
								</tr>
							</thead>

							<tbody>
								@if( $options !== null )
									<?php $counter = 0; ?>
									@foreach($options as $option)
									<tr id="option_{{{$option->id}}}">

										<td class="font-lg san-regular qns-numbering">
											{{{++$counter}}}
										</td>

										<td class="edit" data-id="{{{$option->id}}}">
											<a href="{{{ URL::route('options.edit', array('options'=>$option->id )) }}}" class="editoption san-regular" data-toggle="modal" data-target="#remoteModal" data-backdrop="static" style="display:inline-block">
												<i class="fa fa-edit txt-color-pink fa-2x" title="Edit this option"></i>
											</a>
										</td>
										<td class="option-name text-bold">
											<div>
												{{{$option->name}}}
											</div>
										</td>
										<td class="option-alias text-bold">
											{{{$option->alias}}}
										</td>										

										<!--<td class="option-create-issue text-bold">
											<span class="hide">{{{$option->create_issue}}}</span>

											<i class="fa @if( $option->create_issue !== NULL ) fa-check txt-color-green @else fa-times txt-color-red @endif fa-lg"></i>
										</td>-->

										<td>
											<button class="btn btn-danger btn-xs removeq_ans" data-deleteurl="{{{URL::route('options.destroy', ['id'=>$option->id])}}}">
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

		//Data table
		$("#datatable_col_reorder").dataTable({
			"aoColumns": [
							{ "bSortable": false },
					      	null,
					       	{ "bSortable": false },
					       	null,
					      	//{ "bSortable": false },
					      	{ "bSortable": false }
					    ],
			"iDisplayLength" : 25
		}
    );

		//Remove question
		$(".removeq_ans").on('click', function (e){
			e.preventDefault();
			e.stopImmediatePropagation();

			$(this).deleteThis({
				targetParent : 'tr',
				targetName : '.option-name'
			});

		});

		//Counts total number of questions and writes at the Tab as alert
		$('.total-qns-numbering').text(function(index, old){
			return $('.qns-numbering:last').text();
		});

		/*$('.question-state').click(function(e){
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
		});*/

	});
</script>
<div class="row">

	<div class="col-sm-12">

			<table class="table table-striped table-forum">
				<thead>
					<tr class="text-bold">
						<th>Question</th>
						<th class="text-center" style="width: 100px;">State</th>
						<th class="text-center" style="width: 110px;">Created at</th>
						<th class="text-center" style="width: 110px;">Ended at</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
					<!-- TR -->

					@if( count($issues) > 0 )
						@foreach( $issues as $issue )
							<tr data-id="{{$issue->id}}">
								<td>
									<h4>
										<div class="text-info">
											{{$issue->question->question}}
										</div>
										
										<div class="text-bold">
											<small class="pull-left">
												{{ucfirst($issue->branch->name)}}
											</small>
											<small class="pull-right">
												{{$issue->staff->name}}
											</small>
										</div>
									</h4>
								</td>

								<td class="text-center issue-state">
									@if( $issue->issue_state == '1' )
										<span class="label label-danger">Unresolved</span>
									@elseif( $issue->issue_state == '2' )
										<span class="label label-default">Fixed</span>
									@else
										<span class="label label-success"><i class="fa fa-thumbs-up fa-lg"></i> Resolved</span>
									@endif
								</td>

								<td class="text-center">
									<small> <span class="font-mini muted text-bold"> {{format_date2($issue->issue_created_at)}} </span> </small>
								</td>

								<td class="text-center">
									<small> 
										<span class="font-mini muted text-bold ended-at"> 

											@if( $issue->issue_state != '1' )
												{{format_date2($issue->updated_at)}} 
											@else
												Not yet!
											@endif
										</span> 
									</small>
								</td>

								<td>
								@if( $issue->issue_state == '1' )
									<div class="dropdown pull-right issue-action">
										<a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);"><i class="fa fa-lg fa-gear"></i></a>
										<ul class="dropdown-menu">
											<li>
												<a href="#" class="resolve-issue" data-question-id="{{$issue->question->id}}">Resolve issue</a>
											</li>
											<li>
												<a href="#" class="delete-issue">Delete issue</a>
											</li>
										</ul>
									</div>
								@endif
								</td>
							</tr>
						@endforeach
					@else

						<tr>
							<td colspan="5">
								<h2>
									No issue found!
								</h2>
							</td>
						</tr>

					@endif
					<!-- end TR -->
					
				</tbody>
			</table>

	</div>

</div>

<script type="text/javascript">
$(function(){

	//That's for deleting
	var deleteIssue = function (e){
		e.preventDefault();
		var $that = $(this), url = "{{route('record.issue.toggle')}}", id, isConfirm;
		id = $that.closest('tr').data('id');

		isConfirm = confirm("This action would delete this issue permanently. Are you sure?");

		if( isConfirm == true ){
			$.post(url, {id : id, toggle : 'remove' }, function (data){
				$('tr[data-id="'+ id +'"]').remove();

				var sideBarIssueCounts = Number($('.sidebar-issue-counter').text());
				$('.sidebar-issue-counter').text( sideBarIssueCounts - 1 );
			});
		}
	}

	$('.delete-issue').on('click', deleteIssue);

	//For resolving
	var resolveIssue = function (e){
		e.preventDefault();

		var $that = $(this), url="{{route('issue.resolve')}}", id, isConfirm;
		id = $that.data('question-id');

		isConfirm = confirm("This would resolve all the pending issues of this question. This can not be undone. Are you sure?");

		if( isConfirm == true ){
			$.post(url, { question_id : id }, function (data){

				//Lets first get all rows to be fixed;
				if( data.fixed_ids !== undefined ){
					$.each( data.fixed_ids, function (index, id){

						$('tr[data-id="'+ id +'"]')
						.find('td.issue-state')
						.html('<span class="label label-default">Fixed</span>')
						.end()
						.find('td div.issue-action')
						.remove()
						.end()
						.find('.ended-at')
						.text( moment().format('Do MMM, YYYY') );

					} );
				}

				//For resolved
				$('tr[data-id="'+ data.resolved_id +'"]')
				.find('td.issue-state')
				.html('<span class="label label-success"><i class="fa fa-thumbs-up fa-lg"></i> Resolved</span>')
				.end()
				.find('td div.issue-action')
				.remove();

				//Lets update sidebar counter
				var sideBarIssueCounts = Number($('.sidebar-issue-counter').text());
				$('.sidebar-issue-counter').text( sideBarIssueCounts - Number(data.total_records_found) );

				//Lets use moment.js to update now as the ended date
				$('tr[data-id="'+ data.resolved_id +'"] .ended-at')
				.text( moment().format('Do MMM, YYYY') );

			}, 'json');
		}
	}

	$('.resolve-issue').on('click', resolveIssue);


});
</script>
<table class="table table-bordered">
	<thead>
		<tr>
			<th width="3%" class="text-center">#</th>
			<th width="92%">
			  <div class="text-center font-lg">Records</div>
			</th>
			<th width="5%" class="text-center">
				<i class="fa fa-eye fa-lg"></i>
			</th>
		</tr>
	</thead>

	<tbody>
 
	@if( !empty($groupedrecords) )

		<?php $counter = 1; ?>
		@foreach($groupedrecords as $branch_id => $records)
			<tr>
				<td>
					<span class="font-lg san-regular qns-numbering">{{$counter++}}.</span>
				</td>
				<td class="content-td">
						
					<div class="panel-group smart-accordion-default" id="accordion-{{$branch_id}}">
						<div class="panel panel-success">
							<div class="panel-heading">
								<h4 class="panel-title branchname">

									<a class="collapsed text-bold" data-toggle="collapse" data-parent="#accordion-{{$branch_id}}" href="#collapse_{{$branch_id}}"> 
									<i class="fa fa-fw fa-plus-circle txt-color-green"></i>	
									<i class="fa fa-fw fa-minus-circle txt-color-red"></i>
										
										{{$records[0]['branch']['name']}}
										
									</a>

								</h4>
							</div>

							<div id="collapse_{{$branch_id}}" class="panel-collapse collapse">
								<div class="panel-body branchcontent">
									<ul class="list-group">
									<?php $qnsCounter = 1; ?>
									@foreach( $records as $list)
										<li class="list-group-item">

											<div class="panel panel-default">
											  <div class="panel-heading" style="padding: 7px">
											    <h3 class="panel-title text-bold"><span class="label label-warning">{{$qnsCounter++}}</span> {{$list['question']}}</h3>
											  </div>
											  <div class="panel-body">
											  	@if( $list['answer'] !== null )
											  		<?php $ansCounter = 1; ?>
											  		<?php $listans = json_decode($list['answer']) ?>

											  		{{--tt($listans, true)--}}

											  			@if( is_array($listans) || is_object($listans))
														   @foreach( $listans as $answer )
														   		<div class="@if( $answer === 'Not answered' ) text-danger @endif question-answer">
														   			<span>{{$ansCounter++}}. </span>
														   			{{{$answer}}}
														   		</div>
														   @endforeach
														@else

														   		<div class="@if( $listans === 'Not answered' ) text-danger @endif question-answer">
														   			<span>{{$ansCounter++}}. </span>
														   			{{$listans}}
														   		</div>

														@endif

												@elseif( $list['subquestion']  !== null )

													<?php $arrSubquestion = json_decode($list['subquestion']); ?>

													@foreach( $arrSubquestion->subquestion as $subquestion => $sbn_arr_answer )

													{{--tt('ehf')--}}

														<div class="text-bold text-primary subquestion-place">
														<?php
															/*$vt = explode('()', $subquestion);
															$labelx = $vt[0];
															$subx = $vt[1];*/
														?>
															{{-- str_replace( '()', '. ', $subquestion) --}}
															{{{$subquestion}}}
														</div>
														
														<?php $sbnAnsCounter = 1; ?>
														@if( is_object($sbn_arr_answer) || is_array($sbn_arr_answer) )

															@foreach( $sbn_arr_answer as $value )
																
																<div class="@if( $value === 'Not answered' ) text-danger @endif subquestion-answer"><span>{{$sbnAnsCounter++}}.</span> {{$value}} </div>
															@endforeach

														@else
													
															<div class="@if( $sbn_arr_answer === 'Not answered' ) text-danger @endif subquestion-answer">
																<span>{{$sbnAnsCounter++}}. </span>
																{{$sbn_arr_answer}}
															</div>
														@endif

													@endforeach

												@endif
											  </div>
											</div>

										</li>
									@endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>
				</td>
				<td>
					<a href="#" class="show-fullscreen">
						<i class="fa fa-expand fa-2x"></i>
					</a>
				</td>
			</tr>
		@endforeach
	@else

		<tr>
			<td></td>
			<td>
				<div class="text-bold font-lg text-info text-center"> <i class="fa fa-frown-o"></i> No result for this date </div>
			</td>
			<td></td>
		</tr>
	@endif
	</tbody>
</table>

<script type="text/javascript">

	$(function(){
		$('.show-fullscreen').on('click', function (e){
			e.preventDefault();

			var $that = $(this);
			var $closestTr = $that.closest('tr');

			$('#fullscreen')
			.find('.modal-title')
			.html(function(index, old){

				return $closestTr.find('td.content-td .panel-title.branchname')
					.text() + '<span class="text-bold text-white"> [ '+ $('.record-date-place').text() +' ]</span>';
			})
			.end()
			.find('.modal-body')
			.html(function(index, old){
				return $closestTr.find('td.content-td .panel-body.branchcontent')
				.html();
			})	
			.end()
			.modal();
		});


		$('.modal-header').inModalStickItOnscroll({
			stickyClass : 'fullscreen-header-affix',
			stickyWrapperClass: 'modal-header',
			positionAjuster: 0,
			winny : '#fullscreen'
		});

		
	});

</script>
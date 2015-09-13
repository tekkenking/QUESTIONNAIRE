<div class="modal-header alert-success">
	<button type="button" class="close no-print" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times fa-lg"></i></span><span class="sr-only">Close</span>
	</button>

	<div id="myModalLabel" class="modal-title">
		<div class="row">
		  	<div class="col-md-6 col-lg-6">

		      <div class="display-inline-block font-md text-bold txt-color-blueDark">
		      	{{format_date2($date, 'F j, Y')}}
		      </div>

		      <div class="label label-success display-inline-block text-bold font-md">
		      	<i class="fa fa-code-fork"></i> {{$branch}}
		      </div>

		      <div class="label label-default display-inline-block text-bold font-md">
              		<i class="fa fa-user"></i> {{$staff}}
		      </div>

		    </div>

		    <div class="col-md-3 col-lg-3">
				<div class="btn-group">

				  	<div class="text-bold hide">
					  <span class="badge bg-color-red issue-counter">0</span>
					  Issues
					</div>

		    	</div>
		    </div>
		  	<div class="col-md-2 col-lg-2">
	          	<div class="pull-right font-md text-bold">
	              <button type="button" class="btn btn-default print-this no-print">
	                  <i class="fa fa-print fa-lg"></i>
	                
	              </button>
		      	</div>
          
		    </div>
	  	</div>
	</div>

</div>

<div class="modal-body" style="">

	@if( !empty($records) )
		@foreach( $records as $categoryname => $recordArr )
			<ul class="list-group">
				<li class="list-group-item bg-color-orange text-bold txt-color-white font-md">
					{{$categoryname}}
				</li>
					@foreach( $recordArr as $record )
					<li class="list-group-item">
						<div class="panel @if( $record['issue_state'] == 1 ) panel-danger @else panel-default @endif">
						  <div class="panel-heading">
						    <h3 class="panel-title">
						    	<div class="display-inline-block label label-warning text-boldx font-sm">
						    		{{$record['question']['label']}}
						    	</div>			    	

						    	<div class="display-inline-block text-bold">
						    		{{$record['question']['question']}}
						    	</div>

						    	 <div class="pull-right issue-button-div">

						    	  	@if( $record['issue_state'] == null )
						    	  		<button data-issue-id="{{$record['id']}}" data-issue-toggle="add" class="pin-issue btn btn-default btn-xs text-bold">Pin as issue</button>

						    	  	@elseif( $record['issue_state'] == 1 )
						    	  		<button data-issue-id="{{$record['id']}}" data-issue-toggle="remove" class="pin-issue btn btn-danger btn-xs text-bold">Unpin issue</button>
						    	  		<span class="font-mini muted text-bold"> {{format_date2($record['issue_created_at'])}} </span>
						    	  	@elseif( $record['issue_state'] == 2 )
						    	  		<span class="label label-default text-bold">Fixed</span>
						    	  		<span class="font-mini muted text-bold"> {{format_date2($record['updated_at'])}} </span>
						    	  	@elseif( $record['issue_state'] == 3 )
						    	  		<span class="label label-success text-bold"> <i class="fa fa-thumbs-up fa-lg"></i> Resolved</span>
						    	  		<span class="font-mini muted text-bold"> {{format_date2($record['updated_at'])}} </span>

						    	  	@endif
						    	  	</button>
						    	</div>
						    </h3>
						  </div>
						  <div class="panel-body">
						    @if( $record['answer'] !== null )

						    	<?php $ansCounter = 1; ?>

						    	<?php $ans = json_decode($record['answer']); ?>

						    	@if( is_array($ans) || is_object($ans) )

						    		@foreach( $ans as $answer )
						    			<div class="@if( $answer === 'Not answered' ) text-danger @endif question-answer">
								   			<span>{{$ansCounter++}}. </span>
								   			{{$answer}}
								   		</div>
						    		@endforeach

						    	@else

						    		<div class="@if( $record['answer'] === 'Not answered' ) text-danger @endif question-answer">
							   			<span>{{$ansCounter++}}. </span>
							   			{{json_decode($record['answer'])}}
							   		</div>

						    	@endif

						    @else

						    	<?php $subquestionArr = json_decode($record['subquestion']); ?>

						    	@foreach( $subquestionArr->subquestion as $subq => $subqAnsArr )

						    		<div class="font-md text-primary subquestion-place">


										<?php
											$vt = explode('()', $subq);
											$labelx = $vt[0];
											$subx = $vt[1];
										?>

						    			<div class="display-inline-block label label-default">{{{$labelx}}} </div>
						    			<div class="display-inline-block text-bold">
						    				@if( strpos($subx, ':::') !== FALSE )
						    				<?php $dotQnsArr = explode(':::', $subx);

						    					$dotQnsLeft = $dotQnsArr[0];
						    					$dotQnsRight = $dotQnsArr[1];
						    				?>
						    					<div class="records-doubleopentext-qns">
							    					<div class="row">
							    						<div class="col-md-12">
								    						<div class="col-md-6">
								    							{{{$dotQnsLeft}}}
								    						</div>
								    						<div class="col-md-6">
								    							{{{$dotQnsRight}}}
								    						</div>
							    						</div>
							    					</div>
						    					</div>
						    				@else
						    					{{{$subx}}}
						    				@endif
						    			</div>
						    		</div>


						    		<?php $sbnAnsCounter = 1; $dotAnsCounter = 0;?>

						    			@if( is_object($subqAnsArr) || is_array($subqAnsArr) )

											@foreach( $subqAnsArr as $value )

												@if( strpos($value, ':::') !== FALSE )

													<?php

														$dotAnsArr = explode(':::', $value);

														$dotAnsLeft = $dotAnsArr[0];
														$dotAnsRight = $dotAnsArr[1];
														$dotAnsCounter++;
													?>

													<div class=" subquestion-answer">
													  <div class="records-doubleopentext-ans">
													  	<div class="row">
													      	<div class="col-md-12">
													          	<div class="col-md-6">
													             <span>{{$dotAnsCounter}}.</span> {{{$dotAnsLeft}}}
													          	</div>
													          
													            <div class="col-md-6">
													              <span>{{$dotAnsCounter}}.</span> {{{$dotAnsRight}}}
													          	</div>
													        </div>
													    </div>
													  </div>
													</div>

												@else
													
													<div class="@if( $value === 'Not answered' ) text-danger @endif subquestion-answer">
													<span>{{$sbnAnsCounter++}}.</span> {{$value}} 
													</div>
												@endif

											@endforeach

										@else
									
											<div class="@if( $subqAnsArr === 'Not answered' ) text-danger @endif subquestion-answer">
												<span>{{$sbnAnsCounter++}}. </span>
												{{$subqAnsArr}}
											</div>
										@endif

						    	@endforeach

						    @endif

						  </div>
						</div>
					</li>
					@endforeach
			</ul>
		@endforeach
	@endif
</div>

<div class="modal-footer bg-color-blueLight no-print">

	<!--<button type="button" class="btn btn-labeled btn-warning text-regular  scrolltotopbutton pull-left">
		<span class="btn-label">
			<i class="fa fa-arrow-up fa-lg"></i>
		</span> Scroll to top
	</button>-->

	<button type="button" class="btn btn-labeled btn-default" data-dismiss="modal">
		<span class="btn-label">
			<i class="glyphicon glyphicon-remove"></i>
		</span>
		Close
	</button>

</div>

<script>

$(function(){

	/*$('.modal-header').inModalStickItOnscroll({
		stickyClass : 'fullscreen-header-affix',
		stickyWrapperClass: 'modal-header',
		positionAjuster: 0,
		winny : '#fullscreen'
	});*/


	$('#fullscreen').on('click', '.print-this', function (e){
		e.stopImmediatePropagation();

		$('.modal-content').printThis({
			pageTitle : "{{format_date2($date, 'F j, Y')}}_{{$branch}}_{{$staff}}"
		});

		//var pdf = new jsPDF('p', 'pt', 'a4');



		/*var specialElementHandlers = {
			'#editor': function(element, renderer){
				return true;
			}
		};

		pdf.fromHTML( 
			$('.modal-content')[0], 
			15,
			15, 
			{ 'width' : 600, 
			'elementHandlers': specialElementHandlers }
		);

		var pdfout = pdf.output('dataurl');*/

		//pdf.addHTML($('.modal-dialog')[0],function() {
		//	pdf.output('dataurl');
		//});

	});


	//Pin as issue
	$('.pin-issue').click(function(e){
		e.preventDefault();

		var url = "{{route('record.issue.toggle')}}",
			id = $(this).data('issue-id'),
			state = $(this).attr('data-issue-toggle'),
			$that = $(this);
		//We log issue
		$.post(url, {id : id, toggle : state }, function (data){

			//Sidebar Notification adjustment
			var sideBarIssueCounts = Number($('.sidebar-issue-counter').text());

			if( state === 'add' ){
				$that.closest('div.panel')
				.removeClass('panel-default')
				.addClass('panel-danger');

				$that.removeClass('btn-default')
				.addClass('btn-danger')
				.text('Unpin issue')
				.attr('data-issue-toggle', 'remove');

				$('.sidebar-issue-counter').text( sideBarIssueCounts + 1 );
			}else{
				$that.closest('div.panel')
				.removeClass('panel-danger')
				.addClass('panel-default');

				$that.removeClass('btn-danger')
				.addClass('btn-default')
				.text('Pin as issue')
				.attr('data-issue-toggle', 'add');

				$that.next('span').remove();

				$('.sidebar-issue-counter').text( sideBarIssueCounts - 1 );
			}

			issuesCounter();

		}, 'json');

	});

			//Count available issue function
		function issuesCounter()
		{
			var counterParent, count = 0;
			count = $('.modal-body')
						.find('[data-issue-toggle="remove"]')
						.get()
						.length;
			$('.issue-counter').text(count);
			
			counterParent = $('.issue-counter').parent();

			if( count > 0 )
			{
				counterParent.removeClass('hide');
			}else{
				counterParent.addClass('hide');
			}

		};

		issuesCounter();

});

</script>
<div class="row">

		<!-- NEW WIDGET START -->
	<article class="col-sm-12 col-md-12 col-lg-12">

		<!-- Widget ID (each widget will need unique ID)-->
		<div class="jarviswidget well" id="wid-id-3" >
			
			<!-- widget div-->
			<div>

				<!-- widget content -->
				<div class="widget-body">

					<div class="row">
						<div class="col-md-12">
								
							<div class="row">

								<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
									<h1 class="page-title text-bold txt-color-blueDark">
										<i class="fa fa-exclamation-circle fa-fw "></i> 
											ISSUES
										
									</h1>
								</div>
								<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
									<div class="btn-toolbar">
										<div class="btn-group pull-right">
											<a href="{{{route('records.index')}}}" class="btn btn-danger text-bold"><i class="fa fa-fw fa-lg fa-database"></i> Back to records</a>
										</div>
									</div>
									
								</div>

							</div>
						</div>
					</div>


					<div class="search-options-bar">
						{{Form::open(['route' => 'issue.search', 'method'=>'get', 'id'=>'issue-filter-form'])}}
						<div class="row">

							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="search-option-left">
								<div class="form-group">
									<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-filter"></i></span>
					                    <div class="icon-addon">
					                       
									<select style="width:100%" class="select2 type-rs" autocomplete="off" name="question_id" id="filter-by-question">
									<option value=""></option>
									<option value="0">All</option>
										@foreach($questions as $value)
											<option value="{{$value->question->id}}">{{$value->question->question}}</option>
										@endforeach
									</select>
					                    </div>
					                    
					                </div>
								</div>
							</div>
							
						</div>


						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
								<div class="form-group">
									<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-filter"></i></span>
					                    <div class="icon-addon">
					                       
											<select style="width:100%" class="select2 name-rs" autocomplete="off" name="branch_id" id="filter-by-branch">
												<option value=""></option>
												<option value="0">All</option>
												@foreach($branches as $value)

													<option value="{{$value->branch->id}}">{{$value->branch->name}}</option>

												@endforeach
											</select>

					                    </div>
					                    
					                </div>
								</div>
							</div>							

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
								<div class="form-group">
									<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-filter"></i></span>
					                    <div class="icon-addon">
					                       
											<select style="width:100%" class="select2 name-rs" autocomplete="off" name="staff_id" id="filter-by-staff">
												<option value=""></option>
												<option value="0">All</option>
												@foreach($staffs as $value)

													<option value="{{$value->staff->id}}">{{$value->staff->name}}</option>

												@endforeach
											</select>
					                    </div>
					                    
					                </div>
								</div>
							</div>					

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4" id="search-option-right">
								<div class="form-group">
									<div class="input-group">
					                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					                   
					                        <input type="text" name="searchdate" class="form-control daterange-rs" placeholder="Date range" autocomplete="off">
					                    
					                </div>
								</div>
							</div>

							<div class="col-xs-12 col-sm-12 col-md-4 col-lg-2" id="search-option-button">
								<button class="btn btn-success btn-block text-bold" id="search-record-button"><i class="fa fa-search fa-lg" type="submit"></i> Search</button>
							</div>
						</div>

						{{Form::close()}}
					</div>

					<hr class="simple">

					<div id="searched-issue-result">
						
						@include('issues.includes.searched_result', $issues)

					</div>
					

				</div>
				<!-- end widget content -->

			</div>
			<!-- end widget div -->

		</div>
		<!-- end widget -->
	</article>	
</div>

<script type="text/javascript">
	$(function(){
		/** DATE RANGE PICKER **/
		$('.daterange-rs').daterangepicker({
			showDropdowns : true,
			opens : 'left',
			format : 'MM/DD/YYYY',
	      	ranges: {
	         'Today': [moment(), moment()],
	         'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
	         'Last 7 Days': [moment().subtract('days', 6), moment()],
	         'Last 30 Days': [moment().subtract('days', 29), moment()],
	         'This Month': [moment().startOf('month'), moment().endOf('month')],
	         'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
	      	},
	      	startDate: moment().subtract('days', 29),
	      	endDate: moment(),
	      	locale: { cancelLabel: 'Clear' }  
		    },

		    function(start, end) {
		        $('#reportrange span').html(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
	    });

		/* SELECT 2 ACTIVATE */
		$('.select2').select2({
			language: "en",
			placeholder: "Filter issue",
			allowClear: true
		});

		$('#filter-by-question').select2({
			placeholder: "Filter by question"
		});

		$('#filter-by-branch').select2({
			placeholder : "Filter by branch"
		});		

		$('#filter-by-staff').select2({
			placeholder : "Filter by staff"
		});


		var filterSearch = function (e){
			e.preventDefault();

			$.get( $(this).prop('action') + '?' + $(this).serialize() )
			.done( function (data) {
				$('#searched-issue-result').html(data);
			});
		}

		//Lets get some issues all the way here
		$('form#issue-filter-form').on('submit', filterSearch);

	});
</script>
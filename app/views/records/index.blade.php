<div class="row">

			<!-- NEW WIDGET START -->
	<article class="col-sm-12 col-md-12 col-lg-12">

		<div class="jarviswidget well">
			
			<div class="widget-body">
				<div class="row">

					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title text-bold txt-color-blueDark">
							<i class="fa fa-database fa-fw "></i> 
								Records
						</h1>
					</div>

					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
						<div class="btn-toolbar">
							<div class="btn-group pull-right">
								<a class="btn btn-warning text-bold" href="{{route('issues.index')}}">
								<i class="fa fa-exclamation-circle"></i> Issues</a>

							</div>
						</div>
					</div>

				</div>

				<div class="search-options-bar row">

					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3" id="search-option-left">
						<div class="form-group">
							<div class="input-group">
			                    <span class="input-group-addon"><i class="fa fa-filter"></i></span>
			                    <div class="icon-addon">
			                       
							<select style="width:100%" class="select2 type-rs" autocomplete="off" name="typex">
								<option value=""></option>
								<option value="all">All Records</option>
								<option value="staff_id">Staff</option>
								<option value="branch_id">Branch</option>
							</select>
			                    </div>
			                    
			                </div>
						</div>
					</div>

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3" id="search-option-middle">
						<div class="form-group">
							<div class="input-group">
			                    <span class="input-group-addon"><i class="fa fa-filter"></i></span>
			                    <div class="icon-addon">
			                       
									<select style="width:100%" class="select2 name-rs" disabled=true autocomplete="off" name="namex">
										<option value=""></option>
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
						<button class="btn btn-success btn-block text-bold" disabled=true id="search-record-button"><i class="fa fa-search fa-lg"></i> Search</button>
					</div>
				</div>

				<hr class="simple">

				<section class="" id="widget-grid">
					<div class="row">
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
							<div id="wid-id-2" role="widget" class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable">
								<header style="display:block;">
									<p class="text-bold text-white record-date font-lg">
									<i class="fa fa-calendar"></i>
									<span class="record-date-place"></span>
									</p>
								</header>

								<div role="content">

									<div class="table-responsive">
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 table-sidebar-left"></div>

											<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 table-sidebar-right"></div>
										</div>
									</div>


								</div>

							</div>
						</article>
					</div>
				</section>

			</div>

		</div>

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
		placeholder: "Filter search record",
		allowClear: true
	});

	/* SEARCH FILTER */
	$('.type-rs').on('change', function(e){

		resetTable();

		var url,
			opt = '<option value=""></option>',
			sel = $(this).val();

			if( sel === '' ){ 
				$('#search-record-button').prop('disabled', true); 
				$('#search-option-middle select').prop('disabled', true); 
			}else{
				$('#search-record-button').prop('disabled', false);
			}

		if( sel !== '' ){

			if( sel === 'all' || sel === ''){
				//we hide the next option

				$('#search-option-middle select')
				.val(function (index, current){
					$(this).find('option:first').attr('selected', 'selected');
					return '';
				})
				.prop('disabled', true)
				.select2('destroy')
				.select2({
					language: "en",
					placeholder: "Filter search record",
					allowClear: true
				});
			}else{
				//We fetch all staffs 
				if( sel === 'staff_id' ){
					url = "{{URL::route('records.filterby', ['option'=>'staff'])}}";
				}else if( sel === 'branch_id'){
					url = "{{URL::route('records.filterby', ['option'=>'branch'])}}";
				}

				$.post(url, function(data){
					$.each(data.message, function(i,v){
						opt += "<option value='"+i+"'> "+ v +" </option>";
					});

					$('#search-option-middle select')
					.html(opt)
					.prop('disabled', false)
					.select2('destroy')
					.select2({
						language: "en",
						placeholder: "Filter search record",
						allowClear: true
					});

				}, 'json');
			}

		}
	});

	$('.name-rs').on('change', function (e){
		resetTable();

		e.preventDefault();
		var url = "{{URL::route('records.search')}}";
		wkx(url);
	});
	
	/* FETCH SEARCHED RECORDS BY AJAX */
	$('#search-record-button').click(function (e){
		e.preventDefault();
		var url = "{{URL::route('records.search')}}";
		wkx(url);
	});

	/* FETCH SEARCHED RECORDS BY PAGINATION IN AJAX */
	$('.widget-body').on('click', '.pagination-left .pagination a, .pagination-left .pager a', function (e){
		e.preventDefault();
		var url = $(this).prop('href');
		wkx(url);
	});

	/* FETCH SEARCHED RECORDS BY PAGINATION IN AJAX */
	$('.widget-body').on('click', '.pagination-right .pagination a, .pagination-right .pager a', function (e){
		e.preventDefault();
		var url = $(this).prop('href'),
			typex = $('.type-rs').select2('val'),
			typeidx = $('.name-rs').select2('val'),
			datex = $("a[data-date].active").data('date');
			$qr = {};
		
		if( typex === '') { return false; }else{ $qr.type = typex; }
		if( typeidx !== '') { $qr.typeid = typeidx; }


		$qr.type = typex;
		$qr.date = datex;

		$.get(url, $qr, function (data){
			$('.table-responsive .table-sidebar-right').html(data);
		});


	});

	// FUNCTION TO PROCESS AJAX REQUET FOR SEARCHED RECORD
	function wkx(url){
		var	typex = $('.type-rs').select2('val'),
			typeidx = $('.name-rs').select2('val'),
			datex = $('.daterange-rs').val(),
			$qr = {};

			if( typex === '') { return false; }else{ $qr.type = typex; }
			if( typeidx !== '') { $qr.typeid = typeidx; }
			if( datex !== '') { $qr.daterange = datex; }

			$.get(url, $qr, function (data){
				//$('.pagination-content').html(data);
				$('.table-responsive .table-sidebar-left').html(data);
				$('.table-responsive .table-sidebar-right').html('');
			});
	}

	$('.widget-body').on('click', '.find-record-by-date', function (e){
		e.preventDefault();

		$('.find-record-by-date').removeClass('active');
		$(this).addClass('active');

		var url = "{{URL::route('records.search.date')}}",
			typex = $('.type-rs').select2('val'),
			typeidx = $('.name-rs').select2('val'),
			datex = $(this).data('date');
			$qr = {};
		
		if( typex === '') { return false; }else{ $qr.type = typex; }
		if( typeidx !== '') { $qr.typeid = typeidx; }


		$qr.type = typex;
		$qr.date = datex;

		$.get(url, $qr, function (data){
			$('.table-responsive .table-sidebar-right').html(data);
		});
	});


	function resetTable(){
		$('.table-responsive .table-sidebar-left, .table-responsive .table-sidebar-right').html('');
	}
});

</script>


<div class="modal fade" id="fullscreen" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">  
    <div class="modal-dialog">  
        <div class="modal-content">
        	<!-- content will be filled here from "ajax/modal-content/model-content-1.html" -->
        </div>  
    </div>  
</div>  
<div class="row">
			<!-- NEW WIDGET START -->
	<article class="col-sm-12 col-md-12 col-lg-12">
		<div class="jarviswidget well" id="" >
			<div class="widget-body">
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title text-bold txt-color-blueDark">
							<i class="fa fa-user fa-fw "></i> 
								Staffs
							
						</h1>
					</div>
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
						<div class="btn-toolbar">
							<div class="btn-group pull-right">
								<a href="{{{route('staffs.create')}}}" class="btn btn-info btn-lg" data-backdrop="static" id="addstaff_button" data-toggle="modal" data-target="#remoteModal"><i class="fa fa-plus"></i> Add</a>
								<a href="#" class="btn btn-danger btn-lg multiple_delete" id="removestaff_button"><i class="fa fa-trash-o"></i> Delete</a>
							</div>
						</div>
					</div>
				</div>

				<section class="" id="widget-grid">
					<div class="row">
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12 sortable-grid ui-sortable">
							<div id="wid-id-2" data-widget-editbutton="false" role="widget" class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable">

								<header style="display:block">
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
								</header>

								<!-- widget div-->
								<div>

									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->

									</div>



									<!-- widget content -->
									<div class="widget-body no-padding">
										
										<table class="table table-stripedx table-bordered table-hover datatable_col_reorder" width="100%">

											<thead>
												<tr>
													<th width="2%"></th>
													<th width="5%">#</th>
													<th width="5%">Edit</th>
													<th>Staffs</th>
													<th>Token</th>
													<th width="2%">N.Pwd</th>
													<th width="2%">Lock</th>
													<th width="7%">Active</th>
													<th width="2%">Del</th>
												</tr>
											</thead>

											<tbody>
												@if( $staffs !== null )
													<?php $counter = 0; ?>
													@foreach($staffs as $staff)
													<tr id="staff_{{$staff->id}}">
														<td>
															<input type="checkbox" value="{{{$staff->id}}}"  name="checkbox"/>
														</td>


														<td>
															<span class="numbering text-bold">{{{++$counter}}}</span>
														</td>

														<td>
															<a href="{{{ URL::route('staffs.edit', array('staffs'=>$staff->id )) }}}" class="editstaff text-bold" data-toggle="modal" data-target="#remoteModal">
															<i class="fa fa-edit fa-2x txt-color-purple"></i>
															</a>
														</td>

														<td class="staffname text-bold">
															<span>{{{$staff->name}}}</span>
															<a href="#" class="view-staff-record"> </a>
														</td>

														<td class="staff-token">
															<span class="text-bold">{{{$staff->token}}}</span>
														</td>
														<td class="td-generate-password">
															<button href="#" class="btn btn-warning btn-xs generate-password" data-toggle="popover">
																<i class="fa fa-key fa-lg"></i>
															</button>

														</td>
														<td class="staff-lock-td">

															@if( $staff->lock == 1 )
																<?php $lockstat ='fa-lock'; ?>
															@else
																<?php $lockstat ='fa-unlock'; ?>
															@endif

															<a href="{{{ URL::route('staffs.lockstatus', array('staffs'=>$staff->id )) }}}" class="staff-lock btn btn-default" data-lock="{{{$staff->lock}}}">
																<i class="fa {{$lockstat}} fa-lg"></i>
															</a>
														</td>

										<td class="staff-state-td">
												<?php
													if($staff->active == 1){
														$state = 'Active';
														$label_type = 'label-success';
													}else{
														$state = 'Inactive';
														$label_type = 'label-default';
													}
												?>

												<a href="{{URL::route('staffs.togglestate', ['id'=>$staff->id])}}" class="label {{{$label_type}}} staff-state" data-state="{{{$staff->active}}}">{{{$state}}}</a>
										</td>

														<td>
															<button class="btn btn-danger btn-xs single_delete">
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
			</div>
		</div>
	</article>
</div>

<script type="text/javascript">
	$(function() {

		/*$('.generate-password').click(function (e){
			e.preventDefault();
			_debug('clicked');
		})*/

		//Generate password
		$('.generate-password').popover({
			placement : 'top',
			title : function () {
				
						var staffname = $(this).closest('tr')
										.find('td.staffname > span')
										.text();
						return "New password: <span class='text-bold'>" + staffname + " </span>";
					},
			content : function(el){
						var stafftoken = $(this).closest('tr')
										.find('td.staff-token > span')
										.text();

						var newpwd = randMoment() * Number(stafftoken);
						return "<div class='label label-primary text-bold font-md display-block'> "+newpwd+" </div>"
					},
			trigger : 'click',
			html : true,
		});

		//Data table
		$(".datatable_col_reorder").dataTable({
		"aoColumns": [
						{ "bSortable": false },
				      	null,
				       	{ "bSortable": false },
				       	null,
				       	null,
				       	{ "bSortable": false },
				       	{ "bSortable": false },
				       	null,
				       	{ "bSortable": false }
				    ]
		});


	$('.staff-state').click(function(e){
		e.preventDefault();

		var url = $(this).attr('href');

		$.post(url, {state: $(this).data('state')}, function(data){ 
			var response = data.message;

			$('tr#staff_'+ response.id +' td.staff-state-td a.staff-state')
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

	$('.staff-lock').click(function(e){
		e.preventDefault();

		var url = $(this).attr('href');

		$.post(url, {lock: $(this).data('lock')}, function(data){ 
			var response = data.message;

			$('tr#staff_'+ response.id +' td.staff-lock-td a.staff-lock')
			.data('lock', response.stateint)
			.find('i')
			.addClass(function(index, current){
				if($(this).hasClass('fa-lock')){
					$(this).removeClass('fa-lock');
					return 'fa-unlock';
				}else if($(this).hasClass('fa-unlock')){
					$(this).removeClass('fa-unlock');
					return 'fa-lock';
				}
			});

		}, 'json');
	});


		//Remove staff
		$(".single_delete, .multiple_delete").deleteItemx({
			roleNameClass: "staffname",
			url: "{{URL::route('staffs.delete')}}",
		});
	});
</script>
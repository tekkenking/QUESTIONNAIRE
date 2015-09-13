<div class="row">
			<!-- NEW WIDGET START -->
	<article class="col-sm-12 col-md-12 col-lg-12">
		<div class="jarviswidget well" id="" >
			<div class="widget-body">
				<div class="row">
					<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
						<h1 class="page-title text-bold txt-color-blueDark">
							<i class="fa fa-code-fork fa-fw "></i> 
								Branches
							
						</h1>
					</div>
					<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
						<div class="btn-toolbar">
							<div class="btn-group pull-right">
								<a href="{{{route('branches.create')}}}" class="btn btn-info btn-lg" id="addbranch_button" data-toggle="modal" data-target="#remoteModal" data-backdrop="static"><i class="fa fa-plus"></i> Add</a>
								<a href="#" class="btn btn-danger btn-lg multiple_delete" id="removebranch_button"><i class="fa fa-trash-o"></i> Delete</a>
							</div>
						</div>
					</div>
				</div>


					<!-- Dynamic Modal -->  
					<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">  
					    <div class="modal-dialog">  
					        <div class="modal-content">
					        	<!-- content will be filled here from "ajax/modal-content/model-content-1.html" -->
					        </div>  
					    </div>  
					</div>  
					<!-- /.modal --> 

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
										
										<table id="datatable_col_reorder" class="table table-stripedx table-bordered table-hover" width="100%">

											<thead>
												<tr>
													<th width="3%"></th>
													<th width="3%">#</th>
													<th width="3%">Edit</th>
													<th>Branch</th>
													<th>Rank</th>
													<th width="12%">Token</th>
													<th width="3%">N.Pwd</th>
													<th width="7%">Active</th>
													<th width="5%">Delete</th>
												</tr>
											</thead>

											<tbody>
												@if( $branches !== null )
													<?php $counter = 0; ?>
													@foreach($branches as $branch)
													<tr id="branch_{{$branch->id}}">
														<td>
															<input type="checkbox" value="{{{$branch->id}}}"  name="checkbox"/>
														</td>


														<td>
															<span class="text-bold">{{{++$counter}}}</span>
														</td>

														<td>
															<a href="{{{ URL::route('branches.edit', array('branches'=>$branch->id )) }}}" class="editbranch text-bold" data-toggle="modal" data-target="#remoteModal">
																<i class="fa fa-edit fa-2x txt-color-purple"></i>
															</a>
														</td>
														<td class="branchname">
															<span class="text-bold">
																{{{ucfirst($branch->name)}}}
															</span>
															
														</td>

														<td class="branchrank bg-color-blueLight">
															<span class="text-bold font-md txt-color-white">
																{{{$branch->rank}}}
															</span>
														</td>

														<td class="branchtoken text-bold">
															{{{$branch->token}}}
														</td>

														<td class="td-generate-password">
															<button href="#" class="btn btn-warning btn-xs generate-password" data-toggle="popover">
																<i class="fa fa-key fa-lg"></i>
															</button>

														</td>

										<td class="branch-state-td">
												<?php
													if($branch->active == 1){
														$state = 'Active';
														$label_type = 'label-success';
													}else{
														$state = 'Inactive';
														$label_type = 'label-default';
													}
												?>

												<a href="{{URL::route('branches.togglestate', ['id'=>$branch->id])}}" class="label {{{$label_type}}} branch-state" data-state="{{{$branch->active}}}">{{{$state}}}</a>
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

		$('.generate-password').popover({
			placement : 'top',
			title : function () {
						var branchname = $(this).closest('tr')
										.find('td.branchname > a')
										.text();
						return "New <span class='text-bold'>" + branchname + " </span>Branch Password";
					},
			content : function(el){
						var branchtoken = $(this).closest('tr')
										.find('td.branchtoken')
										.text();

						var newpwd = randMoment() * Number(branchtoken);
						return "<div class='label label-primary text-bold font-md display-block'> "+newpwd+" </div>"
					},
			//trigger : 'toggle',
			html : true,
		});


		//Data table
		$("#datatable_col_reorder").dataTable({
			"aoColumns": [
						{ "bSortable": false },
				      	null,
				       	{ "bSortable": false },
				       	null,
				       	null,
				       	null,
				       	{ "bSortable": false },
				       	{ "bSortable": false },
				       	{ "bSortable": false }
				    ]
		});


		$('.branch-state').click(function(e){
			e.preventDefault();

			var url = $(this).attr('href');

			//_debug(url);

			$.post(url, {state: $(this).data('state')}, function(data){ 
				var response = data.message;

				$('tr#branch_'+ response.id +' td.branch-state-td a.branch-state')
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

		//Remove Branch
		$(".single_delete, .multiple_delete").deleteItemx({
			roleNameClass: "branchname",
			url: "{{URL::route('branches.delete')}}",
		});
	});
</script>
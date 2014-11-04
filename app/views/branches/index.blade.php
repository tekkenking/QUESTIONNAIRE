<div class="row">
	<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
		<h1 class="page-title txt-color-blueDark">
			<i class="fa fa-code-fork fa-fw "></i> 
				Branches
			<span>&gt; 
				Available
			</span>
		</h1>
	</div>
	<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
		<div class="btn-toolbar">
			<div class="btn-group pull-right">
				<a href="{{{route('branches.create')}}}" class="btn btn-info btn-lg" id="addbranch_button" data-toggle="modal" data-target="#remoteModal"><i class="fa fa-plus"></i> Add</a>
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

				<header>
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
						
						<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover" width="100%">

							<thead>
								<tr>
									<th width="3%"></th>
									<th width="5%">#</th>
									<th>Branch</th>
									<th>Note</th>
									<th width="7%">Active</th>
									<th width="5%">Delete</th>
								</tr>
							</thead>

							<tbody>
								@if( $branches !== null )
									<?php $counter = 0; ?>
									@foreach($branches as $branch)
									<tr>
										<td>
											<input type="checkbox" value="{{{$branch->id}}}"  name="checkbox"/>
										</td>


										<td>
											{{{++$counter}}}
										</td>


										<td class="branchname">
			<a href="{{{ URL::route('branches.edit', array('branches'=>$branch->id )) }}}" class="editbranch" data-toggle="modal" data-target="#remoteModal">{{{$branch->name}}}</a>
										</td>

										<td>
											{{{$branch->note}}}
										</td>

										<td>
											@if( $branch->active == 1 )
												<span class="label label-success">Active</span>
											@else
												<span class="label label-default">Not Active</span>
											@endif
											
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


	<script type="text/javascript">
		$(function() {
			//Data table
			$("#datatable_col_reorder").dataTable();


			//Edit Branch
			$()


			//Remove Branch
			$(".single_delete, .multiple_delete").deleteItemx({
				roleNameClass: "branchname",
				url: "{{URL::route('branches.delete')}}",
			});
		});
	</script>
<div class="">

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
							<div class="col-xs-12 col-sm-7 col-md-7 col-lg-8">
								<h1 class="page-title text-bold txt-color-blueDark">
									<i class="fa fa-folder fa-fw "></i> 
										Question Categories & Sub-categories
								</h1>
							</div>
							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-4">
								<div class="btn-toolbar">
									<div class="btn-group pull-right">
										<a href="{{{route('questionnaires.index')}}}" class="btn btn-danger btn-lg" id="addquestion_button"><i class="fa fa-fw fa-lg fa-long-arrow-left"></i> Go back</a>
									</div>
								</div>
							</div>
						</div>

						<hr class="simple">
						
						<!--<ul id="myTab1" class="nav nav-tabs bordered">
							<li class="active">
								<a href="#s1" data-url="{{{route('questionnairecategories.index')}}}" data-toggle="tab"><span class="badge bg-color-red txt-color-white total-qns-numbering">12</span> Question categories</a>
							</li>					
						</ul>-->

						
							<div class="tab-pane fade in active" id="s1">
								@include('questionnairecategories.includes.cat_list')
							</div>
						

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->
		</article>	
	</div>

</div>

<script type="text/javascript">
$(function(){
	$('[data-url]').ajaxtab();
});
</script>
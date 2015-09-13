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
							<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
								<h1 class="page-title text-bold txt-color-blueDark">
									<i class="fa fa-list-ul fa-fw "></i> 
										Rating Scale Settings
									<span>
										
									</span>
								</h1>
							</div>
							<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
								<div class="btn-toolbar">
									
									<div class="btn-group pull-right">
										<a href="{{{route('questionnaires.index')}}}" class="btn btn-danger btn-lg" id="addquestion_button"><i class="fa fa-fw fa-lg fa-long-arrow-left"></i> Go back</a>
									</div>
								</div>
							</div>
						</div>

						<hr class="simple">

						<div>
							@include('options.includes.answers_list')
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

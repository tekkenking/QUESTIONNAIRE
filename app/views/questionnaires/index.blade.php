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
							<div class="col-md-12">

								<div class="">
									
								<div class="row">

									<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
										<h1 class="page-title text-bold txt-color-blueDark">
											<i class="fa fa-question-circle fa-fw "></i> 
												Questions
											
										</h1>
									</div>
									<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
										<div class="btn-toolbar">
											<div class="btn-group pull-right">
												<a href="{{{route('options.index')}}}" class="btn btn-default btn-lg" id="addquestion_button"><i class="fa fa-fw fa-lg fa-list-ul"></i> Rating Scale Setup <i class="fa fa-fw fa-long-arrow-right"></i></a>
											</div>

											<div class="btn-group pull-right">
												<a href="{{{route('questionnairecategories.index')}}}" class="btn btn-primary btn-lg" id="addquestion_button"><i class="fa fa-fw fa-lg fa-folder"></i> Question Category <i class="fa fa-fw fa-long-arrow-right"></i></a>
											</div>
										</div>
									</div>
									
								</div>

								</div>
									
							</div>
						</div>

						<hr class="simple">

						<div>
							@include('questionnaires.includes.available_categories')
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
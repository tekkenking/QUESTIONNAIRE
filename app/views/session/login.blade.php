<div role="main" id="main">

	<!-- MAIN CONTENT -->
	<div class="container" id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
				<h1 class="txt-color-red login-header-big">SmartAdmin</h1>
				<div class="hero">

					<div class="pull-left login-desc-box-l">
						<h4 class="paragraph-header">It's Okay to be Smart. Experience the simplicity of SmartAdmin, everywhere you go!</h4>
						<div class="login-app-icons">
							<a class="btn btn-danger btn-sm" href="javascript:void(0);">Frontend Template</a>
							<a class="btn btn-danger btn-sm" href="javascript:void(0);">Find out more</a>
						</div>
					</div>
					
					<img style="width:210px" alt="" class="pull-right display-image" src="img/demo/iphoneview.png">

				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<h5 class="about-heading">About SmartAdmin - Are you up to date?</h5>
						<p>
							Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.
						</p>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<h5 class="about-heading">Not just your average template!</h5>
						<p>
							Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi voluptatem accusantium!
						</p>
					</div>
				</div>

			</div>
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
				<div class="well no-padding">
					{{Form::open( array( 'route'=>'session.auth.login', 'id'=>'login-form', 'class'=>'smart-form client-form', 'novalidate'=>'novalidate'))}}
						<header>
							Admin Access
						</header>

						<fieldset>
							@if (Session::get('error'))
							    <div class="alert alert-error alert-danger">{{{ Session::get('error') }}}</div>
							@endif

							@if (Session::get('notice'))
							    <div class="alert alert-info">{{{ Session::get('notice') }}}</div>
							@endif
							
							<section>
								<label class="label" for="email">{{{ Lang::get('confide::confide.e_mail') }}}</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="email" name="email" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" id="email" value="{{{ Input::old('email') }}}">
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter your admin e_mail</b></label>
							</section>

							<section>
								<label class="label" for="password">{{{ Lang::get('confide::confide.password') }}}</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" placeholder="{{{ Lang::get('confide::confide.password') }}}" name="password" id="password">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
								<!--<div class="note">
									<a href="forgotpassword.html">Forgot password?</a>
								</div>-->
							</section>

						</fieldset>
						<footer>
							<button class="btn btn-primary" type="submit">
								Grant Access
							</button>
						</footer>
					{{Form::close()}}

				</div>
				
			</div>
		</div>
	</div>

</div>

{{setinlinescript('
	<script type="text/javascript">
			//runAllForms();

			$(function() {
				// Validation
				$("#login-form").validate({
					// Rules for form validation
					rules : {
						email : {
							required : true,
							email : true
						},
						password : {
							required : true,
							minlength : 3,
							maxlength : 20
						}
					},

					// Messages for form validation
					messages : {
						email : {
							required : "Please enter your email",
							email : "Please enter a VALID email"
						},
						password : {
							required : "Please enter your password"
						}
					},

					// Do not change code below
					errorPlacement : function(error, element) {
						error.insertAfter(element.parent());
					}
				});
			});
		</script>

')}}
<div role="main" id="main">

	<!-- MAIN CONTENT -->
	<div class="container" id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">

			<div style="margin-top:-50px; margin-bottom:30px">
				<img src={{asset_vendors("bucketcodes/img/fbn_qns.png")}} alt="Questionnaire Logo">
			</div>

				<div class="well no-padding form-signin">
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
								<label class="label" for="username">{{{ Lang::get('confide::confide.username') }}}</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" name="username" placeholder="{{{ Lang::get('confide::confide.username') }}}" id="username" value="{{{ Input::old('username') }}}">
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter your admin username</b></label>
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

				$("html, #extr-page #main").css({background : "none repeat scroll 0 0 #162e4d"});

				// Validation
				$("#login-form").validate({
					// Rules for form validation
					rules : {
						username : {
							required : true
						},
						password : {
							required : true,
							minlength : 3,
							maxlength : 20
						}
					},

					// Messages for form validation
					messages : {
						username : {
							required : "Please enter your username"
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